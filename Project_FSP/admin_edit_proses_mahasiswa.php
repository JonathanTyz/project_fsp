<?php
$mysqli = new mysqli("localhost", "root", "", "fullstack");

$username = $_POST['username'];
$username_lama = $_POST['username_lama'];
$nrp = $_POST['nrp'];
$nama = $_POST['nama'];
$gender = $_POST['gender'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$angkatan = $_POST['angkatan'];
$nrp_lama = $_POST['nrp_lama'];
$ext_lama = $_POST['ext_lama'];

$sql = "SELECT * FROM akun WHERE username = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows > 0 && $username_lama != $username) { 
    
        echo "Username sudah ada, silakan gunakan username lain.";
        echo "<br><a href='admin_mahasiswa.php'>Kembali ke halaman mahasiswa</a>";
        $stmt->close();
        $mysqli->close();
        exit;
}
else  {
    $sql = "SELECT * FROM mahasiswa WHERE nrp = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $nrp);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0 && $nrp_lama != $nrp) { 
            echo "NRP sudah ada, silakan gunakan NRP lain.";
            echo "<br><a href='admin_mahasiswa.php'>Kembali ke halaman mahasiswa</a>";
            $stmt->close();
            $mysqli->close();
            exit;
    }
    else 
    {
        if (!empty($_FILES['foto']['name'])) 
        {
            $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
            $sql = "UPDATE mahasiswa SET nrp = ?, nama = ?, gender = ?, tanggal_lahir = ?, angkatan = ?, foto_extention = ? WHERE nrp = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("sssssss", $nrp, $nama, $gender, $tanggal_lahir, $angkatan, $ext, $nrp_lama);
            $stmt->execute();
            $stmt->close();
            $foto_baru = "image_mahasiswa/" . $nrp . "." . $ext;
            $foto_lama = "image_mahasiswa/" . $nrp_lama . "." . $ext_lama;
            if (file_exists($foto_lama)) 
            {
                unlink($foto_lama);
            }
            move_uploaded_file($_FILES['foto']['tmp_name'], $foto_baru); 
        } 
        else 
        {

            $sql = "UPDATE mahasiswa SET nrp = ?, nama = ?, gender = ?, tanggal_lahir = ?, angkatan = ? WHERE nrp = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ssssss", $nrp, $nama, $gender, $tanggal_lahir, $angkatan, $nrp_lama);
            $stmt->execute();
            $stmt->close();
            $foto_lama = "image_mahasiswa/" . $nrp_lama . "." . $ext_lama;
            $foto_baru = "image_mahasiswa/" . $nrp . "." . $ext_lama;
            if (file_exists($foto_lama)) 
            {
                rename($foto_lama, $foto_baru);
            }
        }        
   
        $sql = "UPDATE akun SET username = ?, nrp_mahasiswa = ? WHERE nrp_mahasiswa = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sss", $username, $nrp, $nrp_lama);
        $stmt->execute();

        $sql = "UPDATE akun SET username = ? WHERE nrp_mahasiswa = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ss", $username, $nrp);
        $stmt->execute();
    }

    }
        
$mysqli->close();

header("Location: admin_mahasiswa.php");
?>