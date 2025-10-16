<?php
$mysqli = new mysqli("localhost", "root", "", "fullstack");

// Ambil data POST
$username       = $_POST['username'];
$username_lama  = $_POST['username_lama'];
$nrp            = $_POST['nrp'];
$nama           = $_POST['nama'];
$gender         = $_POST['gender'];
$tanggal_lahir  = $_POST['tanggal_lahir'];
$angkatan       = $_POST['angkatan'];
$nrp_lama       = $_POST['nrp_lama'];
$ext_lama       = $_POST['ext_lama'];

// Cek duplikat username (kecuali username lama sendiri)
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
$stmt->close();

// Cek duplikat NRP (kecuali NRP lama sendiri)
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
$stmt->close();

// Jika ada upload foto baru
if (!empty($_FILES['foto']['name'])) {
    $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

    // Update mahasiswa dengan foto baru
    $sql = "UPDATE mahasiswa 
            SET nrp=?, nama=?, gender=?, tanggal_lahir=?, angkatan=?, foto_extension=? 
            WHERE nrp=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssssiss", $nrp, $nama, $gender, $tanggal_lahir, $angkatan, $ext, $nrp_lama);
    $stmt->execute();
    $stmt->close();

    // Hapus foto lama jika ada
    $foto_lama = "image_mahasiswa/" . $nrp_lama . "." . $ext_lama;
    if (file_exists($foto_lama)) {
        unlink($foto_lama);
    }

    // Simpan foto baru
    $foto_baru = "image_mahasiswa/" . $nrp . "." . $ext;
    move_uploaded_file($_FILES['foto']['tmp_name'], $foto_baru);

} else {
    // Update mahasiswa tanpa ganti foto
    $sql = "UPDATE mahasiswa 
            SET nrp=?, nama=?, gender=?, tanggal_lahir=?, angkatan=? 
            WHERE nrp=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssssss", $nrp, $nama, $gender, $tanggal_lahir, $angkatan, $nrp_lama);
    $stmt->execute();
    $stmt->close();

    // Jika NRP berubah, rename file foto lama
    $foto_lama = "image_mahasiswa/" . $nrp_lama . "." . $ext_lama;
    $foto_baru = "image_mahasiswa/" . $nrp . "." . $ext_lama;
    if ($nrp != $nrp_lama && file_exists($foto_lama)) {
        rename($foto_lama, $foto_baru);
    }
}

// Update akun (username + relasi NRP)
$sql = "UPDATE akun SET username=?, nrp_mahasiswa=? WHERE nrp_mahasiswa=?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sss", $username, $nrp, $nrp_lama);
$stmt->execute();
$stmt->close();

$mysqli->close();

// Redirect
header("Location: admin_mahasiswa.php");
exit;
?>
