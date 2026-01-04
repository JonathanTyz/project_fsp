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
            color: #2c3e50;
        }

        h2 { margin-top: 30px; font-size: 36px; }
        h3 { margin-top: 40px; font-size: 28px; }

        .center {
            text-align: center;
            margin-top: 15px;
        }

        /* Tombol konsisten dengan warna biru home */
        .button {
            padding: 10px 18px;
            background-color: #1E40AF; /* biru */
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 6px;
            margin: 5px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .button:hover {
            background-color: #1E3A8A; /* lebih gelap saat hover */
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
            text-align: left;
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

            thead { display: none; }

            tr {
                background: white;
                border: 2px solid #2c3e50;
                margin-bottom: 15px;
                padding: 15px;
                border-radius: 10px;
            }

            td {
                border: none;
                padding: 6px 0;
                text-align: left;
                display: flex;
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
    <form action="mahasiswa_home.php" method="post">
        <button class="button" type="submit">Kembali ke Home</button>
    </form>
    <br>
    <form action="mahasiswa_group_diikuti.php" method="post">
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
            echo "<td data-label='Username'>" . htmlspecialchars($row['username']) . "</td>";
            echo "<td data-label='Nama'>" . htmlspecialchars($row['nama']) . "</td>";
            echo "<td data-label='NRP'>" . htmlspecialchars($row['nrp']) . "</td>";
            echo "<td data-label='Gender'>" . htmlspecialchars($row['gender']) . "</td>";
            echo "<td data-label='Angkatan'>" . htmlspecialchars($row['angkatan']) . "</td>";
            echo "<td data-label='Foto'><img src='../image_mahasiswa/" . $row['nrp'] . "." . $row['foto_extention'] . "' alt='Foto'></td>";
            echo "</tr>";
        }
    }
    ?>
</table>

</body>
</html>
