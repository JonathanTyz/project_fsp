<?php
session_start();
require_once '../class/thread.php';
require_once '../css/theme_session.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['user']['username'];
$idgrup   = isset($_POST['idgrup']) ? (int)$_POST['idgrup'] : 0;

if (isset($_POST['btnSubmit'])) {
    $status = $_POST['status'];

    $thread = new Thread();
    $result = $thread->createThread($idgrup, $username, $status);

    if ($result) {
        header("Location: dosen_thread.php?idgrup=" . $idgrup);
        exit();
    } else {
        $error = "Gagal membuat thread baru.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Thread Baru</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- THEME -->
    <link rel="stylesheet" href="../css/theme.css">

    <style>
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 20px;
        }

        .container {
            padding: 30px;
            width: 420px;
            max-width: 95%;
            margin: 60px auto;
            border: 4px solid;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 8px;
            margin-top: 8px;
            margin-bottom: 15px;
        }

        /* =====================
           BUTTON STYLE (FINAL)
        ====================== */

        /* Tombol UTAMA */
        .button {
            padding: 12px 20px;
            font-weight: bold;
            border: none;
            width: 100%;
            margin-top: 10px;
            background-color: darkslategray;
            color: white;
            cursor: pointer;
        }

        .button:hover {
            opacity: 0.9;
        }

        /* Tombol KEMBALI */
        .button-secondary {
            padding: 10px 20px;
            font-weight: bold;
            border: none;
            width: 100%;
            margin-top: 10px;
            background-color: steelblue;
            color: white;
            cursor: pointer;
        }

        .button-secondary:hover {
            opacity: 0.9;
        }

        @media (max-width: 500px) {
            body {
                padding: 10px;
            }

            .container {
                margin: 30px auto;
                padding: 20px;
                width: 100%;
            }

            h2 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body class="<?= $themeClass ?>">

<div class="container">
    <h2>Buat Thread Baru</h2>

    <?php if (isset($error)) { ?>
        <p style="color:red;text-align:center"><?= $error ?></p>
    <?php } ?>

    <form method="post">
        <input type="hidden" name="idgrup" value="<?= $idgrup ?>">

        <label>Status Thread:</label>
        <select name="status" required>
            <option value="Open">Open</option>
            <option value="Close">Close</option>
        </select>

        <button type="submit" name="btnSubmit" class="button">
            Buat Thread
        </button>
    </form>

    <form action="dosen_thread.php" method="post">
        <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
        <button type="submit" class="button-secondary">
            Kembali
        </button>
    </form>
</div>

</body>
</html>
