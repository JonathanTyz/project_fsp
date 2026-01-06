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
/* ======================
   BASE
====================== */
body{
    font-family:'Times New Roman', Times, serif;
    margin:0;
    padding:20px;
}

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

/* ======================
   TABLE
====================== */
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

/* ======================
   BUTTON
====================== */
button{
    width:100%;
    padding:8px;
    font-weight:bold;
    border-radius:6px;
    border:1px solid;
    cursor:pointer;
}

/* ======================
   PAGINATION
====================== */
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

/* ======================
   LIGHT THEME
====================== */
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

body.light button{
    background:#2c3e50;
    color:#fff;
    border-color:#2c3e50;
}

body.light .btn-keluar{
    background:#8b0000;
    border-color:#8b0000;
}

body.light .paging a{
    background:#e5e7eb;
    color:#000;
}

body.light .paging b{
    background:#2c3e50;
    color:#fff;
}

/* ======================
   DARK THEME
====================== */
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

body.dark button{
    background:#3a3a3a;
    color:#fff;
    border-color:#555;
}

body.dark .btn-keluar{
    background:#aa2e2e;
}

body.dark .paging a{
    background:#3a3a3a;
    color:#fff;
}

body.dark .paging b{
    background:#ffffff;
    color:#000;
}

/* ======================
   RESPONSIVE
====================== */
@media (max-width:450px){
    h2{ font-size:26px; }

    table, thead, tbody, th, tr{
        display:block;
    }

    table{
        border:none;
    }

    tr{
        margin-bottom:15px;
        border:2px solid;
        padding:10px;
        border-radius:8px;
    }

    td{
        border:none;
        text-align:left;
        padding:6px 0;
    }

    td::before{
        font-weight:bold;
        display:block;
        margin-bottom:3px;
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
