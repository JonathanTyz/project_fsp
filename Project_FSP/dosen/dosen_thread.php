<?php
session_start();
require_once '../class/thread.php';
require_once '../class/group.php';
require_once '../css/theme_session.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['user']['username'];
$idgrup   = (int)($_POST['idgrup'] ?? $_GET['idgrup']);

$threadObj = new Thread();
$threads   = $threadObj->getThreads($idgrup);

$grup = new Group();
$cekGrup = $grup->checkOwnGroup($username, $idgrup);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Thread Grup</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="../css/theme.css">

<style>
body {
    font-family: 'Times New Roman', serif;
    margin: 0;
    padding: 20px;
    background-color: #f4f6f8;
}

h2 {
    text-align: center;
    color: #2c3e50;
}

table {
    width: 90%;
    margin: 20px auto;
    border-collapse: collapse;
    background-color: #ffffff;
}

th, td {
    border: 1px solid #d1d5db;
    padding: 10px;
    text-align: center;
}

th {
    background-color: #e5e7eb;
    font-weight: bold;
}

.button {
    padding: 8px 15px;
    margin: 4px;
    border: none;
    font-weight: bold;
    border-radius: 6px;
    background-color: #1E40AF;
    color: white;
    cursor: pointer;
    transition: background-color 0.2s;
}

.button:hover {
    background-color: #1E3A8A;
}

.button-disabled {
    padding: 8px 15px;
    border: none;
    font-weight: bold;
    border-radius: 6px;
    background-color: #9CA3AF;
    color: #f3f4f6;
    cursor: not-allowed;
}

.center {
    text-align: center;
}

.kembali {
    display: inline-block;
    padding: 8px 14px;
    font-weight: bold;
    text-decoration: none;
    margin-bottom: 10px;
    color: #1E40AF;
}

.kembali:hover {
    text-decoration: underline;
}

@media (max-width: 500px) {
    table, thead, tbody, tr, th, td {
        display: block;
        width: 100%;
    }

    thead { display: none; }

    tr {
        border: 2px solid #d1d5db;
        margin-bottom: 15px;
        padding: 10px;
        border-radius: 8px;
        background: #ffffff;
    }

    td {
        border: none;
        text-align: left;
        padding: 6px 0;
    }

    td::before {
        content: attr(data-label);
        font-weight: bold;
        display: inline-block;
        width: 40%;
    }

    .button, .button-disabled {
        width: 100%;
        margin-top: 5px;
    }
}
</style>
</head>

<body class="<?= $themeClass ?>">

<?php if ($cekGrup) { ?>
    <a href="dosen_kelola_group.php" class="kembali">← Kembali</a>
<?php } else { ?>
    <a href="dosen_group_diikuti.php" class="kembali">← Kembali</a>
<?php } ?>

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

<?php while ($row = $threads->fetch_assoc()):
    $isOwner = ($row['username_pembuat'] === $username);
?>
    <tr>
        <td data-label="Pembuat"><?= htmlspecialchars($row['username_pembuat']) ?></td>
        <td data-label="Tanggal"><?= $row['tanggal_pembuatan'] ?></td>
        <td data-label="Status"><?= $row['status'] ?></td>

        <!-- VIEW CHAT -->
        <td data-label="View Chat">
            <form action="dosen_view_chat.php" method="post">
                <input type="hidden" name="idthread" value="<?= $row['idthread'] ?>">
                <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
                <input type="hidden" name="username" value="<?= $username ?>">
                <button class="button" type="submit">View Chat</button>
            </form>
        </td>

        <!-- DELETE -->
        <td data-label="Delete">
        <?php if ($isOwner): ?>
            <form action="dosen_delete_thread.php" method="post">
                <input type="hidden" name="idthread" value="<?= $row['idthread'] ?>">
                <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
                <button class="button" type="submit">Delete</button>
            </form>
        <?php else: ?>
            <button class="button-disabled" disabled>Delete</button>
        <?php endif; ?>
        </td>

        <!-- EDIT -->
        <td data-label="Edit">
        <?php if ($isOwner): ?>
            <form action="dosen_edit_thread.php" method="post">
                <input type="hidden" name="idthread" value="<?= $row['idthread'] ?>">
                <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
                <input type="hidden" name="status" value="<?= $row['status'] ?>">
                <button class="button" type="submit">Edit</button>
            </form>
        <?php else: ?>
            <button class="button-disabled" disabled>Edit</button>
        <?php endif; ?>
        </td>
    </tr>
<?php endwhile; ?>
</table>

</body>
</html>
