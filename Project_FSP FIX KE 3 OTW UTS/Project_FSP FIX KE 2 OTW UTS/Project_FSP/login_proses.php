<?php
session_start();
require_once 'class/users.php'; 
$mysqli = new mysqli("localhost", "root", "", "fullstack");
$user = new users();

$username = $_POST['txtUsername'];
$password = $_POST['txtPassword'];

$row = $user->doLogin($username, $password);

if ($row)
    {
        $_SESSION['user'] = [
            'username' => $row['username'],
            'isadmin'  => $row['isadmin'],
            'nrp_mahasiswa' => $row['nrp_mahasiswa'],
            'npk_dosen' => $row['npk_dosen']
    ];

    if ($row['isadmin']) 
        {
            header("Location: admin_home.php");
        } elseif (!empty($row['nrp_mahasiswa'])) {
            header("Location: mahasiswa_home.php");
        } elseif (!empty($row['npk_dosen'])) {
            header("Location: dosen_home.php");
        }
    exit;
} 
else {
        echo "Username atau password salah!";
        echo "<br><a href='login.php'>Kembali ke halaman login</a>";
    }
?>
