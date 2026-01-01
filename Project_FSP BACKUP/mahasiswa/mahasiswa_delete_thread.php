<?php
session_start();
require_once '../class/thread.php';

if (!isset($_SESSION['user'])) {
    die("tidak dikenal");
}

$username = $_SESSION['user']['username'];
$idgrup   = (int)$_POST['idgrup'];
$idthread = (int)$_POST['idthread'];

$thread = new Thread();

//ambil data thread
$dataThread = $thread->getThread($idthread);

if (!$dataThread) {
    die("Thread tidak ditemukan");
}

//bukan pembuat thread
if ($dataThread['username_pembuat'] !== $username) {
    die("Anda tidak berhak menghapus thread ini");
}

//hapus / close thread
$success = $thread->deleteThread($idthread, $username);

if ($success) {
    header("Location: mahasiswa_thread.php?idgrup=".$idgrup);
    exit();
} else {
    echo "Gagal menghapus thread.";
    echo "<br><a href='mahasiswa_thread.php?idgrup=".$idgrup."'>Kembali</a>";
}
