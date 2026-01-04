<?php
session_start();
require_once '../class/group.php';
require_once '../css/theme_session.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$group = new Group();

$PER_PAGE = 3;
$offset = isset($_GET['start']) ? (int)$_GET['start'] : 0;

$result_grup = $group->getAllMadeGroup(
    $_SESSION['user']['username'],
    $offset,
    $PER_PAGE
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Grup Saya</title>

    <!-- THEME -->
    <link rel="stylesheet" href="../css/theme.css">

    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
        }

        h2 {
            text-align: center;
            margin: 30px 0 10px;
            font-size: 34px;
            color: #1E3A8A;
        }

        .container-kembali {
            width: 90%;
            margin: auto;
        }

        .kembali {
            display: inline-block;
            padding: 8px 14px;
            font-weight: bold;
            text-decoration: none;
            color: #1E40AF;
        }

        table {
            width: 90%;
            margin: 15px auto;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #333;
            padding: 10px;
            text-align: center;
        }

        th {
            font-weight: bold;
            background-color: #e0e7ff;
        }

        /* BUTTON BIRU TEMA */
        .btn-fixed {
            background-color: #1E40AF;
            color: white;
            border: none;
            padding: 6px 12px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-fixed:hover {
            background-color: #1E3A8A;
        }

        .paging {
            text-align: center;
            margin: 25px;
        }

        .insert-group {
            text-align: center;
            margin: 30px 0;
        }

        @media (max-width: 768px) {
            table, thead, tbody, tr, th, td {
                display: block;
                width: 95%;
                margin: auto;
            }

            tr {
                margin-bottom: 15px;
                padding: 10px;
                border: 2px solid #1E40AF;
                border-radius: 8px;
            }

            td {
                text-align: left;
                border: none;
                padding: 6px 0;
            }

            td::before {
                content: attr(data-label);
                font-weight: bold;
                display: block;
            }

            .btn-fixed {
                width: 100%;
                margin-top: 5px;
            }
        }
    </style>
</head>

<body class="<?= $themeClass ?>">

<h2>Grup Anda</h2>

<div class="container-kembali">
    <a href="dosen_home.php" class="kembali">← Kembali</a>
</div>

<table>
    <thead>
        <tr>
            <th>Nama Grup</th>
            <th>Deskripsi</th>
            <th>Jenis</th>
            <th>Event</th>
            <th>Thread</th>
            <th>Member</th>
            <th>Edit</th>
            <th>Hapus</th>
        </tr>
    </thead>
    <tbody>
    <?php if ($result_grup->num_rows == 0): ?>
        <tr>
            <td colspan="8">Anda belum memiliki grup.</td>
        </tr>
    <?php else: ?>
        <?php while ($row = $result_grup->fetch_assoc()): ?>
        <tr>
            <td data-label="Nama Grup"><?= htmlspecialchars($row['nama']) ?></td>
            <td data-label="Deskripsi"><?= htmlspecialchars($row['deskripsi']) ?></td>
            <td data-label="Jenis"><?= htmlspecialchars($row['jenis']) ?></td>

            <td data-label="Event">
                <form action="dosen_kelola_event.php" method="post">
                    <input type="hidden" name="idgrup" value="<?= $row['idgrup'] ?>">
                    <button type="submit" class="btn-fixed">Event</button>
                </form>
            </td>

            <td data-label="Thread">
                <form action="dosen_thread.php" method="get">
                    <input type="hidden" name="idgrup" value="<?= $row['idgrup'] ?>">
                    <button type="submit" class="btn-fixed">Thread</button>
                </form>
            </td>

            <td data-label="Member">
                <form action="dosen_view_member.php" method="post">
                    <input type="hidden" name="idgrup" value="<?= $row['idgrup'] ?>">
                    <button type="submit" class="btn-fixed">Member</button>
                </form>
            </td>

            <td data-label="Edit">
                <form action="dosen_edit_group.php" method="post">
                    <input type="hidden" name="idgrup" value="<?= $row['idgrup'] ?>">
                    <button type="submit" class="btn-fixed">Edit</button>
                </form>
            </td>

            <td data-label="Hapus">
                <form action="dosen_delete_group.php" method="post">
                    <input type="hidden" name="idgrup" value="<?= $row['idgrup'] ?>">
                    <button type="submit" class="btn-fixed">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    <?php endif; ?>
    </tbody>
</table>

<div class="insert-group">
    <form action="dosen_insert_group.php" method="post">
        <button class="btn-fixed">+ Buat Group Baru</button>
    </form>
</div>

</body>
</html>
