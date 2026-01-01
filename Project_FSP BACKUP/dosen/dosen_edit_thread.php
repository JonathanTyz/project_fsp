<?php
session_start();
require_once '../class/thread.php';

/* =====================
   CEK LOGIN SAJA
===================== */
if (!isset($_SESSION['user'])) {
    die("Akses ditolak");
}

/* =====================
   AMBIL DATA
===================== */
$idgrup        = isset($_POST['idgrup']) ? (int)$_POST['idgrup'] : 0;
$idthread      = isset($_POST['idthread']) ? (int)$_POST['idthread'] : 0;
$statusSebelum = $_POST['status'] ?? '';

/* =====================
   PROSES EDIT THREAD
   (KHUSUS DOSEN)
===================== */
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
<html>
<head>
    <title>Edit Thread - Dosen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }
        .container {
            background: #fff;
            padding: 30px;
            width: 400px;
            margin: 50px auto;
        }
        h2 {
            text-align: center;
        }
        .button {
            padding: 10px 20px;
            background: #2c3e50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .center {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Thread (Dosen)</h2>

    <p>Status lama: <b><?= htmlspecialchars($statusSebelum) ?></b></p>

    <?php if (isset($error)) { ?>
        <p style="color:red;text-align:center"><?= $error ?></p>
    <?php } ?>

    <form method="post">
        <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
        <input type="hidden" name="idthread" value="<?= $idthread ?>">
        <input type="hidden" name="status" value="<?= $statusSebelum ?>">

        <p>
            <label>Status Baru:</label><br><br>
            <select name="status" required>
                <option value="Open" <?= $statusSebelum == 'Open' ? 'selected' : '' ?>>Open</option>
                <option value="Close" <?= $statusSebelum == 'Close' ? 'selected' : '' ?>>Close</option>
            </select>
        </p>

        <p class="center">
            <button type="submit" name="btnSubmit" class="button">
                Simpan
            </button>
        </p>
    </form>

    <form class="center" action="dosen_thread.php" method="get">
        <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
        <button type="submit" class="button">Kembali</button>
    </form>
</div>

</body>
</html>
