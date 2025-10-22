<?php
session_start();
if (!isset($_SESSION['user'])) 
    {
        header("Location: login.php");
        exit();
    }

$mysqli = new mysqli("localhost", "root", "", "fullstack");
$npk = $_GET['npk']; 


$sql = "SELECT foto_extension FROM dosen WHERE npk = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $npk);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$stmt->close();
$ext = $row['foto_extension'];
unlink("image_dosen/" . $npk . "." . $ext); 


$sql = "DELETE FROM dosen WHERE npk = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $npk);
$stmt->execute();
$jumlah_yang_dieksekusi = $stmt->affected_rows;
$stmt->close(); 
$mysqli->close();
header("Location: admin_dosen.php");
?>