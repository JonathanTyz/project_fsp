<?php
session_start();
require_once '../class/group.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$group = new group();

$kode = $_POST['kode'];

$res = $group->getGroupByKode($kode);

$row = $res->fetch_assoc();
if (!$row) {
    echo "Masukkan kode yang valid!";
    echo "<br><a href='mahasiswa_home.php'>Kembali ke halaman utama?</a>";
    echo "<br><a href='mahasiswa_daftar_group_tersedia.php'>Kembali ke halaman daftar grup?</a>";
    exit();
}
if ($row['jenis'] === 'Privat')
{
    echo "Grup yang anda ingin masuk adalah grup privat, harus diinvite oleh dosen langsung !"; 
    echo "<br><a href='mahasiswa_home.php'>Kembali ke halaman utama?</a>";
    echo "<br><a href='mahasiswa_daftar_group_tersedia.php'>Kembali ke halaman daftar grup?</a>";
    exit();
}
else
{
    $idgrup = $row['idgrup'];
    $username = $_SESSION['user']['username'];

// cek sudah member atau belum
if (!$group->isMember($idgrup, $username)) 
{
    $group->insertMember($idgrup, $username);
}

else if ($group->isMember($idgrup, $username))
{
    echo "Anda sudah menjadi member grup ini!";
    echo "<br><a href='mahasiswa_home.php'>Kembali ke halaman utama?</a>";
    echo "<br><a href='mahasiswa_daftar_group_tersedia.php'>Kembali ke halaman daftar grup?</a>";
    exit();
}

header("Location: mahasiswa_daftar_group_tersedia.php");
exit();


}
?>