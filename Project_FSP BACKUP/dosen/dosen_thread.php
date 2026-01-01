<?php
session_start();
require_once '../class/thread.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['user']['username'];
$idgrup   = (int)($_POST['idgrup'] ?? $_GET['idgrup']);

$threadObj = new Thread();
$threads   = $threadObj->getThreads($idgrup);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thread Grup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            padding: 20px;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 90%;
            margin: 20px auto;
            background: white;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #333;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #e9ecef;
        }
        .button {
            padding: 6px 12px;
            background-color: #2c3e50;
            color: white;
            border: none;
            font-weight: bold;
        }
        .button-disabled {
            padding: 6px 12px;
            background-color: #b0b0b0;
            color: #666;
            border: none;
            cursor: not-allowed;
        }
        .kembali {
            display: inline-block;
            padding: 8px 14px;
            background-color: #6c757d;
            color: white;
            font-weight: bold;
            text-decoration: none;
        }
        .center {
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<a href="dosen_group_saya.php" class="kembali">← Kembali</a>

<h2>Thread Grup</h2>

<div class="center">
    <form action="dosen_create_thread.php" method="post">
        <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
        <button class="button" type="submit">+ Buat Thread Baru</button>
    </form>
</div>

<table>
    <tr>
        <th>Pembuat</th>
        <th>Tanggal</th>
        <th>Status</th>
        <th colspan="3">Aksi</th>
    </tr>

<?php while ($row = $threads->fetch_assoc()) {
    $isOwner = ($row['username_pembuat'] === $username);
?>
    <tr>
        <td><?= htmlspecialchars($row['username_pembuat']) ?></td>
        <td><?= $row['tanggal_pembuatan'] ?></td>
        <td><?= $row['status'] ?></td>

        <!-- VIEW CHAT -->
        <td>
            <form action="dosen_view_chat.php" method="post">
                <input type="hidden" name="idthread" value="<?= $row['idthread'] ?>">
                <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
                <button class="button" type="submit">View Chat</button>
            </form>
        </td>

        <!-- DELETE -->
        <td>
        <?php if ($isOwner) { ?>
            <form action="dosen_delete_thread.php" method="post">
                <input type="hidden" name="idthread" value="<?= $row['idthread'] ?>">
                <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
                <button class="button" type="submit">Delete</button>
            </form>
        <?php } else { ?>
            <button class="button-disabled" disabled>Delete</button>
        <?php } ?>
        </td>

        <!-- EDIT -->
        <td>
        <?php if ($isOwner) { ?>
            <form action="dosen_edit_thread.php" method="post">
                <input type="hidden" name="idthread" value="<?= $row['idthread'] ?>">
                <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
                <input type="hidden" name="status" value="<?= $row['status'] ?>">
                <button class="button" type="submit">Edit</button>
            </form>
        <?php } else { ?>
            <button class="button-disabled" disabled>Edit</button>
        <?php } ?>
        </td>
    </tr>
<?php } ?>

</table>

</body>
</html>
