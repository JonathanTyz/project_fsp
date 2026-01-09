<?php
session_start();
require_once '../class/group.php';
require_once '../css/theme_session.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_POST['idgrup'])) {
    header("Location: dosen_home.php");
    exit();
}

$idgrup = (int)$_POST['idgrup'];
$group = new group();

$detail = $group->getDetailGroup($idgrup);
$result_mahasiswa = $group->getGroupMembersMahasiswa($idgrup);
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
        }

        h2 { margin-top: 30px; font-size: 36px; }
        h3 { margin-top: 40px; font-size: 28px; }

        .center {
            text-align: center;
            margin-top: 15px;
        }

        .button {
            padding: 10px 18px;
            border: none;
            font-weight: bold;
            margin: 5px;
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
            border: 1px solid #ccc;
        }

        table {
            width: 90%;
            margin: 20px auto;
            background: white;
            border-collapse: collapse;
            text-align: center;
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

        body.dark {
        background-color: #1e1e1e;
        color: #eee;
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
    body.dark tr {
        background-color: #2a2a2a;
        border-color: #444;
    }
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

<div class="center">
    <form action="dosen_home.php" method="post">
        <button class="button">Kembali ke Home</button>
    </form>

    <form action="dosen_group_diikuti.php" method="post">
        <button class="button">Kembali ke Daftar Group</button>
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
    echo "<tr><td colspan='6'>Tidak ada mahasiswa</td></tr>";
} else {
    while ($row = $result_mahasiswa->fetch_assoc()) {
        echo "<tr>
            <td data-label='Username'>{$row['username']}</td>
            <td data-label='Nama'>{$row['nama']}</td>
            <td data-label='NRP'>{$row['nrp']}</td>
            <td data-label='Gender'>{$row['gender']}</td>
            <td data-label='Angkatan'>{$row['angkatan']}</td>
            <td data-label='Foto'>
                <img src='../image_mahasiswa/{$row['nrp']}.{$row['foto_extention']}'>
            </td>
        </tr>";
    }
}
?>
</table>

</body>
</html>
