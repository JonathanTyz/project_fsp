<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

require_once 'class/group.php';

$group_id = (int)$_POST['idgrup'];

$group = new group();

$events = $group->getAllEvents($group_id);
if ($events) {
    while ($row = $events->fetch_assoc()) {
        if (!empty($row['poster_extension'])) {
            $path = "image_events/" . $row['idevent'] . "." . $row['poster_extension'];
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }
}

$success = $group->deleteGroup($group_id);

if ($success) 
{
    header("Location: dosen_home.php?");
} 
else 
{
    echo "Gagal Menghapus Grup.";
    echo "<br><a href='dosen_detail_group.php?id=" . $group_id . "'>Kembali ke detail grup?</a>";
}
exit();
?>
