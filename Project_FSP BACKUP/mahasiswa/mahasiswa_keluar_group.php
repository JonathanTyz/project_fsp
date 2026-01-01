<?php
session_start();
require_once '../class/group.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$group = new group();

// Pastikan idgrup dikirim
if (!isset($_POST['idgrup'])) {
    header("Location: mahasiswa_home.php");
    exit();
}   

$idgrup = (int)$_POST['idgrup'];
$username = $_SESSION['user']['username'];

// Jika mahasiswa adalah member, hapus dari tabel member_grup
if ($group->isMember($idgrup, $username)) {
    $group->deleteGroupMembers($idgrup, $username);
}

// Kembali ke halaman utama mahasiswa
header("Location: mahasiswa_daftar_group_join.php");
exit();
?>
