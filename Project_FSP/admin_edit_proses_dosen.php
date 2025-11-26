<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$mysqli = new mysqli("localhost", "root", "", "fullstack");
if ($mysqli->connect_errno) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

$username = $_POST['username'];
$username_lama = $_POST['username_lama'];
$npk = $_POST['npk'];
$nama = $_POST['nama'];
$npk_lama = $_POST['npk_lama'];
$ext_lama = $_POST['ext_lama'];

$sql = "SELECT username FROM akun WHERE username = ? AND username != ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $username, $username_lama);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows > 0) {
    echo "Username sudah ada, silakan gunakan username lain.";
    echo "<br><a href='admin_dosen.php'>Kembali ke halaman dosen</a>";
    exit();
}

$sql = "SELECT npk FROM dosen WHERE npk = ? AND npk != ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $npk, $npk_lama);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows > 0) {
    echo "NPK sudah ada, silakan gunakan NPK lain.";
    echo "<br><a href='admin_dosen.php'>Kembali ke halaman dosen</a>";
    exit();
}

if (!empty($_FILES['foto']['name'])) {
    $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    $sql = "UPDATE dosen SET npk = ?, nama = ?, foto_extension = ? WHERE npk = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssss", $npk, $nama, $ext, $npk_lama);
    $stmt->execute();
    $stmt->close();
    $foto_lama = "image_dosen/" . $npk_lama . "." . $ext_lama;
    if (file_exists($foto_lama)) 
    {
        unlink($foto_lama);
    }
    $foto_baru = "image_dosen/" . $npk . "." . $ext;
    move_uploaded_file($_FILES['foto']['tmp_name'], $foto_baru);
}

else 
{
    $sql = "UPDATE dosen SET npk = ?, nama = ? WHERE npk = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sss", $npk, $nama, $npk_lama);
    $stmt->execute();
    $stmt->close();
    if ($npk != $npk_lama) {
        $foto_lama = "image_dosen/" . $npk_lama . "." . $ext_lama;
        $foto_baru = "image_dosen/" . $npk . "." . $ext_lama;
        if (file_exists($foto_lama)) {
            rename($foto_lama, $foto_baru);
        }
    }
}

$sql = "UPDATE akun SET username = ?, npk_dosen = ? WHERE username = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sss", $username, $npk, $username_lama);
$stmt->execute();
$stmt->close();

$mysqli->close();
header("Location: admin_dosen.php");
exit();
?>
