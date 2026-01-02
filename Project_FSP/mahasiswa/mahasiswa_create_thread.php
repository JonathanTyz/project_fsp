<?php
session_start();
require_once '../class/thread.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['user']['username'];
$idgrup = isset($_POST['idgrup']) ? (int)$_POST['idgrup'] : 0;

if (isset($_POST['btnSubmit'])) {
    $status = $_POST['status']; 

    $thread = new Thread();

    $result = $thread->createThread($idgrup, $username, $status);

    if ($result) {
        header("Location: mahasiswa_thread.php?idgrup=" . $idgrup);
        exit();
    } else {
        $error = "Gagal membuat thread baru.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buat Thread Baru</title>
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
                width: 100%;
            }

            p {
                margin-bottom: 10px;
            }

            h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Buat Thread Baru</h2>

    <form method="post" action="">
        <input type="hidden" name="idgrup" value="<?= $idgrup; ?>">

        <p>
            <label>Pilih Status Thread:</label><br>
            <br>
            <select name="status" required>
                <option value="Open" selected>Open</option>
                <option value="Close">Close</option>
            </select>
        </p>
        <p class="center">
            <input type = "hidden" name = "idgrup" value = "<?php echo $idgrup;?>">
            <button type="submit" name="btnSubmit" class="button">Buat Thread</button>
        </p>
    </form>

    <form class="center" action="mahasiswa_thread.php" method="post">
        <input type="hidden" name="idgrup" value="<?= $idgrup; ?>">
        <button type="submit" class="button">Kembali</button>
    </form>
</div>

</body>
</html>
