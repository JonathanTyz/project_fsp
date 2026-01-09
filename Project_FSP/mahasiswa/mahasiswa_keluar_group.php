<?php
session_start();
require_once '../class/group.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$group = new group();

if (!isset($_POST['idgrup'])) {
    header("Location: mahasiswa_home.php");
    exit();
}   

$idgrup = (int)$_POST['idgrup'];
$username = $_SESSION['user']['username'];

if ($group->isMember($idgrup, $username)) {
    $group->deleteGroupMembers($idgrup, $username);
}

header("Location: mahasiswa_daftar_group_join.php");
exit();
?>
