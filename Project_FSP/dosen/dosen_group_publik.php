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

<link rel="stylesheet" href="../css/theme.css">

<style>
body{
    font-family:'Times New Roman', Times, serif;
    margin:0;
    padding:20px;
}

/* ======================
   TITLE
====================== */
h2{
    text-align:center;
    margin:30px 0 15px;
    font-size:34px;
}

/* ======================
   BACK BUTTON
====================== */
.container-kembali{
    width:90%;
    margin:auto;
}

.kembali{
    display:inline-block;
    padding:8px 14px;
    font-weight:bold;
    text-decoration:none;
    border-radius:6px;
    border:1px solid;
}

table{
    width:90%;
    margin:20px auto;
    border-collapse:collapse;
    border:2px solid;
}

th, td{
    border:1px solid;
    padding:10px;
    text-align:center;
}

th{
    font-weight:bold;
}

.kosong{
    text-align:center;
    padding:20px;
}

.paging{
    text-align:center;
    margin:25px;
}

.paging a,
.paging b{
    display:inline-block;
    margin:4px;
    padding:6px 12px;
    font-weight:bold;
    text-decoration:none;
    border-radius:6px;
    border:1px solid;
}


.insert-kode{
    text-align:center;
    padding:20px;
    border:2px solid;
    width:90%;
    max-width:420px;
    margin:30px auto;
    border-radius:8px;
}

.insert-kode p{
    margin-bottom:15px;
    font-weight:bold;
}

.insert-kode input{
    width:95%;
    padding:10px;
    margin-bottom:12px;
    border:1px solid;
    border-radius:6px;
}

.insert-kode button{
    width:100%;
    padding:10px;
    font-weight:bold;
    border-radius:6px;
    border:1px solid;
}

/* Light theme */
body.light{
    background:#f4f6f8;
    color:#000;
}

body.light h2{
    color:#2c3e50;
}

body.light .kembali{
    background:#e5e7eb;
    color:#000;
    border-color:#d1d5db;
}

body.light table{
    background:#ffffff;
    border-color:#d1d5db;
}

body.light th{
    background:#e9ecef;
}

body.light .paging a{
    background:#e5e7eb;
    color:#000;
}

body.light .paging b{
    background:#2c3e50;
    color:#fff;
}

body.light .insert-kode{
    background:#ffffff;
    border-color:#d1d5db;
}

body.light .insert-kode input{
    background:#ffffff;
    color:#000;
    border-color:#d1d5db;
}

body.light .insert-kode button{
    background:#2c3e50;
    color:#fff;
    border-color:#2c3e50;
}

/* Dark theme */
body.dark{
    background:#1e1e1e;
    color:#eee;
}

body.dark h2{
    color:#ffffff;
}

body.dark .kembali{
    background:#3a3a3a;
    color:#fff;
    border-color:#555;
}

body.dark table{
    background:#2a2a2a;
    border-color:#444;
}

body.dark th{
    background:#333;
}

body.dark .paging a{
    background:#3a3a3a;
    color:#fff;
}

body.dark .paging b{
    background:#ffffff;
    color:#000;
}

body.dark .insert-kode{
    background:#2a2a2a;
    border-color:#444;
}

body.dark .insert-kode input{
    background:#1e1e1e;
    color:#eee;
    border-color:#555;
}

body.dark .insert-kode button{
    background:#3a3a3a;
    color:#fff;
    border-color:#555;
}

/* RWD */
@media (max-width: 768px){
            table, thead, tbody, tr, th, td{
                display: block;
                width: 95%;
            }

            table{
                border: none;
            }

            tr{
                background: white;
                border: 3px solid #2c3e50;
                margin-bottom: 15px;
                padding: 10px;
                border-radius: 6px;
            }

            body.dark tr{
                background-color: #1e1e1e;
                border-color: #555;
            }

            td{
                border: none;
                text-align: left;
                padding: 6px 0;
                position: relative;
            }

            td::before{
                content: attr(data-label);
                font-weight: bold;
                display: block;
                margin-bottom: 4px;
            }

            button{
                margin-top: 5px;
                width: 100%;
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
    echo "<tr><td colspan='5' class='kosong'>Tidak ada grup publik yang tersedia</td></tr>";
} else {
    while ($row = $res->fetch_assoc()) {
        echo "<tr>";
        echo "<td data-label='Nama Grup'>".$row['nama']."</td>";
        echo "<td data-label='Deskripsi'>".$row['deskripsi']."</td>";
        echo "<td data-label='Pembuat'>".$row['username_pembuat']."</td>";
        echo "<td data-label='Tanggal Dibentuk'>".$row['tanggal_pembentukan']."</td>";
        echo "<td data-label='Jenis'>".$row['jenis']."</td>";
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
    echo "<a href='?start=".($offset - $PER_PAGE)."'>Sebelumnya</a>";
}

for ($page = 1; $page <= $max_page; $page++) {
    $offs = ($page - 1) * $PER_PAGE;
    echo ($page == $current_page)
        ? "<b>$page</b>"
        : "<a href='?start=$offs'>$page</a>";
}

if ($current_page < $max_page) {
    echo "<a href='?start=".($offset + $PER_PAGE)."'>Selanjutnya</a>";
}
?>
</div>

<div class="insert-kode">
<form action="dosen_join_group_proses.php" method="post">
    <p>Masukkan Kode Grup Publik:</p>
    <input type="text" name="kode" required>
    <button type="submit">Join Group</button>
</form>
</div>

</body>
</html>
