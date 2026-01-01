<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

require_once '../class/dosen.php';

$dosen = new dosen();

$result = $dosen->insertDosen(
    $_POST['npk'],
    $_POST['nama'],
    $_POST['username'],
    $_POST['password'],
    $_FILES['foto']
);

if ($result == "username sudah ada" || $result == "npk sudah ada") {
    echo "Gagal Menambahkan Dosen.";
    echo "<br><a href = 'admin_insert_dosen.php'>Kembali ke form insert dosen?</a>";
    echo "<br><a href = 'admin_dosen.php'>Kembali ke daftar dosen?</a>";
    exit();
}
else if ($result === "SUCCESS")
{
    echo "Berhasil menambahkan dosen";
    echo "<br><a href = 'admin_dosen.php'>Kembali ke daftar dosen?</a>";
    exit();
}
?>
