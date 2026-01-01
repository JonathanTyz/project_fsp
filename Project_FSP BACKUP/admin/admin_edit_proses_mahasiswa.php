<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

require_once '../class/mahasiswa.php';
$mahasiswa = new mahasiswa();

$result = $mahasiswa->updateMahasiswa(
    $_POST['nrp'],
    $_POST['nrp_lama'],
    $_POST['nama'],
    $_POST['gender'],
    $_POST['tanggal_lahir'],
    $_POST['angkatan'],
    $_POST['username'],
    $_POST['username_lama'],
    $_POST['ext_lama'],
    $_FILES['foto']
);

if ($result === "SUCCESS") {
    echo "Berhasil update mahasiswa";
    echo "<br><a href='admin_mahasiswa.php'>Kembali ke daftar mahasiswa?</a>";
    exit();
} else {
    echo "Gagal update: $result";
    echo "<br><a href='admin_edit_mahasiswa.php'>Kembali ke form?</a>";
    echo "<br><a href='admin_mahasiswa.php'>Kembali ke daftar mahasiswa?</a>";
    exit();
}
?>
