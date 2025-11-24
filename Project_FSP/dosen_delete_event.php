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
    $success = $event->deleteEvents($group_id, $idevent);

    if ($success) {
        header("Location: dosen_detail_group.php?");
    } else {
        echo "Gagal Menghapus Event.";
        echo "<br><a href='dosen_detail_group.php?id=" . $group_id . "'>Kembali ke detail grup?</a>";
    }
    exit();
    ?>
