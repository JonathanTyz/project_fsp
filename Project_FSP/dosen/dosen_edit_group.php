<?php
session_start();
require_once '../css/theme_session.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

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
    margin:20px 0 15px;
    font-size:32px;
}

.isiInput{
    border:2px solid;
    padding:25px 20px;
    width:600px;
    max-width:95%;
    margin:30px auto;
    border-radius:8px;
}

label{
    display:block;
    margin-top:10px;
    font-weight:bold;
}

input[type="text"],
select{
    width:95%;
    padding:10px;
    margin-top:6px;
    margin-bottom:15px;
    border-radius:6px;
    border:1px solid;
    font-size:16px;
}

button{
    width:100%;
    padding:12px;
    font-weight:bold;
    font-size:16px;
    border-radius:6px;
    border:1px solid;
    cursor:pointer;
}

/* Light theme */
body.light{
    background:#f4f6f8;
    color:#000;
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
    color:#fff;
    border-color:#2c3e50;
}

/* Dark theme */
body.dark{
    background:#1e1e1e;
    color:#eee;
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
    color:#fff;
    border-color:#555;
}

/* RWD */
@media (max-width:600px){
    body{
        padding:10px;
    }

    h2{
        font-size:26px;
    }

    .isiInput{
        padding:20px 15px;
    }
}
</style>

</head>
<body class="<?= $themeClass ?>">
<div class="container-kembali">
    <a href="dosen_kelola_group.php" class="kembali">← Kembali</a>
</div>
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
