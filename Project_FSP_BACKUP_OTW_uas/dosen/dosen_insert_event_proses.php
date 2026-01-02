<?php
session_start();
require_once '../class/event.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$event = new Event();

$idgrup = $_POST['idgrup'];
$judul = $_POST['judul'];
$tanggal = $_POST['tanggal']; 
$keterangan = $_POST['keterangan'];
$jenis = $_POST['jenis'];

$judul_slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $judul));

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

if (!empty($_FILES['poster']['name'])) {

    $poster_name = $_FILES['poster']['name'];
    $poster_temp  = $_FILES['poster']['tmp_name'];
    $poster_ext  = strtolower(pathinfo($poster_name, PATHINFO_EXTENSION));

    if (!file_exists("../image_events")) 
    {
        mkdir("../image_events", 0777, true);
    }

    $path = "../image_events/" . $idevent . "." . $poster_ext;

    if (move_uploaded_file($poster_temp, $path)) 
    {
        $event->updateEvent([
            'idevent' => $idevent,
            'idgrup' => $idgrup,
            'judul' => $judul,
            'tanggal' => $tanggal,
            'jenis' => $jenis,
            'keterangan' => $keterangan,
            'poster_extension' => $poster_ext
        ]);
    }
}
header("Location: dosen_kelola_event.php?idgrup=" . $idgrup);

exit();
?>
