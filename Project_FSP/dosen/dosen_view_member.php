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
$result_dosen = $group->getGroupMembersDosen($idgrup);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Member Group</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="../css/theme.css">

<style>
body{
    font-family: 'Times New Roman', serif;
    margin: 0;
}

h2{
    text-align: center;
    margin-top: 30px;
    font-size: 36px;
}

h3{
    text-align: center;
    margin-top: 40px;
    font-size: 28px;
}

.center{
    text-align: center;
    margin-top: 15px;
}

.button{
    padding: 10px 18px;
    font-weight: bold;
    border: none;
    margin: 6px;
}

.informasiGrup{
    padding: 25px 30px;
    width: 450px;
    max-width: 95%;
    margin: 30px auto;
    border: 4px solid;
}

table{
    width: 90%;
    margin: 20px auto;
    border-collapse: collapse;
    border: 4px solid;
}

th, td{
    border: 1px solid;
    padding: 10px;
    text-align: center;
}

th{
    font-weight: bold;
}

.empty{
    text-align: center;
    font-style: italic;
}

img{
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
        <button class="button" type="submit">Kembali ke Home</button>
    </form>

    <form action="dosen_kelola_group.php" method="post">
        <button class="button" type="submit">Kembali ke Daftar Group</button>
    </form>
</div>

<div class="informasiGrup">
<table>
    <tr><th colspan="2">Informasi Group</th></tr>
    <tr><td>Nama</td><td><?= htmlspecialchars($detail['nama']) ?></td></tr>
    <tr><td>Deskripsi</td><td><?= htmlspecialchars($detail['deskripsi']) ?></td></tr>
    <tr><td>Pembuat</td><td><?= htmlspecialchars($detail['username_pembuat']) ?></td></tr>
    <tr><td>Tanggal Dibentuk</td><td><?= $detail['tanggal_pembentukan'] ?></td></tr>
    <tr><td>Jenis</td><td><?= $detail['jenis'] ?></td></tr>
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
        echo "
        <tr>
            <td data-label='Username'>{$row['username']}</td>
            <td data-label='Nama'>{$row['nama']}</td>
            <td data-label='NRP'>{$row['nrp']}</td>
            <td data-label='Gender'>{$row['gender']}</td>
            <td data-label='Angkatan'>{$row['angkatan']}</td>
            <td data-label='Foto'>
                <img src='../image_mahasiswa/{$row['nrp']}.{$row['foto_extention']}' width='100'>
            </td>
        </tr>";
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
        echo "
        <tr>
            <td data-label='Username'>{$row['username']}</td>
            <td data-label='Nama'>{$row['nama']}</td>
            <td data-label='NPK'>{$row['npk']}</td>
            <td data-label='Foto'>
                <img src='../image_dosen/{$row['npk']}.{$row['foto_extension']}' width='100'>
            </td>
        </tr>";
    }
}
?>
</table>

</body>
</html>
