<?php
session_start();
require_once 'class/event.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php"); exit();
}

$idevent = $_POST['idevent'];
$idgrup = $_POST['idgrup'];
$judul = $_POST['judul'];
$tanggal = $_POST['tanggal'];
$jenis = $_POST['jenis'];
$keterangan = $_POST['keterangan'];
$poster_extension_lama = $_POST['poster_extension']; 


if (!empty($_FILES['foto']['name'])) 
{
    $ext_baru = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

    if (file_exists($file_lama)) {
        unlink($file_lama);
    }

    // upload foto baru
    $file_baru = "image_events/". $idevent . "." . $ext_baru;
    move_uploaded_file($_FILES['foto']['tmp_name'], $file_baru);

    $poster_extension = $ext_baru;
}
else
{
    $poster_extension = $poster_extension_lama;
}

$data = [
    "idevent" => $idevent,
    "idgrup" => $idgrup,
    "judul" => $judul,
    "tanggal" => $tanggal,
    "jenis" => $jenis,
    "keterangan" => $keterangan,
    "poster_extension" => $poster_extension
];

$event = new Event();
$event->updateEvent($data);

header("Location: dosen_detail_group.php?idgrup=$idgrup");
exit();
?>
