<?php
session_start();
if (!isset($_SESSION['user'])) 
    {
        header("Location: login.php");
        exit();
    }

$mysqli = new mysqli("localhost", "root", "", "fullstack");
$nrp = $_GET['nrp']; 

$sql = "SELECT foto_extention FROM mahasiswa WHERE nrp = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $nrp);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$stmt->close();
$ext = $row['foto_extention'];
unlink("image_mahasiswa/" . $nrp . "." . $ext); 


$sql = "DELETE FROM mahasiswa WHERE nrp = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $nrp);
$stmt->execute();
$jumlah_yang_dieksekusi = $stmt->affected_rows; 
$stmt->close(); 
$mysqli->close();

unlink("image_mahasiswa/" . $nrp . ".jpg");
header(header: "Location: admin_mahasiswa.php");
?>