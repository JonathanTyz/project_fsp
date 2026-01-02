<?php
session_start();
require_once '../class/thread.php';

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
<html>
<head>
    <title>Edit Thread - Dosen</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 20px;
        }

        .container {
            background: white;
            padding: 30px;
            width: 420px;
            max-width: 95%;
            margin: 60px auto;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }

        .button {
            padding: 10px 20px;
            background-color: #2c3e50;
            color: white;
            border: none;
            font-weight: bold;
            width: 100%;
        }

        .button-secondary {
            padding: 10px 20px;
            background-color: #6c757d;
            color: white;
            border: none;
            font-weight: bold;
            width: 100%;
            margin-top: 10px;
        }

        .center {
            text-align: center;
        }

        .status-lama {
            background: #e9ecef;
            padding: 10px;
            border-left: 5px solid #2c3e50;
            margin-bottom: 20px;
        }

        @media (max-width: 500px) {

            body {
                padding: 10px;
            }

            .container {
                margin: 30px auto;
                padding: 20px;
            }

            h2 {
                font-size: 24px;
            }
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
