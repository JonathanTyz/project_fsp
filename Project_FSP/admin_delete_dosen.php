<?php
//hapus data dosen
$mysqli = new mysqli("localhost", "root", "", "fullstack");
$npk = $_GET['npk']; 

//hapus foto di server dulu sebelum di database
$sql = "SELECT foto_extension FROM dosen WHERE npk = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $npk);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$stmt->close();
$ext = $row['foto_extension'];
unlink("image_dosen/" . $npk . "." . $ext); 

//hapus data dosen
$sql = "DELETE FROM dosen WHERE npk = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $npk);
$stmt->execute();
$jumlah_yang_dieksekusi = $stmt->affected_rows; //opsional, untuk mengetahui ada berapa baris yang terpengaruh
$stmt->close(); 
$mysqli->close();
header("Location: admin_dosen.php");
?>