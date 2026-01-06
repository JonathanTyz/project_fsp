<?php
session_start();
require_once '../css/theme_session.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_POST['idgrup'])) {
    header("Location: dosen_kelola_group.php");
    exit();
}

$idgrup = $_POST['idgrup'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Buat Event</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="../css/theme.css">

<style>
body{
    font-family:'Times New Roman', Times, serif;
    margin:0;
    padding:20px;
}

/* ======================
   TITLE
====================== */
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

/* ======================
   CONTAINER
====================== */
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
    margin:20px auto;
    text-align:center;
}

/* ======================
   FORM
====================== */
label{
    display:block;
    text-align:left;
    margin-top:10px;
    font-weight:bold;
}

input[type="text"],
input[type="date"],
textarea,
select{
    width:100%;
    padding:10px;
    margin-top:5px;
    margin-bottom:15px;
    border:1px solid;
    border-radius:6px;
    font-size:16px;
}

textarea{
    min-height:80px;
    resize:vertical;
}

button{
    padding:12px 20px;
    font-weight:bold;
    font-size:16px;
    border-radius:6px;
    border:1px solid;
    cursor:pointer;
}

/* ======================
   LIGHT THEME
====================== */
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
body.light textarea,
body.light select{
    background:#ffffff;
    color:#000;
    border-color:#d1d5db;
}

body.light button{
    background:#2c3e50;
    color:#fff;
    border-color:#2c3e50;
}

body.light button:hover{
    background:#1f2d3a;
}

/* ======================
   DARK THEME
====================== */
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
body.dark textarea,
body.dark select{
    background:#1e1e1e;
    color:#eee;
    border-color:#555;
}

body.dark button{
    background:#3a3a3a;
    color:#fff;
    border-color:#555;
}

body.dark button:hover{
    background:#555;
}

/* ======================
   RESPONSIVE
====================== */
@media(max-width:550px){
    h2{ font-size:24px; }
    #pembukaanteks{ font-size:18px; }
    input, textarea, select, button{
        font-size:14px;
        padding:8px;
    }
}
</style>
</head>

<body class="<?= $themeClass ?>">

<div class="center">
    <form action="dosen_kelola_event.php" method="post">
        <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
        <button type="submit">← Kembali ke Daftar Event</button>
    </form>
</div>

<div class="isiInput">
    <h2>Buat Event Baru</h2>
    <p id="pembukaanteks">Masukkan data Event</p>

    <form method="post" action="dosen_insert_event_proses.php" enctype="multipart/form-data">
        <input type="hidden" name="idgrup" value="<?= $idgrup ?>">

        <label>Judul Event</label>
        <input type="text" name="judul" required>

        <label>Tanggal Event</label>
        <input type="date" name="tanggal" required>

        <label>Keterangan</label>
        <textarea name="keterangan" required></textarea>

        <label>Jenis Event</label>
        <select name="jenis" required>
            <option value="">Pilih Jenis</option>
            <option value="Publik">Publik</option>
            <option value="Privat">Privat</option>
        </select>

        <label>Poster Event</label>
        <input type="file" name="poster" accept="image/jpeg,image/png">

        <button name="btnSimpan" value="simpan" type="submit">
            Simpan
        </button>
    </form>
</div>

</body>
</html>
