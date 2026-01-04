<?php
session_start();
require_once '../css/theme_session.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

// Ambil data dari POST, fallback ke string kosong jika tidak ada
$idgrup    = $_POST['idgrup'] ?? '';
$nama      = $_POST['nama'] ?? '';
$jenis     = $_POST['jenis'] ?? '';
$deskripsi = $_POST['deskripsi'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Group</title>
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
.isiInput{
    border:5px solid;
    padding:25px 20px;
    width:600px;
    max-width:95%;
    margin:20px auto;
    text-align:center;
}
label{
    display:block;
    text-align:left;
    margin-top:10px;
    font-weight:bold;
}
input[type="text"], select{
    width:100%;
    padding:8px;
    margin-top:5px;
    margin-bottom:15px;
    border:1px solid;
    font-size:16px;
}
button{
    padding:12px 20px;
    font-weight:bold;
    font-size:16px;
    border:none;
    margin-top:10px;
    background-color:#2c3e50; /* warna button */
    color:white;
}
</style>
</head>
<body class="<?= $themeClass ?>">

<div class="isiInput">
    <h2>Edit Group</h2>

    <form method="post" action="dosen_edit_group_proses.php">
        <input type="hidden" name="idgrup" value="<?= $idgrup ?>">

        <label>Nama Group</label>
        <input type="text" name="nama" value="<?= htmlspecialchars($nama) ?>" required>

        <label>Jenis Group</label>
        <select name="jenis" required>
            <option value="">Pilih jenis grup</option>
            <option value="Privat" <?= $jenis==='Privat'?'selected':'' ?>>Privat</option>
            <option value="Publik" <?= $jenis==='Publik'?'selected':'' ?>>Publik</option>
        </select>

        <label>Deskripsi</label>
        <input type="text" name="deskripsi" value="<?= htmlspecialchars($deskripsi) ?>">

        <button type="submit">Simpan</button>
    </form>
</div>

</body>
</html>
