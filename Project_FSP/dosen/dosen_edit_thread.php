<?php
session_start();
require_once '../class/thread.php';
require_once '../css/theme_session.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$idgrup        = isset($_POST['idgrup']) ? (int)$_POST['idgrup'] : 0;
$idthread      = isset($_POST['idthread']) ? (int)$_POST['idthread'] : 0;
$statusSebelum = $_POST['status'] ?? '';

if (isset($_POST['btnSubmit'])) {
    $status = $_POST['status'];

    $thread = new Thread();
    $result = $thread->dosenEditThread($idthread, $status);

    if ($result) {
        header("Location: dosen_thread.php?idgrup=" . $idgrup);
        exit();
    } else {
        $error = "Gagal edit thread.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Thread - Dosen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- THEME -->
    <link rel="stylesheet" href="../css/theme.css">
<style>
/* ======================
   BASE
====================== */
body{
    font-family:'Times New Roman', serif;
    margin:0;
    padding:20px;
}

/* ======================
   CONTAINER
====================== */
.container{
    padding:30px;
    width:420px;
    max-width:95%;
    margin:60px auto;
    border:2px solid;
    border-radius:8px;
}

h2{
    text-align:center;
    margin-bottom:20px;
}

/* ======================
   FORM
====================== */
label{
    font-weight:bold;
}

select{
    width:100%;
    padding:10px;
    margin-top:8px;
    border-radius:6px;
    border:1px solid;
}

/* ======================
   STATUS LAMA
====================== */
.status-lama{
    padding:10px;
    margin-bottom:20px;
    border-left:6px solid;
    border-radius:6px;
}

/* ======================
   BUTTON
====================== */
button{
    width:100%;
    padding:10px;
    font-weight:bold;
    border-radius:6px;
    border:1px solid;
    cursor:pointer;
    margin-top:10px;
}

/* ======================
   ERROR
====================== */
.error{
    text-align:center;
    font-weight:bold;
    margin-bottom:10px;
}

/* ======================
   LIGHT THEME
====================== */
body.light{
    background:#f4f6f8;
    color:#000;
}

body.light .container{
    background:#ffffff;
    border-color:#d1d5db;
}

body.light select{
    background:#ffffff;
    color:#000;
    border-color:#d1d5db;
}

body.light .status-lama{
    background:#f1f5f9;
    border-color:#2c3e50;
}

body.light button{
    background:#2c3e50;
    color:#fff;
    border-color:#2c3e50;
}

body.light .btn-kembali{
    background:#e5e7eb;
    color:#000;
    border-color:#d1d5db;
}

body.light .error{
    color:#b91c1c;
}

/* ======================
   DARK THEME
====================== */
body.dark{
    background:#1e1e1e;
    color:#eee;
}

body.dark .container{
    background:#2a2a2a;
    border-color:#444;
}

body.dark select{
    background:#1e1e1e;
    color:#eee;
    border-color:#555;
}

body.dark .status-lama{
    background:#333;
    border-color:#ffffff;
}

body.dark button{
    background:#3a3a3a;
    color:#fff;
    border-color:#555;
}

body.dark .btn-kembali{
    background:#1e1e1e;
}

body.dark .error{
    color:#f87171;
}

/* ======================
   RESPONSIVE
====================== */
@media (max-width:500px){
    body{
        padding:10px;
    }

    .container{
        margin:30px auto;
        padding:20px;
    }

    h2{
        font-size:24px;
    }
}
</style>
</head>

<body class="<?= $themeClass ?>">

<div class="container">
    <h2>Edit Thread (Dosen)</h2>

    <div class="status-lama">
        Status lama: <b><?= htmlspecialchars($statusSebelum) ?></b>
    </div>

    <?php if (isset($error)) { ?>
        <p class="error"><?= $error ?></p>
    <?php } ?>

    <form method="post">
        <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
        <input type="hidden" name="idthread" value="<?= $idthread ?>">

        <p>
            <label>Status Baru:</label>
            <select name="status" required>
                <option value="Open" <?= $statusSebelum === 'Open' ? 'selected' : '' ?>>Open</option>
                <option value="Close" <?= $statusSebelum === 'Close' ? 'selected' : '' ?>>Close</option>
            </select>
        </p>

        <button type="submit" name="btnSubmit" class="btn-simpan">
            Simpan
        </button>
    </form>

    <form action="dosen_thread.php" method="get">
        <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
        <button type="submit" class="btn-kembali">
            Kembali
        </button>
    </form>
</div>

</body>
</html>
