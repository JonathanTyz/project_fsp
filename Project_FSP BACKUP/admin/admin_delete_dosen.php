<?php
session_start();
if (!isset($_SESSION['user'])) 
    {
        header("Location: ../login.php");
        exit();
    }
require_once '../class/dosen.php';
$npk = $_GET['npk']; 

$dosen = new dosen();
$dosen->deleteDosen($npk);
header("Location: admin_dosen.php");
?>