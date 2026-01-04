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

$idevent    = $_POST['idevent'];
$idgrup     = $_POST['idgrup'];
$judul      = $_POST['judul'];
$tanggal    = $_POST['tanggal'];
$jenis      = $_POST['jenis'];
$keterangan = $_POST['keterangan'];

$event = new Event();
$detail = $event->getDetailEvent($idevent)->fetch_assoc();
$poster_extension = $detail['poster_extension'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Event</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- THEME -->
    <link rel="stylesheet" href="../css/theme.css">

    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            font-size: 32px;
        }

        .pembukaanteks {
            font-size: 24px;
            text-decoration: underline;
            font-weight: bold;
            text-align: center;
        }

        .isiInput {
            padding: 25px 20px;
            width: 400px;
            max-width: 90%;
            margin: 20px auto;
            text-align: center;
            border: 4px solid;
        }

        label {
            display: block;
            text-align: left;
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            font-size: 16px;
        }

        /* =====================
           BUTTON STYLE (FINAL)
        ====================== */

        /* Tombol UTAMA */
        .button {
            padding: 12px 20px;
            font-weight: bold;
            font-size: 16px;
            border: none;
            width: 100%;
            margin-top: 10px;
            background-color: darkslategray; /* Kelola Group */
            color: white;
            cursor: pointer;
        }

        .button:hover {
            opacity: 0.9;
        }

        /* Tombol KEMBALI */
        .button-secondary {
            padding: 10px 18px;
            font-weight: bold;
            border: none;
            margin-bottom: 15px;
            background-color: steelblue; /* Group Publik */
            color: white;
            cursor: pointer;
        }

        .button-secondary:hover {
            opacity: 0.9;
        }

        @media (max-width: 500px) {
            h2 {
                font-size: 24px;
            }

            .pembukaanteks {
                font-size: 20px;
            }

            input, textarea, select {
                font-size: 14px;
            }

            .button, .button-secondary {
                font-size: 14px;
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
    <h3>Lakukan Edit Event</h3>

    <form action="dosen_edit_event_proses.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idevent" value="<?= $idevent ?>">
        <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
        <input type="hidden" name="poster_extension" value="<?= $poster_extension ?>">

        <label>Judul Event:</label>
        <input type="text" name="judul" value="<?= htmlspecialchars($judul) ?>" required>

        <label>Tanggal Event:</label>
        <input type="date" name="tanggal" value="<?= $tanggal ?>" required>

        <label>Jenis Event:</label>
        <select name="jenis" required>
            <option value="Publik" <?= $jenis == "Publik" ? "selected" : "" ?>>Publik</option>
            <option value="Privat" <?= $jenis == "Privat" ? "selected" : "" ?>>Privat</option>
        </select>

        <label>Keterangan:</label>
        <textarea name="keterangan" rows="4"><?= htmlspecialchars($keterangan) ?></textarea>

        <label>Poster Event (opsional):</label>
        <input type="file" name="foto" accept="image/jpeg,image/png">

        <button type="submit" name="btnSubmit" class="button">
            Update Event
        </button>
    </form>
</div>

</body>
</html>
