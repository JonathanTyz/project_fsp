<?php
session_start();
require_once '../class/chat.php';
require_once '../class/thread.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['isadmin'] != 1) {
    die("Unauthorized");
}

$username = $_SESSION['user']['username'];
$idthread = (int)$_POST['idthread'];
$idgrup   = (int)$_POST['idgrup'];
$isi      = trim($_POST['isi']);

$chat   = new Chat();
$thread = new Thread();

$dataThread = $thread->getThread($idthread);

//Thread Close → tidak boleh chat
if ($dataThread['status'] !== 'Open') {
    die("Thread sudah ditutup");
}

$chat->addChat($idthread, $username, $isi);

header("Location: dosen_view_chat.php?idthread=$idthread&idgrup=$idgrup");
exit();
