<?php
session_start();
require_once '../class/group.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_POST['idgrup'])) {
    header("Location: mahasiswa_home.php");
    exit();
}

$idgrup = (int)$_POST['idgrup'];
$group = new group();

$detail = $group->getDetailGroup($idgrup);
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
        h3 { margin-top: 40px; font-size: 28px; }

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
            border-radius: 6px;
            margin: 5px;
            cursor: pointer;
        }

        .informasiGrup {
            background: white;
            padding: 25px 30px;
            width: 450px;
            max-width: 95%;
            margin: 30px auto;
            border-radius: 10px;
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
            border-radius: 6px;
        }

        @media (max-width: 768px) {
            table, thead, tbody, tr, th, td {
                display: block;
                width: 95%;
            }

            thead {
                display: none; 
            }

            tr {
                background: white;
                border: 2px solid #2c3e50;
                margin-bottom: 15px;
                padding: 15px;
                border-radius: 10px;
                box-shadow: 0 2px 6px rgba(0,0,0,0.15);
            }

            td {
                border: none;
                padding: 6px 0;
                text-align: left;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            td::before {
                content: attr(data-label);
                font-weight: bold;
                color: #2c3e50;
                flex-basis: 40%;
            }

            img {
                max-width: 80px;
                height: auto;
                margin-bottom: 10px;
            }

            .button {
                width: 90%;
                margin: 10px auto;
                display: block;
                text-align: center;
            }

            .informasiGrup {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            h2 { font-size: 24px; }
            h3 { font-size: 20px; }
            td { font-size: 14px; flex-direction: column; text-align: left; }
            td::before { width: 100%; margin-bottom: 4px; }
        }
    </style>
</head>
<body>

<h2>Member Group</h2>

<div class="center">
    <form action="dosen_home.php" method="post">
        <button class="button" type="submit">Kembali ke Home</button>
    </form>
    <form action="dosen_group_diikuti.php" method="post">
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

<h3>Daftar Dosen</h3>
<table>
    <thead>
        <tr>
            <th>Username</th>
            <th>Nama</th>
            <th>NPK</th>
            <th>Foto</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if ($result_dosen->num_rows == 0) {
        echo "<tr><td colspan='4' class='empty'>Tidak ada dosen</td></tr>";
    } else {
        while ($row = $result_dosen->fetch_assoc()) {
            echo "<tr>";
            echo "<td data-label='Username'>{$row['username']}</td>";
            echo "<td data-label='Nama'>{$row['nama']}</td>";
            echo "<td data-label='NPK'>{$row['npk']}</td>";
            echo "<td data-label='Foto'><img src='../image_dosen/{$row['npk']}.{$row['foto_extension']}'></td>";
            echo "</tr>";
        }
    }
    ?>
    </tbody>
</table>

</body>
</html>
