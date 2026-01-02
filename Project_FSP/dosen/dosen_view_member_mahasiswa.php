<?php
session_start();
require_once '../class/group.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $idgrup = (int)$_GET['id'];
} elseif (isset($_POST['idgrup'])) {
    $idgrup = (int)$_POST['idgrup'];
} else {
    header("Location: dosen_home.php");
    exit();
}

$group = new group();

$mahasiswa_search = $group->getMahasiswaNotInGroup($idgrup, $_SESSION['user']['username']);
$detail = $group->getDetailGroup($idgrup);
$result_mahasiswa = $group->getGroupMembersMahasiswa($idgrup);
$result_dosen = $group->getGroupMembersDosen($idgrup);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Member Group</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            background-color: #f4f6f8;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
            font-size: 36px;
            color: #2c3e50;
        }

        h3 {
            text-align: center;
            color: #2c3e50;
            margin-top: 40px;
        }

        .center {
            text-align: center;
            margin-top: 20px;
        }

        .button {
            padding: 10px 18px;
            background-color: #2c3e50;
            border: none;
            color: white;
            font-weight: bold;
        }

        .informasiGrup {
            background: white;
            padding: 25px 30px;
            width: 450px;
            margin: 30px auto;
        }

        table {
            width: 90%;
            margin: 20px auto;
            background: white;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #e9ecef;
        }

        .informasiGrup table {
            width: 100%;
        }
        .search-box {
            width: 300px;
            padding: 6px;
            margin: 10px auto 20px;
            display: block;
            font-family: 'Times New Roman', serif;
        }

    </style>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

</head>
<body>

<h2>Member Mahasiswa Group</h2>

<div class="center">
    <form action="dosen_home.php" method="post">
        <button class="button" type="submit">Kembali ke Home</button>
    </form>
    <br>
    <form action="dosen_kelola_group.php" method="post">
        <button class="button" type="submit">Kembali ke Daftar Group</button>
    </form>
</div>


<div class="informasiGrup">
    <table>
        <tr><th colspan="2">Informasi Group</th></tr>
        <tr><td>Nama</td><td><?= $detail['nama']; ?></td></tr>
        <tr><td>Deskripsi</td><td><?= $detail['deskripsi']; ?></td></tr>
        <tr><td>Pembuat</td><td><?= $detail['username_pembuat']; ?></td></tr>
        <tr><td>Tanggal Dibentuk</td><td><?= $detail['tanggal_pembentukan']; ?></td></tr>
        <tr><td>Jenis</td><td><?= $detail['jenis']; ?></td></tr>
    </table>
</div>

<h3>Daftar Member Mahasiswa</h3>
<table>
    <tr>
        <th>Username</th>
        <th>Nama</th>
        <th>NRP</th>
        <th>Gender</th>
        <th>Angkatan</th>
        <th>Foto</th>
        <th>Aksi</th>
    </tr>
    <?php
    if ($result_mahasiswa->num_rows == 0) {
        echo "<tr><td colspan='7' class='empty'>Tidak ada mahasiswa</td></tr>";
    } else {
        while ($row = $result_mahasiswa->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['username']}</td>";
            echo "<td>{$row['nama']}</td>";
            echo "<td>{$row['nrp']}</td>";
            echo "<td>{$row['gender']}</td>";
            echo "<td>{$row['angkatan']}</td>";
            echo "<td> <img src = '../image_mahasiswa/" . $row['nrp'] . "." . $row['foto_extention'] . "' width='100'></td>";
            echo "<td> 
                    <form action='dosen_delete_member_proses.php' method='post' style='margin:0;'>
                        <input type='hidden' name='idgrup' value='{$idgrup}'>
                        <input type='hidden' name='username' value='{$row['username']}'>
                        <input type = 'hidden' name = 'type' value = 'mahasiswa'>
                        <button type='submit' class='button'>Hapus Member</button>
                        </form>
                  </td>";
            echo "</tr>";
        }
    }
    ?>
</table>

<h3>Tambah Mahasiswa ke Group</h3>
<?php

echo "<input type='text' id = 'searchMahasiswa' class='search-box'
      placeholder='Cari berdasarkan Username / nama / NRP'>";

echo "<table id='tabelMahasiswa'>";
echo "<tr>
        <th>Username</th>
        <th>Nama</th>
        <th>NPK</th>
        <th>Foto</th>
        <th>Aksi</th>
      </tr>";

if ($mahasiswa_search->num_rows == 0) {
    echo "<tr><td colspan='5' class='empty'>Tidak ada data mahasiswa</td></tr>";
} else {
    while ($mahasiswa = $mahasiswa_search->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$mahasiswa['username']}</td>";
        echo "<td>{$mahasiswa['nama']}</td>";
        echo "<td>{$mahasiswa['nrp']}</td>";
        echo "<td><img src='../image_mahasiswa/{$mahasiswa['nrp']}.{$mahasiswa['foto_extention']}' width='100'></td>";

        echo "<td>";
        echo "<form action='dosen_insert_member_proses.php' method='post' style='margin:0;'>
                    <input type='hidden' name='idgrup' value='{$idgrup}'>
                    <input type='hidden' name='username' value='{$mahasiswa['username']}'>
                    <input type = 'hidden' name = 'type' value = 'mahasiswa'>
                    <button type='submit' class='button'>Tambah</button>
                  </form>";
                  
        echo "</td>";
        echo "</tr>";
    }
}

echo "</table>";
?>
<script>
$(document).ready(function() {
    $("#searchMahasiswa").on("keyup", function() {
        var value = $(this).val().toLowerCase();

        $("#tabelMahasiswa tr").filter(function(index) {
            if(index === 0) return true; // skip header
            $(this).toggle(
                $(this).text().toLowerCase().indexOf(value) > -1
            );
        });
    });
});
</script>

</body>
</html>
