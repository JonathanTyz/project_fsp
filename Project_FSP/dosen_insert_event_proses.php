<?php
session_start();
require_once 'class/event.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$event = new Event();
$idgrup = $_POST['idgrup'];
$judul = $_POST['judul'];
$tanggal = $_POST['tanggal'];
$keterangan = $_POST['keterangan'];
$jenis = $_POST['jenis'];
$judul_slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $judul));

$poster_extension = null;
$poster_path = null;

if (!empty($_FILES['poster']['name'])) {
    $poster_name = $_FILES['poster']['name'];
    $poster_temp = $_FILES['poster']['tmp_name'];
    $poster_extension = strtolower(pathinfo($poster_name, PATHINFO_EXTENSION));

    $poster_path = "image_events/" . $idevent. "." . $poster_extension;
    move_uploaded_file($poster_temp, $poster_path);
}

$data = [
    'idgrup' => $idgrup,
    'judul' => $judul,
    'judul_slug' => $judul_slug,
    'tanggal' => $tanggal,
    'keterangan' => $keterangan,
    'jenis' => $jenis,
    'poster_extension' => $poster_extension
];

$idevent = $event->insertEvent($data);

if ($idevent !== false && $poster_extension !== null) {
    $new_path = "image_events/" . $idevent . "." . $poster_extension;
    rename($poster_path, $new_path);
}

header("Location: dosen_detail_group.php?id=" . $idgrup);
exit();
