<?php
session_start();
require_once '../css/theme_session.php';
require_once '../class/dosen.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['npk'])) {
    header("Location: admin_dosen.php");
    exit();
}

$dosen = new dosen();
$row = $dosen->getDetailDosen($_GET['npk']);

if (!$row) {
    echo "Data dosen tidak ditemukan";
    exit();
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Edit Data Dosen</title>

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

input[type=text], input[type=file]{
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

body.dark input{
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

@media (max-width:500px){
    body{
        padding:12px;
    }

    .isiInput{
        padding:20px;
    }

    h2{
        font-size:20px;
    }

    button{
        font-size:15px;
        padding:11px;
    }
}
</style>
</head>

<body class="<?= $themeClass ?>">

<div class="center">
    <form action="admin_dosen.php" method="post">
        <button type="submit">← Kembali ke Home</button>
    </form>
</div>

<div class="isiInput">
<h2>Edit Data Dosen</h2>

<form method="post" action="admin_edit_proses_dosen.php" enctype="multipart/form-data">
    <p><b>Dosen yang diedit:</b> <?= htmlspecialchars($row['nama']) ?></p>

    <p>
        <label>Username</label>
        <input type="text" name="username" value="<?= $row['username'] ?>">
    </p>

    <p>
        <label>NPK</label>
        <input type="text" name="npk" value="<?= $row['npk'] ?>">
    </p>

    <p>
        <label>Nama</label>
        <input type="text" name="nama" value="<?= $row['nama'] ?>">
    </p>

    <p>
        <label>Foto</label>
        <input type="file" name="foto" accept="image/jpeg,image/png">
    </p>

    <input type="hidden" name="npk_lama" value="<?= $row['npk'] ?>">
    <input type="hidden" name="username_lama" value="<?= $row['username'] ?>">
    <input type="hidden" name="ext_lama" value="<?= $row['foto_extension'] ?>">

    <button type="submit" name="btnEdit">Simpan</button>
</form>
</div>

</body>
</html>
