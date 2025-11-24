    <?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit();
    }

    require_once 'class/group.php';

    $group_id = (int)$_POST['id'];
    $username = $_POST['username'];

    $group = new group();
    $success = $group->deleteGroupMembers($group_id, $username);

    if ($success) {
        header("Location: dosen_detail_group.php?");
    } else {
        echo "Gagal Menghapus Anggota Grup.";
        echo "<br><a href='dosen_detail_group.php?id=" . $group_id . "'>Kembali ke detail grup?</a>";
    }
    exit();
    ?>
