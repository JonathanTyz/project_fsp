    <?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: ../login.php");
        exit();
    }

    require_once '../class/group.php';

    $group_id = (int)$_POST['idgrup'];
    $username = $_POST['username'];
    $type = $_POST['type'];

    $group = new group();
    $success = $group->deleteGroupMembers($group_id, $username);

    if ($success && $type === 'mahasiswa') {
        header("Location: dosen_view_member_mahasiswa.php?id=" . $group_id);
        exit();
    } elseif ($success && $type === 'dosen') {
        header("Location: dosen_view_member_dosen.php?id=" . $group_id);
        exit();
    } else {
        echo "Gagal Insert Anggota Grup.";
        echo "<br><a href='dosen_view_member_" . $type . ".php?id=" . $group_id . "'>Kembali ke detail member grup?</a>";
    }
    exit();
    ?>
