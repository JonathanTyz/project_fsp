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

$res = $group->getAllPublicGroups(
    $_SESSION['user']['username'],
    $offset,
    $PER_PAGE
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Grup Publik Tersedia</title>
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
            margin: 30px 0 10px;
            font-size: 34px;
        }

        .container-kembali{
            width: 90%;
            margin: auto;
        }

        /* ===== TOMBOL KEMBALI (MIRIP HOME - btn-publik) ===== */
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
            border: 4px solid;
            border-collapse: collapse;
        }

        th, td{
            border: 1px solid;
            padding: 10px;
            text-align: center;
        }

        th{
            font-weight: bold;
        }

        .kosong{
            text-align: center;
            padding: 20px;
        }

        /* ===== PAGINATION (MIRIP HOME) ===== */
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

        /* ===== JOIN GROUP BOX ===== */
        .insert-kode{
            text-align: center;
            padding: 20px;
            border: 4px solid;
            width: 90%;
            max-width: 420px;
            margin: 30px auto;
        }

        .insert-kode p{
            margin-bottom: 15px;
            font-weight: bold;
        }

        .insert-kode input{
            width: 90%;
            padding: 10px;
            margin-bottom: 12px;
        }

        /* ===== TOMBOL JOIN (MIRIP btn-kelola) ===== */
        .insert-kode button{
            width: 100%;
            padding: 10px;
            font-weight: bold;
            border: none;
            background-color: darkslategray;
            color: white;
            cursor: pointer;
        }

        .insert-kode button:hover{
            opacity: 0.9;
        }

        @media (max-width: 450px){
            h2{
                font-size: 26px;
            }

            table, thead, tbody, th, tr{
                display: block;
            }

            table{
                border: none;
            }

            tr{
                margin-bottom: 15px;
                border: 3px solid;
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

            .paging a, .paging b{
                display: inline-block;
                margin: 6px 4px;
            }
        }
    </style>
</head>

<body class="<?= $themeClass ?>">

<h2>Grup Publik Tersedia</h2>

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
        </tr>
    </thead>
    <tbody>
        <?php
        if ($res->num_rows == 0) {
            echo "
            <tr>
                <td colspan='5' class='kosong'>
                    Tidak ada grup publik yang tersedia
                </td>
            </tr>";
        } else {
            while ($row = $res->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".htmlspecialchars($row['nama'])."</td>";
                echo "<td>".htmlspecialchars($row['deskripsi'])."</td>";
                echo "<td>".htmlspecialchars($row['username_pembuat'])."</td>";
                echo "<td>".htmlspecialchars($row['tanggal_pembentukan'])."</td>";
                echo "<td>".htmlspecialchars($row['jenis'])."</td>";
                echo "</tr>";
            }
        }
        ?>
    </tbody>
</table>

<div class="paging">
<?php
$result_all = $group->getAllPublicGroups($_SESSION['user']['username']);
$total_data = $result_all->num_rows;

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

<div class="insert-kode">
    <form action="dosen_join_group_proses.php" method="post">
        <p>Masukkan Kode grup publik untuk Pendaftaran:</p>
        <input type="text" name="kode" required>
        <button type="submit">Join Group</button>
    </form>
</div>

</body>
</html>
