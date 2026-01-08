<?php
session_start();
require_once '../class/group.php';
require_once '../css/theme_session.php';

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
        }

        body.dark {
            background-color: #1e1e1e;
            color: #eee;
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

        /* BUTTON SAMA DENGAN MAHASISWA */
        .button {
            padding: 10px 18px;
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 6px;
            margin: 5px;
            background-color: #1E40AF;
            transition: background-color 0.2s;
        }

        .button:hover {
            background-color: #1E3A8A;
        }

        .informasiGrup {
            background: white;
            padding: 25px 30px;
            width: 450px;
            max-width: 95%;
            margin: 30px auto;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        table {
            width: 90%;
            margin: 20px auto;
            background: white;
            text-align: center;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
        }

        th {
            background-color: #e9ecef;
            font-weight: bold;
        }

        img {
            max-width: 100px;
            height: auto;
            border-radius: 6px;
        }

        body.dark .informasiGrup {
            background-color: #2c2c2c;
            border-color: #555;
            color: #eee;
        }

        body.dark table {
            background-color: #2c2c2c;
            color: #eee;
        }

        body.dark th {
            background-color: #3a3a3a;
        }

        body.dark td {
            border-color: #444;
        }

        body.dark td::before {
            color: #eee;
        }

        body.dark .button {
            background-color: #555;
            color: #eee;
        }

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
                text-align: left;
                display: flex;
                align-items: center;
            }

            td::before {
                content: attr(data-label);
                font-weight: bold;
                flex-basis: 40%;
            }

            img {
                max-width: 80px;
                margin-bottom: 10px;
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
        <tr><td>Nama</td><td><?= htmlspecialchars($detail['nama']); ?></td></tr>
        <tr><td>Deskripsi</td><td><?= htmlspecialchars($detail['deskripsi']); ?></td></tr>
        <tr><td>Pembuat</td><td><?= htmlspecialchars($detail['username_pembuat']); ?></td></tr>
        <tr><td>Tanggal Dibentuk</td><td><?= htmlspecialchars($detail['tanggal_pembentukan']); ?></td></tr>
        <tr><td>Jenis</td><td><?= htmlspecialchars($detail['jenis']); ?></td></tr>
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
        echo "<tr><td colspan='4'>Tidak ada dosen</td></tr>";
    } else {
        while ($row = $result_dosen->fetch_assoc()) {
            echo "<tr>
                <td data-label='Username'>".htmlspecialchars($row['username'])."</td>
                <td data-label='Nama'>".htmlspecialchars($row['nama'])."</td>
                <td data-label='NPK'>".htmlspecialchars($row['npk'])."</td>
                <td data-label='Foto'>
                    <img src='../image_dosen/{$row['npk']}.{$row['foto_extension']}'>
                </td>
            </tr>";
        }
    }
    ?>
    </tbody>
</table>

</body>
</html>
