<?php
require_once 'class/group.php';
session_start();
if (!isset($_SESSION['user'])) 
    {
        header("Location: login.php");
        exit();
    }

$username = $_SESSION['user']['username'];

$name  = $_POST['name'];
$desk  = $_POST['deskripsi'];
$jenis = $_POST['jenis'];
$kode  = $_POST['kodePendaftaran'];

$group = new group();
if ($group->insertGroup(array('name' => $name, 'deskripsi' => $desk, 'jenis' => $jenis, 'kodePendaftaran' => $kode))) 
    {
        header("Location: dosen_home.php");
        exit();
    }
else
{
    echo "Proses Insert gagal";
    echo "<br><a href='dosen_home.php'>Kembali ke home dosen?</a>";
    exit();
}
?>