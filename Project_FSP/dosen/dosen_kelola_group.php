<?php
session_start();
require_once '../class/group.php';
require_once '../css/theme_session.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$themeClass = $_SESSION['theme'] ?? 'light';

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

    <link rel="stylesheet" href="../css/theme.css">

    <style>
        body{
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            background-color: #f4f6f8;
        }

        h2{
            text-align: center;
            margin: 25px 0 10px;
            color: #2c3e50;
            font-size: 32px;
        }

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

        table{
            width: 90%;
            margin: 15px auto;
            background: white;
            border: 5px solid #2c3e50;
        }

        th, td{
            border: 1px solid #333;
            padding: 10px;
            text-align: center;
        }

        th{
            background-color: #e9ecef;
        }

        /* === TOMBOL SAMA PERSIS MAHASISWA === */
        button{
            padding: 6px 10px;
            font-weight: bold;
            border: none;
            background-color: #2c3e50;
            color: white;
            width: 100%;
            cursor: pointer;
        }

        button:hover{
            opacity: 0.9;
        }

        .paging{
            text-align: center;
            margin: 25px;
        }

        .paging a{
            margin: 0 6px;
            font-weight: bold;
            color: #2c3e50;
            text-decoration: none;
        }

        .kosong{
            text-align: center;
            padding: 20px;
            color: #555;
        }

        .insert-group{
            text-align: center;
            margin: 30px 0 40px;
        }

        /* ===== DARK MODE (SAMA MAHASISWA) ===== */
        body.dark{
            background-color: #121212;
            color: #f1f1f1;
        }

        body.dark h2{
            color: #ffffff;
        }

        body.dark table{
            background-color: #1e1e1e;
            border-color: #555;
        }

        body.dark th{
            background-color: #2a2a2a;
            color: #ffffff;
        }

        body.dark td{
            border-color: #444;
            color: #eeeeee;
        }

        body.dark tr{
            background-color: #1e1e1e;
        }

        body.dark .kembali{
            background-color: #444;
            color: #ffffff;
        }

        body.dark button{
            background-color: #3a3a3a;
            color: #ffffff;
        }

        body.dark button:hover{
            background-color: #555;
        }

        body.dark .paging a{
            color: #dddddd;
        }

        body.dark .kosong{
            color: #bbbbbb;
        }

        @media (max-width: 768px){
            table, thead, tbody, tr, th, td{
                display: block;
                width: 100%;
            }

            table{
                border: none;
            }

            tr{
                background: white;
                border: 3px solid #2c3e50;
                margin-bottom: 15px;
                padding: 10px;
            }

            body.dark tr{
                background-color: #1e1e1e;
                border-color: #555;
            }

            td{
                border: none;
                text-align: left;
                padding: 6px 0;
            }

            button{
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
    <?php
    if ($result_grup->num_rows == 0) {
        echo "<tr><td colspan='8' class='kosong'>Anda belum memiliki grup</td></tr>";
    } else {
        while ($row = $result_grup->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['nama']}</td>";
            echo "<td>{$row['deskripsi']}</td>";
            echo "<td>{$row['jenis']}</td>";

            echo "<td>
                <form action='dosen_kelola_event.php' method='post'>
                    <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                    <button type='submit'>Event</button>
                </form>
            </td>";

            echo "<td>
                <form action='dosen_thread.php' method='get'>
                    <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                    <button type='submit'>Thread</button>
                </form>
            </td>";

            echo "<td>
                <form action='dosen_view_member.php' method='post'>
                    <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                    <button type='submit'>Member</button>
                </form>
            </td>";

            echo "<td>
                <form action='dosen_edit_group.php' method='post'>
                    <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                    <button type='submit'>Edit</button>
                </form>
            </td>";

            echo "<td>
                <form action='dosen_delete_group.php' method='post'>
                    <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                    <button type='submit'>Hapus</button>
                </form>
            </td>";

            echo "</tr>";
        }
    }
    ?>
    </tbody>
</table>

<div class="insert-group">
    <form action="dosen_insert_group.php" method="post">
        <button type="submit">+ Buat Group Baru</button>
    </form>
</div>

</body>
</html>
