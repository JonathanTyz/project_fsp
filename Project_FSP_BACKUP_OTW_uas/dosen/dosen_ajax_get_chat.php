<?php
session_start();
require_once '../class/chat.php';

if (!isset($_SESSION['user'])) exit;

$idthread = (int)$_GET['idthread'];

$chatObj = new Chat();
$chats = $chatObj->getChats($idthread);

$data = [];
while ($row = $chats->fetch_assoc()) {
    $row['nama_penulis'] = $row['nama_mahasiswa'] ?? $row['nama_dosen'];

    $data[] = $row;
}

echo json_encode($data);
