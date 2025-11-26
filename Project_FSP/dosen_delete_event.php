    <?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit();
    }

    require_once 'class/event.php';

    $group_id = (int)$_POST['idgrup'];
    $idevent = $_POST['idevent'];
    
    $event = new event();

    $foto_extension = $event->getPosterExtension($idevent);

    if ($foto_extension) {
        $file_path = "image_events/" . $idevent . "." . $foto_extension;

        if (file_exists($file_path)) 
        {
            unlink($file_path);
        }
    }

    $success = $event->deleteEvents($group_id, $idevent);

    if ($success) {
        unlink("image_events/" . $idevent . "." . $foto_extention);
        header("Location: dosen_detail_group.php?idgrup=" . $group_id);
    } else {
        echo "Gagal Menghapus Event.";
        echo "<br><a href='dosen_detail_group.php?idgrup=" . $group_id . "'>Kembali ke detail grup?</a>";
    }
    exit();
    ?>
