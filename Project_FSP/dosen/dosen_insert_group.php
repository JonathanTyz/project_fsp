<?php
// koneksi database
$mysqli = new mysqli("localhost", "root", "", "fullstack");

session_start();
require_once '../css/theme_session.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

if ($mysqli->connect_error) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Buat Grup</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="../css/theme.css">

<style>
body{
    font-family:'Times New Roman', Times, serif;
    margin:0;
    padding:20px;
}

h2{
    text-align:center;
    margin-top:20px;
    font-size:32px;
}

#pembukaanteks{
    font-size:22px;
    text-decoration:underline;
    font-weight:bold;
    text-align:center;
    margin-bottom:20px;
}

.center{
    text-align:center;
    margin-bottom:20px;
}

.isiInput{
    border:1px solid;
    border-radius:10px;
    padding:25px 20px;
    width:600px;
    max-width:95%;
    margin:0 auto 30px auto;
    text-align:center;
}


label{
    display:block;
    text-align:left;
    margin-top:10px;
    font-weight:bold;
}

input[type="text"],
select{
    width:95%;
    padding:10px;
    margin-top:5px;
    margin-bottom:15px;
    border:1px solid;
    border-radius:6px;
    font-size:16px;
}

button{
    padding:12px 20px;
    font-weight:bold;
    font-size:16px;
    border-radius:6px;
    border:1px solid;
    cursor:pointer;
}

body.light{
    background:#f4f6f8;
    color:#000;
}

body.light h2,
body.light #pembukaanteks{
    color:#2c3e50;
}

body.light .isiInput{
    background:#ffffff;
    border-color:#d1d5db;
}

body.light input,
body.light select{
    background:#ffffff;
    color:#000;
    border-color:#d1d5db;
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

body.dark h2,
body.dark #pembukaanteks{
    color:#ffffff;
}

body.dark .isiInput{
    background:#2a2a2a;
    border-color:#444;
}

body.dark input,
body.dark select{
    background:#1e1e1e;
    color:#eee;
    border-color:#555;
}

body.dark button{
    background:#3a3a3a;
    color:white;
    border-color:#555;
}

body.dark button:hover{
    background:#555;
}

@media(max-width:650px){
    h2{ font-size:24px; }
    #pembukaanteks{ font-size:18px; }
    input, select, button{
        font-size:14px;
        padding:8px;
    }
}
</style>
</head>

<body class="<?= $themeClass ?>">

<div class="center">
    <form action="dosen_kelola_group.php" method="post">
        <button type="submit">← Kembali ke Daftar Group</button>
    </form>
</div>

<div class="isiInput">
    <h2>Buat Grup</h2>
    <p id="pembukaanteks">Masukkan data untuk pembuatan grup</p>

    <form method="post" action="dosen_insert_group_proses.php">
        <label>Nama Grup</label>
        <input type="text" name="name" required>

        <label>Deskripsi Grup</label>
        <input type="text" name="deskripsi">

        <label>Jenis Grup</label>
        <select name="jenis" required>
            <option value="">Pilih jenis grup</option>
            <option value="Privat">Privat</option>
            <option value="Publik">Publik</option>
        </select>

        <button name="btnSimpan" value="simpan" type="submit">
            Simpan
        </button>
    </form>
</div>

</body>
</html>
