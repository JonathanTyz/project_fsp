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
        body{
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 20px;
        }

        .container{
            padding: 30px;
            width: 420px;
            max-width: 95%;
            margin: 60px auto;
            border: 4px solid;
        }

        h2{
            text-align: center;
            margin-bottom: 20px;
        }

        label{
            font-weight: bold;
        }

        select{
            width: 100%;
            padding: 10px;
            margin-top: 8px;
        }

        /* ===== STATUS LAMA ===== */
        .status-lama{
            padding: 10px;
            margin-bottom: 20px;
            border-left: 6px solid steelblue;
            background-color: rgba(70,130,180,0.1);
        }

        /* ===== BUTTON GLOBAL ===== */
        button{
            padding: 10px;
            font-weight: bold;
            width: 100%;
            border: none;
            cursor: pointer;
            color: white;
            margin-top: 10px;
        }

        button:hover{
            opacity: 0.9;
        }

        /* ===== WARNA SESUAI HOME ===== */
        .btn-simpan{
            background-color: darkslategray; /* Kelola Group */
        }

        .btn-kembali{
            background-color: steelblue; /* Group Publik */
        }

        .error{
            color: red;
            text-align: center;
            font-weight: bold;
        }

        @media (max-width: 500px){
            body{
                padding: 10px;
            }

            .container{
                margin: 30px auto;
                padding: 20px;
            }

            h2{
                font-size: 24px;
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
