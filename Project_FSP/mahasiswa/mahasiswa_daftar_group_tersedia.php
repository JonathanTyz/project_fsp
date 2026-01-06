<?php
session_start();
require_once '../class/group.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$group = new group();

$PER_PAGE = 3;
$offset = isset($_GET['start']) ? (int)$_GET['start'] : 0;

/* ambil theme dari session */
$themeClass = $_SESSION['theme'] ?? 'light';

$res = $group->getAllPublicGroups(
    $_SESSION['user']['username'],
    $offset,
    $PER_PAGE
);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Grup Publik Tersedia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
            color: #2c3e50;
        }

        body.dark h2{
            color: #ffffff;
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
            background: #ffffff;
            border: 4px solid #2c3e50;
        }

        body.dark table{
            background: #2a2a2a;
            border-color: #555;
        }

        th, td{
            border: 1px solid #333;
            padding: 10px;
            text-align: center;
        }

        body.dark th,
        body.dark td{
            border-color: #555;
            color: #eee;
        }

        th{
            background-color: #e9ecef;
        }

        body.dark th{
            background-color: #333;
        }

        .kosong{
            text-align: center;
            padding: 20px;
            color: #555;
        }

        body.dark .kosong{
            color: #ccc;
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

        body.dark .paging a{
            color: #ddd;
        }

        .insert-kode{
            text-align: center;
            padding: 20px;
            border: 4px solid #2c3e50;
            width: 90%;
            max-width: 420px;
            margin: 30px auto;
            background: #ffffff;
        }

        body.dark .insert-kode{
            background: #2a2a2a;
            border-color: #555;
            color: #eee;
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

        .insert-kode button{
            width: 100%;
            padding: 10px;
            font-weight: bold;
            border: none;
            background-color: #2c3e50;
            color: white;
            cursor: pointer;
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
                border: 3px solid #2c3e50;
                padding: 10px;
                background: #ffffff;
            }

            body.dark tr{
                background: #2a2a2a;
                border-color: #555;
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
                color: #2c3e50;
            }

            body.dark td::before{
                color: #bbb;
            }

            .paging a{
                display: inline-block;
                margin: 6px 4px;
            }
        }
    </style>
</head>

<body class="<?= $themeClass ?>">

<h2>Grup Publik Tersedia</h2>

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
        </tr>
    </thead>
    <tbody>
        <?php
        if ($res->num_rows == 0) {
            echo "<tr>
                    <td colspan='5' class='kosong'>Tidak ada grup publik yang tersedia</td>
                </tr>";
        } else {
            while ($row = $res->fetch_assoc()) {
                echo "<tr>";
                echo "<td data-label='Nama Grup'>{$row['nama']}</td>";
                echo "<td data-label='Deskripsi'>{$row['deskripsi']}</td>";
                echo "<td data-label='Pembuat'>{$row['username_pembuat']}</td>";
                echo "<td data-label='Tanggal Dibentuk'>{$row['tanggal_pembentukan']}</td>";
                echo "<td data-label='Jenis'>{$row['jenis']}</td>";
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
    <form action="mahasiswa_join_group.php" method="post">
        <p>Masukkan Kode Grup Publik</p>
        <input type="text" name="kode" placeholder="Kode grup..." required>
        <button type="submit">Join Group</button>
    </form>
</div>

</body>
</html>
