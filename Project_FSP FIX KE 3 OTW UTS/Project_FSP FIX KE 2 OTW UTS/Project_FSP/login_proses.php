<?php
session_start();

$mysqli = new mysqli("localhost", "root", "", "fullstack");
if ($mysqli->connect_errno) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

$username = $_POST['txtUsername'];
$password = $_POST['txtPassword'];

$sql = "SELECT * FROM akun WHERE username = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if($user && $password == $user['password']){
    $_SESSION['user'] = [
            'username' => $user['username'],
            'isadmin'  => $user['isadmin'],
            'nrp_mahasiswa' => $user['nrp_mahasiswa'],
            'npk_dosen' => $user['npk_dosen']
        ];

        if ($user['isadmin'] == 1) {
            header("Location: admin_home.php");
        } elseif (!empty($user['nrp_mahasiswa'])) {
            header("Location: mahasiswa_home.php");
        } elseif (!empty($user['npk_dosen'])) {
            header("Location: dosen_home.php");
        } 
        
        exit;
}
?>