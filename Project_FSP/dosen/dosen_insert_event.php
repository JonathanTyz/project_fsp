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

<!-- THEME -->
<link rel="stylesheet" href="../css/theme.css">

<style>
body{
    font-family: 'Times New Roman', Times, serif;
    margin: 0;
    padding: 20px;
    background-color: #f9fafb;
}

h2{
    text-align: center;
    margin-top: 20px;
    font-size: 32px;
    color: #1E3A8A;
}

#pembukaanteks{
    font-size: 22px;
    text-decoration: underline;
    font-weight: bold;
    text-align: center;
    margin-bottom: 20px;
    color: #1E40AF;
}

.isiInput{
    border: 2px solid #1E40AF;
    border-radius: 10px;
    padding: 25px 20px;
    width: 600px;
    max-width: 95%;
    margin: 20px auto;
    text-align: center;
    background-color: #fff;
}

label{
    display: block;
    text-align: left;
    margin-top: 10px;
    font-weight: bold;
}

input[type="text"],
input[type="date"],
textarea,
select{
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 15px;
    border: 1px solid #1E40AF;
    border-radius: 6px;
    font-size: 16px;
}

textarea{
    min-height: 80px;
}

button{
    padding: 12px 20px;
    font-weight: bold;
    font-size: 16px;
    border: none;
    border-radius: 6px;
    background-color: #1E40AF;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.2s;
}

button:hover{
    background-color: #1E3A8A;
}

@media (max-width: 550px){
    h2{ font-size: 24px; }
    #pembukaanteks{ font-size: 18px; }
    input, textarea, select, button{
        font-size: 14px;
        padding: 8px;
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
