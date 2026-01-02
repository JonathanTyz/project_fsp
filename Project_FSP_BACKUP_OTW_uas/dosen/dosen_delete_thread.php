<?php
session_start();
require_once '../class/thread.php';

if (!isset($_SESSION['user'])) {
    die("Akses ditolak");
}

$idgrup   = isset($_POST['idgrup']) ? (int)$_POST['idgrup'] : 0;
$idthread = isset($_POST['idthread']) ? (int)$_POST['idthread'] : 0;

$thread = new Thread();

$data = $thread->getThread($idthread);
if (!$data) {
    die("Thread tidak ditemukan");
}
$result = $thread->dosenDeleteThread($idthread);

if ($result) {
    header("Location: dosen_thread.php?idgrup=" . $idgrup);
    exit();
} else {
    die("Gagal menghapus thread");
}
