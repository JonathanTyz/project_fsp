<?php
session_start();
require_once '../class/event.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php"); exit();
}

$idevent = $_POST['idevent'];
$idgrup = $_POST['idgrup'];
$judul = $_POST['judul'];
$tanggal = $_POST['tanggal'];
$jenis = $_POST['jenis'];
$keterangan = $_POST['keterangan'];
$poster_extension_lama = $_POST['poster_extension']; 

$poster_extension = $poster_extension_lama; // default: tetap foto lama

if (!empty($_FILES['foto']['name'])) 
{
    $ext_baru = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

    // hapus file lama jika ada
    $file_lama = "../image_events/" . $idevent . "." . $poster_extension_lama;
    if (file_exists($file_lama)) {
        unlink($file_lama);
    }

    // upload file baru
    $file_baru = "../image_events/". $idevent . "." . $ext_baru;
    move_uploaded_file($_FILES['foto']['tmp_name'], $file_baru);

    $poster_extension = $ext_baru; // update extension baru
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

header("Location: dosen_kelola_event.php?idgrup=$idgrup");
exit();
?>
