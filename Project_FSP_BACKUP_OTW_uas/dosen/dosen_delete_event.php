<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

require_once '../class/event.php';

$group_id = (int)$_POST['idgrup'];
$idevent = (int)$_POST['idevent'];

$event = new event();

// Ambil extension foto
$foto_extension = $event->getPosterExtension($idevent);

// Hapus event di database
$success = $event->deleteEvents($group_id, $idevent);

if ($success) {
    // Hapus file foto kalau ada
    if (!empty($foto_extension)) {
        $file_path = "../image_events/" . $idevent . "." . $foto_extension;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
    header("Location: dosen_kelola_event.php?idgrup=" . $group_id);
    exit();
} else {
    echo "Gagal Menghapus Event.";
    echo "<br><a href='dosen_kelola_event.php?idgrup=" . $group_id . "'>Kembali ke detail grup?</a>";
    exit();
}
?>
