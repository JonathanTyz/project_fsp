<?php
session_start();
require_once '../class/chat.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['user']['username'];

$idthread = (int)$_POST['idthread'];
$idgrup   = (int)$_POST['idgrup'];
$isi      = trim($_POST['pesan']);

if ($isi === '') {
    die("Pesan tidak boleh kosong");
}

$chatObj = new Chat();

$success = $chatObj->addChat($idthread, $username, $isi);

if (!$success) {
    die("Thread sudah ditutup, tidak bisa mengirim chat");
}

echo "OK";
exit();
?>

