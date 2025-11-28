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
$tanggal = str_replace('T', ' ', $_POST['tanggal']);
$keterangan = $_POST['keterangan'];
$jenis = $_POST['jenis'];

$judul_slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $judul));

// ===============================
// 1. INSERT EVENT TANPA POSTER
// ===============================
$data = [
    'idgrup' => $idgrup,
    'judul' => $judul,
    'judul_slug' => $judul_slug,
    'tanggal' => $tanggal,
    'keterangan' => $keterangan,
    'jenis' => $jenis,
    'poster_extension' => null
];

$idevent = $event->insertEvent($data);

// ===============================
// 2. UPLOAD POSTER (opsional)
// ===============================
if (!empty($_FILES['poster']['name'])) {

    $poster_name = $_FILES['poster']['name'];
    $poster_tmp = $_FILES['poster']['tmp_name'];
    $poster_ext = strtolower(pathinfo($poster_name, PATHINFO_EXTENSION));

    // buat folder kalau belum ada
    if (!file_exists("image_events")) {
        mkdir("image_events", 0777, true);
    }

    $path = "image_events/" . $idevent . "." . $poster_ext;

    if (move_uploaded_file($poster_tmp, $path)) {
        $event->updatePoster($idevent, $poster_ext);
    }
}

header("Location: dosen_detail_group.php?id=" . $idgrup);
exit();
