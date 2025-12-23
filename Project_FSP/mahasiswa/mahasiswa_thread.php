<?php
session_start();
require_once '../class/thread.php';
require_once '../class/chat.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['idgrup'])) {
    $idgrup = (int)$_POST['idgrup'];
} elseif (isset($_GET['idgrup'])) {
    $idgrup = (int)$_GET['idgrup'];
}

$username = $_SESSION['user']['username'];

$threadObj = new Thread();
$threads = $threadObj->getThreads($idgrup);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thread Grup</title>
    <style>
        body { font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px; }
        h2 { text-align: center; }
        table { width: 90%;
            margin: 20px auto;
            background: #fff; }
        th, td { border: 1px solid #ccc;
             padding: 10px;
              text-align: center; }
        th { background-color: #eee; }
        .button { padding: 8px 15px;
             margin: 5px;
             background-color: #2c3e50;
             color: white; 
            }
        .center { text-align: center; }
        .container-kembali{
            width: 90%;
            margin: auto;
        }
        .kembali{
            display: inline-block;
            padding: 8px 14px;
            background-color: #6c757d;
            color: white;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container-kembali">
    <a href="mahasiswa_daftar_group_join.php" class="kembali">← Kembali</a>
</div>

<h2>Thread Grup</h2>

<div class="center">
    <form action="mahasiswa_create_thread.php" method="post">
        <input type="hidden" name="idgrup" value="<?= $idgrup; ?>">
        <button class="button" type="submit">+ Buat Thread Baru</button>
    </form>
</div>

<table>
    <tr>
        <th>Pembuat</th>
        <th>Tanggal</th>
        <th>Status</th>
        <th colspan = '3'>Aksi</th>
    </tr>

    <?php while ($row = $threads->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['username_pembuat']; ?></td>
            <td><?= $row['tanggal_pembuatan']; ?></td>
            <td><?= $row['status']; ?></td>
            <td>

                <form action="mahasiswa_view_chat.php" method="post" style="display:inline-block;">
                    <input type="hidden" name="idthread" value="<?= $row['idthread']; ?>">
                    <input type = "hidden" name = "idgrup" value = "<?= $idgrup ?>">
                    <button class="button" type="submit">View Chat</button>
                </form>
            </td>
            <td>
                <form action = "mahasiswa_delete_thread.php" method = "post" style="display:inline-block;">
                    <input type="hidden" name="idthread" value="<?= $row['idthread']; ?>">
                    <input type = "hidden" name = "idgrup" value = "<?= $idgrup ?>">
                    <button class="button" type="submit">Delete</button>
                </form>
            </td>

            <td>
                <form action = "mahasiswa_edit_thread.php" method = "post" style="display:inline-block;">
                    <input type="hidden" name="idthread" value="<?= $row['idthread']; ?>">
                    <input type = "hidden" name = "idgrup" value = "<?= $idgrup ?>">
                    <input type = "hidden" name = "status" value = "<?= $row['status'] ?>">
                    <button class="button" type="submit">Edit</button>
                </form>
            </td>
        </tr>
    <?php } ?>

</table>

</body>
</html>
