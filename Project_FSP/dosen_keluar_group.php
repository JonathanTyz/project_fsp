<?php
session_start();
require_once 'class/group.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$group = new group();

if (!isset($_POST['idgrup'])) {
    header("Location: dosen_home.php");
    exit();
}   

$idgrup = (int)$_POST['idgrup'];
$username = $_SESSION['user']['username'];

// Jika dosen adalah member, hapus dari tabel member_grup
if ($group->isMember($idgrup, $username)) {
    $group->deleteGroupMembers($idgrup, $username);
}

header("Location: dosen_home.php");
exit();
?>
