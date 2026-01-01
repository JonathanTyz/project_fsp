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
    <title>Ubah Thread </title>
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
    <h2>Edit Thread</h2>
    <p>Status lama: <?php echo $statusSebelum ?></p>
    <form method="post" action="">
        <input type="hidden" name="idgrup" value="<?= $idgrup; ?>">
        <input type="hidden" name="idthread" value="<?= $idthread; ?>">
        <p>
            <label>Ubah Status Thread:</label><br>
            <br>
            <select name="status" required>
                <option value="Open" selected>Open</option>
                <option value="Close">Close</option>
            </select>
        </p>
        <p class="center">
            <input type = "hidden" name = "idgrup" value = "<?php echo $idgrup;?>">
            <button type="submit" name="btnSubmit" class="button">Edit Thread</button>
        </p>
    </form>

    <form class="center" action="mahasiswa_thread.php" method="post">
        <input type="hidden" name="idgrup" value="<?= $idgrup; ?>">
        <button type="submit" class="button">Kembali</button>
    </form>
</div>

</body>
</html>
