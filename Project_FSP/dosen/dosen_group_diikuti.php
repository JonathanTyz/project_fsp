<?php
session_start();
require_once '../class/group.php';
require_once '../css/theme_session.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$group = new group();

$PER_PAGE = 3;
$offset = isset($_GET['start']) ? max(0, (int)$_GET['start']) : 0;

$result_grup = $group->getAllGroupByMember(
    $_SESSION['user']['username'],
    $offset,
    $PER_PAGE
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Grup yang Saya Ikuti</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- THEME -->
    <link rel="stylesheet" href="../css/theme.css">

    <style>
        body{
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
        }

        h2{
            text-align: center;
            margin: 25px 0 10px;
            font-size: 32px;
        }

        .container-kembali{
            width: 90%;
            margin: auto;
        }

        /* ===== KEMBALI (btn-publik) ===== */
        .kembali{
            display: inline-block;
            padding: 8px 14px;
            font-weight: bold;
            text-decoration: none;
            background-color: steelblue;
            color: white;
        }

        .kembali:hover{
            opacity: 0.9;
        }

        table{
            width: 90%;
            margin: 15px auto;
            border: 5px solid;
            border-collapse: collapse;
        }

        th, td{
            border: 1px solid;
            padding: 10px;
            text-align: center;
        }

        /* ===== BUTTON GLOBAL ===== */
        button{
            padding: 6px 10px;
            font-weight: bold;
            border: none;
            width: 100%;
            color: white;
            cursor: pointer;
        }

        button:hover{
            opacity: 0.9;
        }

        /* ===== WARNA BUTTON SESUAI HOME ===== */
        .btn-event{ background-color: darkslategray; }   /* Kelola */
        .btn-thread{ background-color: midnightblue; }  /* Diikuti */
        .btn-member{ background-color: steelblue; }     /* Publik */
        .btn-keluar{ background-color: darkred; }       /* Logout */

        /* ===== PAGINATION ===== */
        .paging{
            text-align: center;
            margin: 25px;
        }

        .paging a{
            margin: 0 6px;
            font-weight: bold;
            text-decoration: none;
            background-color: midnightblue;
            color: white;
            padding: 6px 10px;
        }

        .paging a:hover{
            opacity: 0.9;
        }

        .paging b{
            background-color: darkcyan;
            color: white;
            padding: 6px 10px;
        }

        .kosong{
            text-align: center;
            padding: 20px;
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
                border: 3px solid;
                margin-bottom: 15px;
                padding: 10px;
            }

            td{
                border: none;
                text-align: left;
                padding: 6px 0;
            }

            td::before{
                font-weight: bold;
                display: block;
                margin-bottom: 3px;
            }

            button{
                margin-top: 5px;
            }

            .paging a, .paging b{
                display: inline-block;
                margin: 6px 4px;
            }
        }
    </style>
</head>

<body class="<?= $themeClass ?>">

<h2>Grup yang Anda Ikuti</h2>

<div class="container-kembali">
    <a href="dosen_home.php" class="kembali">← Kembali</a>
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
    if ($result_grup->num_rows == 0) {
        echo "
        <tr>
            <td colspan='11' class='kosong'>
                Anda belum mengikuti grup apapun
            </td>
        </tr>";
    } else {
        while ($row = $result_grup->fetch_assoc()) {
            echo "<tr>
                <td>".htmlspecialchars($row['nama'])."</td>
                <td>".htmlspecialchars($row['deskripsi'])."</td>
                <td>".htmlspecialchars($row['username_pembuat'])."</td>
                <td>".htmlspecialchars($row['tanggal_pembentukan'])."</td>
                <td>".htmlspecialchars($row['jenis'])."</td>

                <td>
                    <form action='dosen_view_event.php' method='post'>
                        <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                        <button class='btn-event'>Detail</button>
                    </form>
                </td>

                <td>
                    <form action='dosen_thread.php' method='post'>
                        <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                        <button class='btn-thread'>Thread</button>
                    </form>
                </td>

                <td>
                    <form action='dosen_view_group_allmember.php' method='post'>
                        <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                        <button class='btn-member'>Semua</button>
                    </form>
                </td>

                <td>
                    <form action='dosen_view_group_member_mahasiswa.php' method='post'>
                        <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                        <button class='btn-member'>Mahasiswa</button>
                    </form>
                </td>

                <td>
                    <form action='dosen_view_group_member_dosen.php' method='post'>
                        <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                        <button class='btn-member'>Dosen</button>
                    </form>
                </td>

                <td>
                    <form action='dosen_keluar_group.php' method='post'>
                        <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                        <button class='btn-keluar'>Keluar</button>
                    </form>
                </td>
            </tr>";
        }
    }
    ?>
    </tbody>
</table>

<div class="paging">
<?php
$res_total = $group->getAllGroupByMember($_SESSION['user']['username']);
$total_data = $res_total->num_rows;

$max_page = ceil($total_data / $PER_PAGE);
$current_page = floor($offset / $PER_PAGE) + 1;

if ($current_page > 1) {
    $prev = $offset - $PER_PAGE;
    echo "<a href='?start=$prev'>Sebelumnya</a>";
}

for ($page = 1; $page <= $max_page; $page++) {
    $offs = ($page - 1) * $PER_PAGE;
    if ($page == $current_page) {
        echo "<b>$page</b>";
    } else {
        echo "<a href='?start=$offs'>$page</a>";
    }
}

if ($current_page < $max_page) {
    $next = $offset + $PER_PAGE;
    echo "<a href='?start=$next'>Selanjutnya</a>";
}
?>
</div>

</body>
</html>
