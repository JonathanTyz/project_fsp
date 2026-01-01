<?php
session_start();
require_once '../class/thread.php';
require_once '../class/chat.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['user']['username'];

$idthread = (int)($_POST['idthread'] ?? $_GET['idthread']);
$idgrup   = (int)($_POST['idgrup'] ?? $_GET['idgrup']);

$threadObj = new Thread();
$chatObj   = new Chat();

$thread = $threadObj->getThread($idthread);
if (!$thread) {
    die("Thread tidak ditemukan");
}

$chats = $chatObj->getChats($idthread);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chat Thread</title>
</head>
<body>

<a href="mahasiswa_thread.php?idgrup=<?= $idgrup ?>">← Kembali</a>

<h3>Thread oleh <?= $thread['username_pembuat']; ?></h3>
<p>Status: <b><?= $thread['status']; ?></b></p>

<?php if ($thread['status'] == 'Close') { ?>
    <p style="color:red;font-weight:bold">
        Thread sudah ditutup. Chat bersifat read-only.
    </p>
<?php } ?>

<div>
<?php if ($chats->num_rows == 0) { ?>
    <p><i>Belum ada chat</i></p>
<?php } ?>

<?php while ($row = $chats->fetch_assoc()) { ?>
    <p>
        <b><?= htmlspecialchars($row['username_pembuat']); ?></b> :
        <?= nl2br(htmlspecialchars($row['isi'])); ?><br>
        <small><?= $row['tanggal_pembuatan']; ?></small>
    </p>
<?php } ?>
</div>

<?php if ($thread['status'] == 'Open') { ?>
<form action="mahasiswa_send_chat.php" method="post">
    <input type="hidden" name="idthread" value="<?= $idthread ?>">
    <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
    <textarea name="pesan" required></textarea><br>
    <button type="submit">Kirim</button>
</form>
<?php } ?>

</body>
</html>
