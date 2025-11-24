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

if (!empty($_FILES['foto']['name'])) {
    $poster_extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $filename = $idevent . "." . $poster_extension;
    move_uploaded_file($_FILES['foto']['tmp_name'], "image_events/" . $filename);
} 
else 
{
    $poster_extension = $_POST['poster_extension'];
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

header("Location: dosen_detail_group.php");
exit();
?>
