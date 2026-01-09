<?php
session_start();
require_once '../class/thread.php';
require_once '../css/theme_session.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['user']['username'];

$idgrup = $_POST['idgrup'] ?? $_GET['idgrup'] ?? 0;
$idgrup = (int)$idgrup;

$error = null;

if (isset($_POST['btnSubmit'])) {
    $status = $_POST['status'] ?? '';

    if ($idgrup <= 0 || $status === '') {
        $error = "Data tidak valid.";
    } else {
        $thread = new Thread();
        $result = $thread->createThread($idgrup, $username, $status);

        if ($result) {
            header("Location: dosen_thread.php?idgrup=" . $idgrup);
            exit();
        } else {
            $error = "Gagal membuat thread baru.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Buat Thread Baru</title>
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
    margin-bottom:20px;
}

.container{
    padding:30px;
    width:420px;
    max-width:95%;
    margin:60px auto;
    border:2px solid;
    border-radius:8px;
}

label{
    font-weight:bold;
    display:block;
    margin-bottom:6px;
}

select{
    width:100%;
    padding:10px;
    margin-bottom:15px;
    border-radius:6px;
    border:1px solid;
    font-size:16px;
}


.button{
    width:100%;
    padding:12px;
    font-weight:bold;
    border-radius:6px;
    border:1px solid;
    cursor:pointer;
}

.button-secondary{
    width:100%;
    padding:10px;
    font-weight:bold;
    border-radius:6px;
    border:1px solid;
    cursor:pointer;
    margin-top:10px;
}

/* Light Theme  */
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

body.light .button{
    background:#2c3e50;
    color:#fff;
    border-color:#2c3e50;
}

body.light .button-secondary{
    background:#e5e7eb;
    color:#000;
    border-color:#d1d5db;
}

/* Dark Theme */
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

body.dark .button{
    background:#3a3a3a;
    color:#fff;
    border-color:#555;
}

body.dark .button-secondary{
    background:#1e1e1e;
    color:#fff;
    border-color:#555;
}

/* RWD */
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
    <h2>Buat Thread Baru</h2>

    <?php if ($error): ?>
        <p style="color:red;text-align:center"><?= $error ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="idgrup" value="<?= $idgrup ?>">

        <label>Status Thread</label>
        <select name="status" required>
            <option value="">-- Pilih Status --</option>
            <option value="Open">Open</option>
            <option value="Close">Close</option>
        </select>

        <button type="submit" name="btnSubmit" class="button">
            Buat Thread
        </button>
    </form>

    <form action="dosen_thread.php" method="get">
        <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
        <button type="submit" class="button-secondary">
            ← Kembali
        </button>
    </form>
</div>

</body>
</html>
