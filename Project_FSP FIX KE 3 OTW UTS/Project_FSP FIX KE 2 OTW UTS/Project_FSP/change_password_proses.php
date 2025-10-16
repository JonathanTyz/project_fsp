<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "fullstack");
if ($mysqli->connect_errno) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

$password_old = $_POST['old_password'];
$password_new = $_POST['password'];

$username = $_SESSION['user']['username'];

$sql = "select password from akun where username = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if(!$user || $password_old != $user['password']){
    echo ("password lama anda salah <br>");
    echo "<a href = 'change_password.php'>Kembali?</a>";
    die ();
}else{
    $sql = "UPDATE akun SET password = ? WHERE username = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $password_new, $username);
    $stmt->execute();
    echo "Password Berhasil diubah!<br>";
    echo "<a href = 'change_password.php'>Kembali ke Change password</a>";
}
?>