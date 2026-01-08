<?php
session_start();
require_once '../class/group.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

/* theme */
$themeClass = $_SESSION['theme'] ?? 'light';

if (!isset($_POST['idgrup'])) {
    header("Location: mahasiswa_daftar_group_join.php");
    exit();
}

$idgrup = (int)$_POST['idgrup'];
$group = new group();

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

        h2 { margin-top: 30px; font-size: 36px; }
        h3 { margin-top: 40px; }

        .center {
            text-align: center;
            margin-top: 15px;
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
            max-width: 95%;
            margin: 30px auto;
        }

        table {
            width: 90%;
            margin: 20px auto;
            background: white;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #e9ecef;
            font-weight: bold;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        .empty {
            font-weight: bold;
        }

        /* =====================
           DARK MODE
        ===================== */
        body.dark {
            background-color: #121212;
            color: #f1f1f1;
        }

        body.dark h2,
        body.dark h3 {
            color: #ffffff;
        }

        body.dark .informasiGrup,
        body.dark table {
            background-color: #1e1e1e;
        }

        body.dark th {
            background-color: #2a2a2a;
            color: #ffffff;
        }

        body.dark td {
            border-color: #444;
            color: #eeeeee;
        }

        body.dark .button {
            background-color: #3a3a3a;
        }

        body.dark .button:hover {
            background-color: #555;
        }

        body.dark .empty {
            color: #bbbbbb;
        }

        @media (max-width: 768px) {
            table, thead, tbody, tr, th, td {
                display: block;
                width: 95%;
            }

            thead {
                display: none;
            }

            table {
                border: none;
            }

            tr {
                background: white;
                border: 3px solid #2c3e50;
                margin-bottom: 15px;
                padding: 10px;
            }

            body.dark tr {
                background-color: #1e1e1e;
                border-color: #555;
            }

            td {
                border-color: 1px solid #ccc;
                text-align: left;
                padding: 6px 0;
            }

            td::before {
                font-weight: bold;
                color: #2c3e50;
                display: block;
                margin-bottom: 3px;
            }

            body.dark td::before {
                color: #cccccc;
            }
        }
    </style>
</head>

<body class="<?= $themeClass ?>">

<h2>Member Group</h2>

<div class="center">
    <form action="mahasiswa_home.php" method="post">
        <button class="button" type="submit">Kembali ke Home</button>
    </form>
    <br>
    <form action="mahasiswa_daftar_group_join.php" method="post">
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

<h3>Daftar Mahasiswa</h3>
<table>
    <tr>
        <th>Username</th>
        <th>Nama</th>
        <th>NRP</th>
        <th>Gender</th>
        <th>Angkatan</th>
        <th>Foto</th>
    </tr>
    <?php
    if ($result_mahasiswa->num_rows == 0) {
        echo "<tr><td colspan='6' class='empty'>Tidak ada mahasiswa</td></tr>";
    } else {
        while ($row = $result_mahasiswa->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['username']}</td>";
            echo "<td>{$row['nama']}</td>";
            echo "<td>{$row['nrp']}</td>";
            echo "<td>{$row['gender']}</td>";
            echo "<td>{$row['angkatan']}</td>";
            echo "<td><img src='../image_mahasiswa/{$row['nrp']}.{$row['foto_extention']}' width='100'></td>";
            echo "</tr>";
        }
    }
    ?>
</table>

<h3>Daftar Dosen</h3>
<table>
    <tr>
        <th>Username</th>
        <th>Nama</th>
        <th>NPK</th>
        <th>Foto</th>
    </tr>
    <?php
    if ($result_dosen->num_rows == 0) {
        echo "<tr><td colspan='4' class='empty'>Tidak ada dosen</td></tr>";
    } else {
        while ($row = $result_dosen->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['username']}</td>";
            echo "<td>{$row['nama']}</td>";
            echo "<td>{$row['npk']}</td>";
            echo "<td><img src='../image_dosen/{$row['npk']}.{$row['foto_extension']}' width='100'></td>";
            echo "</tr>";
        }
    }
    ?>
</table>

</body>
</html>
