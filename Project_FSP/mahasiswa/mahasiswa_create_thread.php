<?php
session_start();
require_once '../class/thread.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
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
        body { font-family: Arial, sans-serif; 
            background: #f4f4f4; 
            padding: 20px; }
        .container { 
            background: #fff; 
            padding: 30px; 
            width: 400px; 
            margin: 50px;}
        h2 { text-align: center; 
            margin-bottom: 20px; }
        .button { padding: 10px 20px; 
            background: #2c3e50; 
            color: white;}
        .center { 
            text-align: center; }
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
