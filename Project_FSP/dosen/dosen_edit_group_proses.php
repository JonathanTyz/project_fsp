<?php
session_start();
require_once '../class/group.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$idgrup     = $_POST['idgrup'];
$nama       = $_POST['nama'];
$jenis      = $_POST['jenis'];
$deskripsi  = $_POST['deskripsi'];

$group = new group();
$group->editGroup($idgrup, $nama, $jenis, $deskripsi);

// kembali ke detail group 
header("Location: dosen_kelola_group.php");
exit();
?>
