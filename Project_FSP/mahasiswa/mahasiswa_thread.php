<?php
session_start();
require_once '../class/thread.php';
require_once '../class/chat.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

/* ambil theme dari session */
$themeClass = $_SESSION['theme'] ?? 'light';

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

    <!-- THEME -->
    <link rel="stylesheet" href="../css/theme.css">

    <style>
        body {
            font-family: 'Times New Roman', serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
        }

        table {
            width: 90%;
            margin: 20px auto;
            background: white;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #e9ecef;
            font-weight: bold;
        }

        .button {
            padding: 8px 15px;
            margin: 4px;
            background-color: #2c3e50;
            color: white;
            border: none;
            font-weight: bold;
            cursor: pointer;
        }

        .button-disabled {
            padding: 8px 15px;
            background-color: #b0b0b0;
            color: #666;
            border: none;
        }

        .center {
            text-align: center;
        }

        .container-kembali {
            width: 90%;
            margin: auto;
        }

        .kembali {
            display: inline-block;
            padding: 8px 14px;
            background-color: #6c757d;
            color: white;
            font-weight: bold;
            text-decoration: none;
        }

        /* Dark Theme */
        body.dark {
            background-color: #121212;
            color: #f1f1f1;
        }

        body.dark h2 {
            color: #ffffff;
        }

        body.dark table {
            background-color: #1e1e1e;
        }

        body.dark th {
            background-color: #2a2a2a;
            color: #ffffff;
        }

        body.dark td {
            border-color: #444;
            color: #eeeeee;
        }

        body.dark .button {
            background-color: #3a3a3a;
        }

        body.dark .button:hover {
            background-color: #555;
        }

        body.dark .button-disabled {
            background-color: #555;
            color: #999;
        }

        body.dark .kembali {
            background-color: #444;
        }

        @media (max-width: 600px) {

            table, thead, tbody, tr, th, td {
                display: block;
                width: 100%;
            }

            thead {
                display: none;
            }

            table {
                border: none;
            }

            tr {
                background: white;
                border: 3px solid #2c3e50;
                margin-bottom: 15px;
                padding: 10px;
            }

            body.dark tr {
                background-color: #1e1e1e;
                border-color: #555;
            }

            td {
                border: none;
                text-align: left;
                padding: 6px 0;
            }

            td::before {
                font-weight: bold;
                color: #2c3e50;
                display: block;
                margin-bottom: 3px;
            }

            body.dark td::before {
                color: #cccccc;
            }

            .button,
            .button-disabled {
                width: 100%;
                margin-top: 5px;
            }
        }
    </style>
</head>

<body class="<?= $themeClass ?>">

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
        <th colspan="3">Aksi</th>
    </tr>

    <?php while ($row = $threads->fetch_assoc()) { 
        $isOwner = ($row['username_pembuat'] == $username); ?>
        <tr>
            <td><?= $row['username_pembuat']; ?></td>
            <td><?= $row['tanggal_pembuatan']; ?></td>
            <td><?= $row['status']; ?></td>

            <td>
                <form action="mahasiswa_view_chat.php" method="post">
                    <input type="hidden" name="idthread" value="<?= $row['idthread']; ?>">
                    <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
                    <button class="button" type="submit">View Chat</button>
                </form>
            </td>

            <td>
            <?php if ($isOwner) { ?>
                <form action="mahasiswa_delete_thread.php" method="post">
                    <input type="hidden" name="idthread" value="<?= $row['idthread']; ?>">
                    <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
                    <button class="button" type="submit">Delete</button>
                </form>
            <?php } else { ?>
                <button class="button-disabled" disabled>Delete</button>
            <?php } ?>
            </td>

            <td>
            <?php if ($isOwner) { ?>
                <form action="mahasiswa_edit_thread.php" method="post">
                    <input type="hidden" name="idthread" value="<?= $row['idthread']; ?>">
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
