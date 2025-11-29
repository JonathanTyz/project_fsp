<?php
session_start();
require_once 'class/group.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$group = new group();

$kode = $_POST['kode'];

if ($kode === '') {
    header("Location: mahasiswa_home.php");
    exit();
}

$res = $group->getGroupByKode($kode);

if ($res == false) {
    header("Location: mahasiswa_home.php");
    exit();
}

$row = $res->fetch_assoc();
if (!$row) {
    header("Location: mahasiswa_home.php");
    exit();
}

$idgrup = $row['idgrup'];
$username = $_SESSION['user']['username'];

// cek sudah member atau belum
if (!$group->isMember($idgrup, $username)) {
    $group->insertMember($idgrup, $username);
}

header("Location: mahasiswa_home.php");
exit();
?>
