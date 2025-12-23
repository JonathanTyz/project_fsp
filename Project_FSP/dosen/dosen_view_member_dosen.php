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
$dosen_search = $group->getDosenNotInGroup($idgrup, $_SESSION['user']['username']);
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

        h2, h3 {
            text-align: center;
            color: #2c3e50;
        }

        .center {
            text-align: center;
            margin-top: 20px;
        }

        .button {
            padding: 8px 16px;
            background-color: #2c3e50;
            border: none;
            color: white;
            font-weight: bold;
        }

        .button:disabled {
            background-color: #aaa;
        }

        .informasiGrup {
            background: white;
            padding: 20px;
            width: 450px;
            margin: 30px auto;
        }

        table {
            width: 90%;
            margin: 15px auto;
            background: white;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #e9ecef;
        }

        .search-box {
            width: 300px;
            padding: 6px;
            margin: 10px auto 20px;
            display: block;
            font-family: 'Times New Roman', serif;
        }
        .empty
        {
            text-align: center;
            font-style: italic;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>
<body>

<h2>Member Dosen Group</h2>

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

<h3>Daftar Member Dosen</h3>
<table>
    <tr>
        <th>Username</th>
        <th>Nama</th>
        <th>NPK</th>
        <th>Foto</th>
        <th>Aksi</th>
    </tr>
    <?php
    if ($result_dosen->num_rows == 0) {
        echo "<tr><td colspan='5' class='empty'>Tidak ada dosen</td></tr>";
    } else {
        while ($row = $result_dosen->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['username']}</td>";
            echo "<td>{$row['nama']}</td>";
            echo "<td>{$row['npk']}</td>";
            echo "<td> <img src = '../image_dosen/" . $row['npk'] . "." . $row['foto_extension'] . "' width='100'></td>";
            echo "<td>
                    <form action='dosen_delete_member_proses.php' method='post' style='margin:0;'>
                        <input type='hidden' name='idgrup' value='{$idgrup}'>
                        <input type='hidden' name='username' value='{$row['username']}'>
                        <input type = 'hidden' name = 'type' value = 'dosen'>
                        <button type='submit' class='button'>Hapus Member</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
    }
    ?>
</table>

<h3>Tambah Dosen ke Group</h3>
<?php

echo "<input type='text' id = 'searchDosen' class='search-box'
      placeholder='Cari berdasarkan Username / nama / NPK'>";

echo "<table id='tabelDosen'>";
echo "<tr>
        <th>Username</th>
        <th>Nama</th>
        <th>NPK</th>
        <th>Foto</th>
        <th>Aksi</th>
      </tr>";

if ($dosen_search->num_rows == 0) {
    echo "<tr><td colspan='5' class='empty'>Tidak ada data dosen</td></tr>";
} else {
    while ($dosen = $dosen_search->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$dosen['username']}</td>";
        echo "<td>{$dosen['nama']}</td>";
        echo "<td>{$dosen['npk']}</td>";
        echo "<td><img src='../image_dosen/{$dosen['npk']}.{$dosen['foto_extension']}' width='100'></td>";

        echo "<td>";
        echo "<form action='dosen_insert_member_proses.php' method='post' style='margin:0;'>
                    <input type='hidden' name='idgrup' value='{$idgrup}'>
                    <input type='hidden' name='username' value='{$dosen['username']}'>
                    <input type = 'hidden' name = 'type' value = 'dosen'>
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
    $("#searchDosen").on("keyup", function() {
        var value = $(this).val().toLowerCase();

        $("#tabelDosen tr").filter(function(index) {
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
