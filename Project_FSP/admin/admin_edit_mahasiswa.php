<?php
$mysqli = new mysqli("localhost", "root", "", "fullstack");
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

session_start();
require_once '../css/theme_session.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['nrp'])) {
    echo "<p>NRP tidak ditemukan di URL.</p>";
    echo "<p style='text-align:center;'><a href='admin_mahasiswa.php'>Kembali</a></p>";
    exit;
}

$id = $_GET['nrp'];

$sql = "SELECT m.nrp, m.nama, m.gender, m.tanggal_lahir, m.angkatan, m.foto_extention,
               a.username, a.password
        FROM mahasiswa m
        INNER JOIN akun a ON m.nrp = a.nrp_mahasiswa
        WHERE m.nrp = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$stmt->close();

if (!$row) {
    echo "<p>Data mahasiswa tidak ditemukan.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Edit Data Mahasiswa</title>

<link rel="stylesheet" href="../css/theme.css">

<style>
body{
    font-family:'Times New Roman', serif;
    margin:0;
    padding:20px;
}

.isiInput{
    padding:30px 40px;
    width:400px;
    margin:30px auto;
    border-radius:8px;
    border:2px solid;
}

h2{
    text-align:center;
}

label{
    font-weight:bold;
}

input, select{
    width:100%;
    padding:8px;
    margin-top:5px;
}

button{
    width:100%;
    padding:12px;
    font-size:18px;
    font-weight:bold;
    border-radius:6px;
    border:1px solid;
}

.center{
    text-align:center;
}

/* ======================
   LIGHT THEME
====================== */
body.light{
    background:#f4f6f8;
    color:#000;
}

body.light .isiInput{
    background:lightcyan;
    border-color:#333;
}

body.light button{
    background:#2c3e50;
    color:white;
    border-color:#2c3e50;
}

body.light button:hover{
    background:#1f2d3a;
}

body.dark{
    background:#1e1e1e;
    color:#eee;
}

body.dark .isiInput{
    background:#2a2a2a;
    border-color:#555;
}

body.dark input,
body.dark select{
    background:#1e1e1e;
    color:white;
    border:1px solid #555;
}

body.dark button{
    background:#3a3a3a;
    color:white;
    border-color:#555;
}

body.dark button:hover{
    background:#555;
}

@media(max-width:500px){
    .isiInput{
        width:90%;
    }
}
</style>
</head>

<body class="<?= $themeClass ?>">

<div class="center">
    <form action="admin_mahasiswa.php" method="post">
        <button type="submit">← Kembali ke Home</button>
    </form>
</div>

<div class="isiInput">
<h2>Edit Data Mahasiswa</h2>

<form method="post" action="admin_edit_proses_mahasiswa.php" enctype="multipart/form-data">

    <p>
        <label>Username</label>
        <input type="text" name="username" value="<?= $row['username']; ?>">
    </p>

    <p>
        <label>NRP</label>
        <input type="text" name="nrp" value="<?= $row['nrp']; ?>">
    </p>

    <p>
        <label>Nama</label>
        <input type="text" name="nama" value="<?= $row['nama']; ?>">
    </p>

    <p>
        <label>Gender</label>
        <select name="gender">
            <option value="Pria" <?= $row['gender']=='Pria'?'selected':''; ?>>Pria</option>
            <option value="Wanita" <?= $row['gender']=='Wanita'?'selected':''; ?>>Wanita</option>
        </select>
    </p>

    <p>
        <label>Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" value="<?= $row['tanggal_lahir']; ?>">
    </p>

    <p>
        <label>Angkatan</label>
        <input type="number" name="angkatan" value="<?= $row['angkatan']; ?>">
    </p>

    <p>
        <label>Foto</label>
        <input type="file" name="foto" accept="image/jpeg,image/png">
    </p>

    <input type="hidden" name="nrp_lama" value="<?= $row['nrp']; ?>">
    <input type="hidden" name="username_lama" value="<?= $row['username']; ?>">
    <input type="hidden" name="ext_lama" value="<?= $row['foto_extention']; ?>">

    <button type="submit" name="btnEdit">Simpan</button>
</form>
</div>

</body>
</html>
