<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

require_once '../class/dosen.php';
$dosen = new dosen();

$result = $dosen->updateDosen(
    $_POST['npk'],
    $_POST['npk_lama'],
    $_POST['nama'],
    $_POST['username'],
    $_POST['username_lama'],
    $_POST['ext_lama'],
    $_FILES['foto']
);

if ($result === "SUCCESS") {
    header("Location: admin_dosen.php");
    exit();
} else {
    echo "Gagal update dosen: $result";
    echo "<br><a href='admin_dosen.php'>Kembali</a>";
}
?>
