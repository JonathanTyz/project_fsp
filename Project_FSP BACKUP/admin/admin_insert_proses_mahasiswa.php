<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

require_once '../class/mahasiswa.php';

$mahasiswa = new mahasiswa();

$result = $mahasiswa->insertMahasiswa(
    $_POST['nrp'],
    $_POST['nama'],
    $_POST['gender'],
    $_POST['tanggal_lahir'],
    $_POST['angkatan'],
    $_POST['username'],
    $_POST['password'],
    $_FILES['foto']
);

if ($result === "SUCCESS") {
    echo "Berhasil menambahkan mahasiswa";
    echo "<br><a href='admin_mahasiswa.php'>Kembali ke daftar mahasiswa?</a>";
} else {
    echo "Gagal: $result";
    echo "<br><a href='admin_insert_mahasiswa.php'>Kembali ke form?</a>";
    echo "<br><a href='admin_mahasiswa.php'>Kembali ke daftar mahasiswa?</a>";
}
?>
