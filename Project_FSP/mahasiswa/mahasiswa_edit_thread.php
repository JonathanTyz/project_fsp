<?php
session_start();
require_once '../class/thread.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['user']['username'];
$idgrup = isset($_POST['idgrup']) ? (int)$_POST['idgrup'] : 0;
$statusSebelum = $_POST['status'];
$idthread = $_POST['idthread'];

/* ambil theme dari session */
$themeClass = $_SESSION['theme'] ?? 'light';

if (isset($_POST['btnSubmit'])) {
    $status = $_POST['status']; 

    $thread = new Thread();
    $result = $thread->editThread($idthread, $username, $status);

    if ($result) {
        header("Location: mahasiswa_thread.php?idgrup=" . $idgrup);
        exit();
    } else {
        $error = "Gagal edit thread.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ubah Thread</title>

    <!-- THEME -->
    <link rel="stylesheet" href="../css/theme.css">

    <style>
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 20px;
        }

        .container {
            background: #ffffff;
            padding: 30px;
            width: 420px;
            max-width: 95%;
            margin: 60px auto;
        }

        body.dark .container{
            background: #2a2a2a;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        body.dark h2{
            color: #ffffff;
        }

        p {
            margin-bottom: 15px;
            color: #333;
        }

        body.dark p{
            color: #eee;
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
            cursor: pointer;
        }

        .button-secondary {
            padding: 10px 20px;
            background-color: #6c757d;
            color: white;
            border: none;
            font-weight: bold;
            width: 100%;
            margin-top: 10px;
            cursor: pointer;
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

        body.dark .status-lama{
            background: #333;
            border-left-color: #888;
            color: #eee;
        }

        /* RWD */
        @media (max-width:600px)
        {
            body{
                padding:10px;
            }

            .container{
                margin:20px auto;
                padding:15px;
                border-width:1px;
            }

            h2{
                font-size:20px;
            }

            label, .status-lama, .error{
                font-size:14px;
            }

            select, button{
                font-size:14px;
                padding:8px;
            }
        }
    </style>
</head>

<body class="<?= $themeClass ?>">

<div class="container">
    <h2>Edit Thread</h2>
    <p>Status lama: <?php echo $statusSebelum ?></p>

    <form method="post" action="">
        <input type="hidden" name="idgrup" value="<?= $idgrup; ?>">
        <input type="hidden" name="idthread" value="<?= $idthread; ?>">

        <p>
            <label>Ubah Status Thread:</label><br><br>
            <select name="status" required>
                <option value="Open" selected>Open</option>
                <option value="Close">Close</option>
            </select>
        </p>

        <p class="center">
            <input type="hidden" name="idgrup" value="<?= $idgrup; ?>">
            <button type="submit" name="btnSubmit" class="button">Edit Thread</button>
        </p>
    </form>

    <form class="center" action="mahasiswa_thread.php" method="post">
        <input type="hidden" name="idgrup" value="<?= $idgrup; ?>">
        <button type="submit" class="button-secondary">Kembali</button>
    </form>
</div>

</body>
</html>
