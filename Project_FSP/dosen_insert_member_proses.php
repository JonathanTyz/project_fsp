<?php
require_once "class/group.php";

$gr = new group();

// Pastikan idgrup & username dikirim
if (!isset($_POST['idgrup']) || !isset($_POST['username'])) {
    die("ID group atau username tidak dikirim.");
}

$idgrup   = intval($_POST['idgrup']);
$username = $_POST['username'];

$result = $gr->insertMember($idgrup, $username);

if ($result === "ada") {
    echo "User sudah ada di dalam group.";
    echo "<a href='dosen_detail_group.php?id=$idgrup'>Kembali</a>";
    exit;
}
else if ($result === "sukses") {
    echo "Berhasil menambahkan anggota.";
    echo "<a href='dosen_detail_group.php?id=$idgrup'>Kembali</a>";
    exit;
}
else {
    echo "Gagal Insert Anggota Grup.";
    echo "<a href='dosen_detail_group.php?id=$idgrup'>Kembali</a>";
    exit;
}
