<?php
session_start();
require_once 'class/group.php';

// Cek login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
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
$result_dosen = $group->getGroupMembersDosen($idgrup);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Member Group</title>
    <style>
        body{
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
        }
        h2{
            text-align: center;
            margin-top: 30px;
            color: #333;
            font-size: 32px;
            font-weight: bold;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border: 10px solid #333;
            background: white;
        }
        th, td {
            border: 1px solid black; 
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2; 
        }
        .back {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background: #333;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>Member Group: <?php echo $detail['nama']; ?></h2>

<h2>Daftar Mahasiswa</h2>
<table>
    <thead>
        <tr>
            <th>Username</th>
            <th>Nama</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if ($result_mahasiswa->num_rows == 0) {
            echo "<tr><td colspan='2'>Tidak ada mahasiswa</td></tr>";
        } else {
            while ($row = $result_mahasiswa->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['username']}</td>";
                echo "<td>{$row['nama']}</td>";
                echo "</tr>";
            }
        }
        ?>
    </tbody>
</table>

<h2>Daftar Dosen</h2>
<table>
    <thead>
        <tr>
            <th>Username</th>
            <th>Nama</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if ($result_dosen->num_rows == 0) {
            echo "<tr><td colspan='2'>Tidak ada dosen</td></tr>";
        } else {
            while ($row = $result_dosen->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['username']}</td>";
                echo "<td>{$row['nama']}</td>";
                echo "</tr>";
            }
        }
        ?>
    </tbody>
</table>

<a class = "back" href="dosen_home.php">Kembali</a>

</body>
</html>
