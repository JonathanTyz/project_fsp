<?php
session_start();
if (!isset($_SESSION['user'])) 
    {
        header("Location: ../login.php");
        exit();
    }
require_once '../class/mahasiswa.php';
$npk = $_GET['nrp']; 

$mahasiswa = new mahasiswa();
$mahasiswa->deleteMahasiswa($npk);
header("Location: admin_mahasiswa.php");
?>