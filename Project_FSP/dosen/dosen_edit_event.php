<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_POST['idevent']) || !isset($_POST['idgrup'])) {
    header("Location: dosen_home.php");
    exit();
}

require_once '../class/event.php';
require_once '../css/theme_session.php';

$idevent = (int)$_POST['idevent'];
$idgrup  = (int)$_POST['idgrup'];

$event  = new Event();
$detail = $event->getDetailEvent($idevent)->fetch_assoc();

if (!$detail) {
    header("Location: dosen_home.php");
    exit();
}

$judul      = $detail['judul'];
$tanggal    = $detail['tanggal'];
$jenis      = $detail['jenis'];
$keterangan = $detail['keterangan'];
$poster_extension = $detail['poster_extension'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Event</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="../css/theme.css">

<style>
/* ======================
   BASE
====================== */
body{
    font-family:'Times New Roman', Times, serif;
    margin:0;
    padding:20px;
}

h2{
    text-align:center;
    font-size:32px;
    margin:10px 0;
}

/* ======================
   TITLE
====================== */
.pembukaanteks{
    font-size:24px;
    font-weight:bold;
    text-align:center;
    margin-bottom:15px;
}

/* ======================
   CONTAINER
====================== */
.isiInput{
    padding:25px 20px;
    width:420px;
    max-width:95%;
    margin:20px auto;
    border:2px solid;
    border-radius:8px;
}

/* ======================
   FORM
====================== */
label{
    display:block;
    font-weight:bold;
    margin-top:10px;
    text-align:left;
}

input[type="text"],
input[type="date"],
textarea,
select{
    width:100%;
    padding:10px;
    margin-top:6px;
    margin-bottom:15px;
    border-radius:6px;
    border:1px solid;
    font-size:16px;
}

textarea{
    resize:vertical;
}

/* ======================
   BUTTON
====================== */
button{
    width:100%;
    padding:12px;
    font-weight:bold;
    font-size:16px;
    border-radius:6px;
    border:1px solid;
    cursor:pointer;
}

.button-secondary{
    width:auto;
    padding:10px 18px;
    margin-bottom:15px;
}

/* ======================
   LIGHT THEME
====================== */
body.light{
    background:#f4f6f8;
    color:#000;
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

body.light .button-secondary{
    background:#e5e7eb;
    color:#000;
    border-color:#d1d5db;
}

/* ======================
   DARK THEME
====================== */
body.dark{
    background:#1e1e1e;
    color:#eee;
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

body.dark .button-secondary{
    background:#1e1e1e;
}

/* ======================
   RESPONSIVE
====================== */
@media (max-width:500px){
    body{
        padding:10px;
    }

    h2{
        font-size:24px;
    }

    .pembukaanteks{
        font-size:20px;
    }

    input, textarea, select{
        font-size:14px;
    }

    button{
        font-size:14px;
    }
}
</style>
</head>

<body class="<?= $themeClass ?>">

<form action="dosen_kelola_event.php" method="post" style="text-align:center;">
    <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
    <button type="submit" class="button-secondary">
        ← Kembali ke Daftar Event
    </button>
</form>

<h2 class="pembukaanteks">Edit Event</h2>

<div class="isiInput">
<form action="dosen_edit_event_proses.php" method="post" enctype="multipart/form-data">

    <input type="hidden" name="idevent" value="<?= $idevent ?>">
    <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
    <input type="hidden" name="poster_extension" value="<?= $poster_extension ?>">

    <label>Judul Event</label>
    <input type="text" name="judul" value="<?= htmlspecialchars($judul) ?>" required>

    <label>Tanggal Event</label>
    <input type="date" name="tanggal" value="<?= $tanggal ?>" required>

    <label>Jenis Event</label>
    <select name="jenis" required>
        <option value="Publik" <?= $jenis === 'Publik' ? 'selected' : '' ?>>Publik</option>
        <option value="Privat" <?= $jenis === 'Privat' ? 'selected' : '' ?>>Privat</option>
    </select>

    <label>Keterangan</label>
    <textarea name="keterangan" rows="4"><?= htmlspecialchars($keterangan) ?></textarea>

    <label>Poster Event (opsional)</label>
    <input type="file" name="foto" accept="image/jpeg,image/png">

    <button type="submit" name="btnSubmit">
        Update Event
    </button>

</form>
</div>

</body>
</html>
