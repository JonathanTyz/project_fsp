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
    header("Location: dosen_home.php");
    exit();
}

$res = $group->getGroupByKode($kode);

if ($res == false) {
    header("Location: dosen_home.php");
    exit();
}

$row = $res->fetch_assoc();
if (!$row) {
    header("Location: dosen_home.php");
    exit();
}
if ($row['jenis'] === 'Privat')
{
    echo "Grup yang anda ingin masuk adalah grup privat, harus diinvite oleh dosen langsung !"; 
    echo "<br><a href='dosen_home.php'>Kembali</a>"; 
    exit();
}
else
{
    $idgrup = $row['idgrup'];
    $username = $_SESSION['user']['username'];

// cek sudah member atau belum
if (!$group->isMember($idgrup, $username)) 
{
    $group->insertMember($idgrup, $username);
}
else
{
    echo "Anda sudah menjadi member grup ini!";
    echo "<br><a href='dosen_home.php'>Kembali</a>"; 
    exit();
}

header("Location: dosen_home.php");
exit();


}
?>