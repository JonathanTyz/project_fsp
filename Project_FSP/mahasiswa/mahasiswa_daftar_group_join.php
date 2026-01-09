<?php
session_start();
require_once '../class/group.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

/* ambil theme dari session */
$themeClass = $_SESSION['theme'] ?? 'light';

$group = new group();

$PER_PAGE = 3;
$offset = isset($_GET['start']) ? (int)$_GET['start'] : 0;

$res = $group->getAllGroupByMember(
    $_SESSION['user']['username'],
    $offset,
    $PER_PAGE
);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Group Yang Diikuti</title>

    <!-- THEME -->
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

        button{
            padding: 6px 10px;
            font-weight: bold;
            border: none;
            background-color: #2c3e50;
            color: white;
            cursor: pointer;
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

        /* Dark Theme */
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
                text-align: center;
                padding: 6px 0;
            }

            button{
                margin-top: 5px;
            }
        }
    </style>
</head>

<body class="<?= $themeClass ?>">

<h2>Group Yang Anda Ikuti</h2>

<div class="container-kembali">
    <a href="mahasiswa_home.php" class="kembali">← Kembali</a>
</div>

<table>
    <thead>
        <tr>
            <th>Nama Grup</th>
            <th>Deskripsi</th>
            <th>Pembuat</th>
            <th>Tanggal Dibentuk</th>
            <th>Jenis</th>
            <th>Event</th>
            <th>Thread</th>
            <th colspan="3">Member</th>
            <th>Keluar</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if ($res->num_rows == 0) {
        echo "<tr><td colspan='11' class='kosong'>Anda belum bergabung ke grup manapun</td></tr>";
    } else {
        while ($row = $res->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['nama']}</td>";
            echo "<td>{$row['deskripsi']}</td>";
            echo "<td>{$row['username_pembuat']}</td>";
            echo "<td>{$row['tanggal_pembentukan']}</td>";
            echo "<td>{$row['jenis']}</td>";

            echo "<td>
                <form action='mahasiswa_view_event.php' method='post'>
                    <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                    <button type='submit'>Lihat Event</button>
                </form>
            </td>";

            echo "<td>
                <form action='mahasiswa_thread.php' method='post'>
                    <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                    <button type='submit'>Lihat Thread</button>
                </form>
            </td>";

            echo "<td>
                <form action='mahasiswa_view_member.php' method='post'>
                    <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                    <button type='submit'>Semua Member</button>
                </form>
            </td>";

            echo "<td>
                <form action='mahasiswa_view_member_mahasiswa.php' method='post'>
                    <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                    <button type='submit'>Member Mahasiswa</button>
                </form>
            </td>";

            echo "<td>
                <form action='mahasiswa_view_member_dosen.php' method='post'>
                    <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                    <button type='submit'>Member Dosen</button>
                </form>
            </td>";

            echo "<td>
                <form action='mahasiswa_keluar_group.php' method='post'>
                    <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                    <button type='submit'>Keluar</button>
                </form>
            </td>";

            echo "</tr>";
        }
    }
    ?>
    </tbody>
</table>

<div class="paging">
<?php
$total_data = $group->countGroupByMember($_SESSION['user']['username']);
$max_page = ceil($total_data / $PER_PAGE);
$current_page = floor($offset / $PER_PAGE) + 1;

if ($current_page > 1) {
    echo "<a href='?start=" . ($offset - $PER_PAGE) . "'>Sebelumnya</a>";
}

for ($page = 1; $page <= $max_page; $page++) {
    $offs = ($page - 1) * $PER_PAGE;
    echo ($page == $current_page)
        ? "<b>$page</b>"
        : "<a href='?start=$offs'>$page</a>";
}

if ($current_page < $max_page) {
    echo "<a href='?start=" . ($offset + $PER_PAGE) . "'>Selanjutnya</a>";
}
?>
</div>

</body>
</html>
