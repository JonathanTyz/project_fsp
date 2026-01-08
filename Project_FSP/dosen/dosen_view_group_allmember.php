<?php
session_start();
require_once '../class/group.php';
require_once '../css/theme_session.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_POST['idgrup'])) {
    header("Location: mahasiswa_daftar_group_join.php");
    exit();
}

$idgrup = (int)$_POST['idgrup'];
$group = new Group();

$detail = $group->getDetailGroup($idgrup);
$result_mahasiswa = $group->getGroupMembersMahasiswa($idgrup);
$result_dosen = $group->getGroupMembersDosen($idgrup);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Member Group</title>
    <link rel="stylesheet" href="../css/theme.css">

    <style>
        body {
            font-family: "Segoe UI", Tahoma, sans-serif;
            margin: 0;
        }

        h2, h3 {
            text-align: center;
            color: #1f2937;
        }

        h2 {
            margin-top: 30px;
            font-size: 34px;
        }

        h3 {
            margin-top: 50px;
            font-size: 26px;
        }

        /* ===== BUTTON ===== */
        .btn-group {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 25px 0;
            flex-wrap: wrap;
        }

        .button {
            padding: 12px 22px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            color: #fff;
            background-color: #2563eb;
            cursor: pointer;
            transition: 0.2s;
        }

        .button:hover {
            background-color: #1e40af;
            transform: translateY(-1px);
        }

        /* ===== CARD ===== */
        .card {
            border-radius: 12px;
            padding: 25px;
            width: 500px;
            max-width: 95%;
            margin: 30px auto;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        /* ===== TABLE ===== */
        table {
            width: 90%;
            margin: 25px auto;
            border-radius: 10px;
        }

        th, td {
            padding: 12px 14px;
            border-bottom: 1px solid #e5e7eb;
            text-align: center;
        }

        th {
            font-weight: 700;
        }

        tr:last-child td {
            border-bottom: none;
        }

        /* ===== IMAGE ===== */
        img {
            width: 90px;
            border-radius: 8px;
        }

        /* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
            table, thead, tbody, tr, th, td {
                display: block;
                width: 95%;
            }

            thead { display: none; }

            tr {
                border: 2px solid #2c3e50;
                margin-bottom: 15px;
                padding: 15px;
                border-radius: 10px;
            }

            td {
                padding: 6px 0;
                display: flex;
                align-items: center;
            }

            td::before {
                content: attr(data-label);
                font-weight: bold;
                flex-basis: 40%;
            }

            .button {
                width: 90%;
                margin: 10px auto;
                display: block;
            }

            .informasiGrup {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            h2 { font-size: 24px; }
            h3 { font-size: 20px; }

            td {
                font-size: 14px;
                flex-direction: column;
                text-align: left;
            }

            td::before {
                width: 100%;
                margin-bottom: 4px;
            }
        }
    </style>
</head>

<body class="<?= $themeClass ?>">

<h2>Member Group</h2>

<div class="btn-group">
    <form action="dosen_home.php" method="post">
        <button class="button" type="submit">Home</button>
    </form>

    <form action="dosen_group_diikuti.php" method="post">
        <button class="button" type="submit">Daftar Group</button>
    </form>
</div>

<div class="card">
    <table>
        <tr>
            <th colspan="2">Informasi Group</th>
        </tr>
        <tr>
            <td>Nama</td>
            <td><?= ($detail['nama']) ?></td>
        </tr>
        <tr>
            <td>Deskripsi</td>
            <td><?= ($detail['deskripsi']) ?></td>
        </tr>
        <tr>
            <td>Pembuat</td>
            <td><?= ($detail['username_pembuat']) ?></td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td><?= ($detail['tanggal_pembentukan']) ?></td>
        </tr>
        <tr>
            <td>Jenis</td>
            <td><?= ($detail['jenis']) ?></td>
        </tr>
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

    <?php if ($result_mahasiswa->num_rows == 0): ?>
        <tr>
            <td colspan="6">Tidak ada mahasiswa</td>
        </tr>
    <?php else: ?>
        <?php while ($row = $result_mahasiswa->fetch_assoc()): ?>
            <tr>
                <td data-label="Username"><?= ($row['username']) ?></td>
                <td data-label="Nama"><?= ($row['nama']) ?></td>
                <td data-label="NRP"><?= ($row['nrp']) ?></td>
                <td data-label="Gender"><?= ($row['gender']) ?></td>
                <td data-label="Angkatan"><?= ($row['angkatan']) ?></td>
                <td data-label="Foto">
                    <img src="../image_mahasiswa/<?= $row['nrp'] ?>.<?= $row['foto_extention'] ?>">
                </td>
            </tr>
        <?php endwhile; ?>
    <?php endif; ?>
</table>

<h3>Daftar Dosen</h3>

<table>
    <tr>
        <th>Username</th>
        <th>Nama</th>
        <th>NPK</th>
        <th>Foto</th>
    </tr>

    <?php if ($result_dosen->num_rows == 0): ?>
        <tr>
            <td colspan="4">Tidak ada dosen</td>
        </tr>
    <?php else: ?>
        <?php while ($row = $result_dosen->fetch_assoc()): ?>
            <tr>
                <td data-label="Username"><?= ($row['username']) ?></td>
                <td data-label="Nama"><?= ($row['nama']) ?></td>
                <td data-label="NPK"><?= ($row['npk']) ?></td>
                <td data-label="Foto">
                    <img src="../image_dosen/<?= $row['npk'] ?>.<?= $row['foto_extension'] ?>">
                </td>
            </tr>
        <?php endwhile; ?>
    <?php endif; ?>
</table>

</body>
</html>
