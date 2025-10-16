<?php
//hapus data mahasiswa
$mysqli = new mysqli("localhost", "root", "", "fullstack");
$nrp = $_GET['nrp']; 

//hapus foto di server dulu sebelum di database
$sql = "SELECT foto_extention FROM mahasiswa WHERE nrp = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $nrp);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$stmt->close();
$ext = $row['foto_extention'];
unlink("image_mahasiswa/" . $nrp . "." . $ext); 

//hapus data mahasiswa
$sql = "DELETE FROM mahasiswa WHERE nrp = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $nrp);
$stmt->execute();
$jumlah_yang_dieksekusi = $stmt->affected_rows; //opsional, untuk mengetahui ada berapa baris yang terpengaruh
$stmt->close(); 
$mysqli->close();
//hapus foto di server juga
unlink("image_mahasiswa/" . $nrp . ".jpg");
header(header: "Location: admin_mahasiswa.php");
?>