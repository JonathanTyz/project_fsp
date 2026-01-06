<?php
session_start();
require_once '../class/group.php';
require_once '../class/event.php';
require_once '../class/chat.php';
require_once '../css/theme_session.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$group_id = $_POST['idgrup'] ?? $_GET['idgrup'] ?? null;

if (!$group_id) {
    header("Location: dosen_kelola_group.php");
    exit();
}

$group = new Group();
$group_detail = $group->getDetailGroup($group_id);

if (!$group_detail) {
    header("Location: dosen_kelola_group.php");
    exit();
}

$event = new Event();
$group_events = $event->getEventsGroup($group_id);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Event</title>

<link rel="stylesheet" href="../css/theme.css">

<style>
/* ======================
   BASE
====================== */
body{
    font-family: "Segoe UI", Tahoma, sans-serif;
    margin:0;
}

h2, h3{
    text-align:center;
    margin-top:30px;
}

.center{
    text-align:center;
    margin-top:15px;
}

/* ======================
   BUTTON (DEFAULT)
====================== */
button{
    padding:10px 20px;
    font-weight:600;
    border-radius:6px;
    border:1px solid;
    cursor:pointer;
    transition:.2s;
}

/* ======================
   CARD INFORMASI
====================== */
.informasiGrup{
    width:420px;
    margin:30px auto;
    padding:25px;
    border-radius:10px;
}

/* ======================
   TABLE
====================== */
table{
    width:100%;
    border-collapse:collapse;
}

.daftarEvent table{
    width:90%;
    margin:20px auto;
}

th, td{
    padding:10px;
    text-align:center;
    border:1px solid;
}

img{
    max-width:180px;
    border-radius:6px;
}

.insert-event{
    text-align:center;
    margin:25px 0;
}

/* ======================
   LIGHT THEME
====================== */
body.light{
    background:#f4f6f8;
    color:#000;
}

body.light h2,
body.light h3{
    color:#2c3e50;
}

body.light .informasiGrup{
    background:#ffffff;
    border:1px solid #2c3e50;
}

body.light table{
    background:#ffffff;
}

body.light th{
    background:#e9ecef;
}

body.light td{
    background:#ffffff;
}

/* BUTTON LIGHT → ABU GELAP */
body.light button{
    background:#2c3e50;
    color:white;
    border-color:#2c3e50;
}

body.light button:hover{
    background:#1f2d3a;
}

/* ======================
   DARK THEME
====================== */
body.dark{
    background:#1e1e1e;
    color:#eee;
}

body.dark h2,
body.dark h3{
    color:#ffffff;
}

body.dark .informasiGrup{
    background:#2a2a2a;
    border:1px solid #555;
    box-shadow:0 10px 25px rgba(0,0,0,.5);
}

body.dark table{
    background:#2a2a2a;
}

body.dark th{
    background:#333;
}

body.dark td{
    background:#2a2a2a;
}

/* BUTTON DARK → ABU */
body.dark button{
    background:#3a3a3a;
    color:white;
    border-color:#555;
}

body.dark button:hover{
    background:#555;
}

/* ======================
   RESPONSIVE
====================== */
@media (max-width:768px){
    table, thead, tbody, tr, th, td{
        display:block;
        width:95%;
        margin:auto;
    }

    thead{ display:none; }

    tr{
        margin-bottom:15px;
        padding:10px;
        border-radius:8px;
    }

    body.light tr{
        background:#ffffff;
        border:1px solid #2c3e50;
    }

    body.dark tr{
        background:#2a2a2a;
        border:1px solid #444;
    }

    td{
        border:none;
        text-align:left;
    }

    td::before{
        content:attr(data-label);
        font-weight:600;
        display:block;
        margin-bottom:4px;
    }

    button{
        width:100%;
        margin-top:6px;
    }
}

</style>
</head>

<body class="<?= $themeClass ?>">

<h2>Detail Event</h2>

<div class="center">
    <form action="dosen_home.php" method="post">
        <button type="submit">Kembali ke Home</button>
    </form>

    <form action="dosen_kelola_group.php" method="post">
        <button type="submit">Kembali ke Daftar Group</button>
    </form>
</div>

<div class="informasiGrup">
    <table>
        <tr><th colspan="2">Informasi Group</th></tr>
        <tr><td>Nama</td><td><?= htmlspecialchars($group_detail['nama']); ?></td></tr>
        <tr><td>Deskripsi</td><td><?= htmlspecialchars($group_detail['deskripsi']); ?></td></tr>
        <tr><td>Pembuat</td><td><?= htmlspecialchars($group_detail['username_pembuat']); ?></td></tr>
        <tr><td>Tanggal Dibentuk</td><td><?= $group_detail['tanggal_pembentukan']; ?></td></tr>
        <tr><td>Jenis</td><td><?= htmlspecialchars($group_detail['jenis']); ?></td></tr>
    </table>
</div>

<div class="daftarEvent">
    <h3>Daftar Event</h3>

    <table>
        <tr>
            <th>Judul</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Jenis</th>
            <th>Foto</th>
            <th>Hapus</th>
            <th>Edit</th>
        </tr>

        <?php foreach ($group_events as $events) { ?>
        <tr>
            <td data-label="Judul"><?= $events['judul']; ?></td>
            <td data-label="Tanggal"><?= $events['tanggal']; ?></td>
            <td data-label="Keterangan"><?= $events['keterangan']; ?></td>
            <td data-label="Jenis"><?= $events['jenis']; ?></td>
            <td>
                <?php
                if (!empty($events['poster_extension']) &&
                    file_exists("../image_events/".$events['idevent'].".".$events['poster_extension'])) {
                    echo '<img src="../image_events/'.$events['idevent'].".".$events['poster_extension'].'">';
                } else {
                    echo "No photo";
                }
                ?>
            </td>
            <td>
                <form action="dosen_delete_event.php" method="post">
                    <input type="hidden" name="idevent" value="<?= $events['idevent']; ?>">
                    <input type="hidden" name="idgrup" value="<?= $events['idgrup']; ?>">
                    <button type="submit">Hapus</button>
                </form>
            </td>
            <td>
                <form action="dosen_edit_event.php" method="post">
                    <input type="hidden" name="idevent" value="<?= $events['idevent']; ?>">
                    <input type="hidden" name="idgrup" value="<?= $events['idgrup']; ?>">
                    <button type="submit">Edit</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

    <div class="insert-event">
        <form action="dosen_insert_event.php" method="post">
            <input type="hidden" name="idgrup" value="<?= $group_detail['idgrup']; ?>">
            <button type="submit">+ Buat Event Baru</button>
        </form>
    </div>
</div>

</body>
</html>
