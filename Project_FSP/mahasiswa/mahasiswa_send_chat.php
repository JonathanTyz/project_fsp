<?php
session_start();
require_once '../class/chat.php';

if (!isset($_SESSION['user'])) {
    die("Unauthorized");
}

$username = $_SESSION['user']['username'];

// ambil data dari form
$idthread = (int)$_POST['idthread'];
$idgrup   = (int)$_POST['idgrup'];
$isi      = trim($_POST['pesan']);

// validasi sederhana
if ($isi === '') {
    die("Pesan tidak boleh kosong");
}

$chatObj = new Chat();

// coba simpan chat
$success = $chatObj->addChat($idthread, $username, $isi);

if (!$success) {
    // thread Close atau tidak valid
    die("Thread sudah ditutup, tidak bisa mengirim chat");
}

// kembali ke halaman chat
header("Location: mahasiswa_view_chat.php?idthread=$idthread&idgrup=$idgrup");
exit();
