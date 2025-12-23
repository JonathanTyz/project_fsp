<?php
session_start();
require_once '../class/thread.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['user']['username'];
$idgrup = $_POST['idgrup'];
$idthread = $_POST['idthread'];
$thread = new Thread();

$deleteThread = $thread->deleteThread($idthread, $username);
if ($deleteThread) {
    header("Location: mahasiswa_thread.php?idgrup=" . $idgrup);
    exit();
} else {
    echo "Gagal Menghapus Thread.";
    echo "<br><a href='mahasiswa_thread.php?idgrup=" . $idgrup . "'>Kembali ke daftar thread?</a>";
}
?>