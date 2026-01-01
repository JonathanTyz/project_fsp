<?php
session_start();
require_once '../class/chat.php';
require_once '../class/thread.php';

/* =====================
   CEK LOGIN SAJA
===================== */
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

/* =====================
   AMBIL DATA
===================== */
$idthread = (int)($_POST['idthread'] ?? $_GET['idthread'] ?? 0);
$idgrup   = (int)($_POST['idgrup'] ?? $_GET['idgrup'] ?? 0);
$username = $_SESSION['user']['username'];

$chat   = new Chat();
$thread = new Thread();

$dataThread = $thread->getThread($idthread);
if (!$dataThread) {
    die("Thread tidak ditemukan");
}

$chats = $chat->getChats($idthread);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chat Thread Dosen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }
        .container {
            width: 85%;
            margin: auto;
            background: white;
            padding: 20px;
        }
        .chat {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .user {
            font-weight: bold;
            color: #2c3e50;
        }
        .tanggal {
            font-size: 12px;
            color: #777;
        }
        textarea {
            width: 100%;
            height: 80px;
            margin-top: 10px;
        }
        button {
            padding: 8px 16px;
            background: #2c3e50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .disabled {
            background: #aaa;
            cursor: not-allowed;
        }
        .status {
            margin-bottom: 15px;
            font-weight: bold;
        }
        .back {
            margin-bottom: 10px;
            display: inline-block;
            text-decoration: none;
            color: white;
            background: #6c757d;
            padding: 6px 12px;
        }
    </style>
</head>

<body>

<a href="dosen_thread.php?idgrup=<?= $idgrup ?>" class="back">← Kembali</a>

<div class="container">
    <h2>Chat Thread</h2>

    <div class="status">
        Status Thread:
        <span style="color:<?= $dataThread['status'] === 'Open' ? 'green' : 'red' ?>">
            <?= $dataThread['status'] ?>
        </span>
    </div>

    <?php if ($chats->num_rows == 0): ?>
        <p><i>Belum ada chat</i></p>
    <?php endif; ?>

    <?php while ($row = $chats->fetch_assoc()): ?>
        <div class="chat">
            <div class="user">
                <?= htmlspecialchars($row['username_pembuat']) ?>
            </div>
            <div><?= nl2br(htmlspecialchars($row['isi'])) ?></div>
            <div class="tanggal"><?= $row['tanggal_pembuatan'] ?></div>
        </div>
    <?php endwhile; ?>

    <hr>

    <?php if ($dataThread['status'] === 'Open'): ?>
        <form action="dosen_send_chat.php" method="post">
            <input type="hidden" name="idthread" value="<?= $idthread ?>">
            <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
            <textarea name="isi" required placeholder="Tulis pesan..."></textarea>
            <br><br>
            <button type="submit">Kirim Chat</button>
        </form>
    <?php else: ?>
        <button class="disabled" disabled>Thread sudah ditutup</button>
    <?php endif; ?>

</div>

</body>
</html>
