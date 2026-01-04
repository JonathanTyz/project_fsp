<?php
session_start();
require_once '../class/group.php';
require_once '../class/event.php';
require_once '../css/theme_session.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$group_id = isset($_POST['idgrup']) ? (int)$_POST['idgrup'] : (isset($_GET['idgrup']) ? (int)$_GET['idgrup'] : null);
if (!$group_id) {
    header("Location: dosen_group_diikuti.php");
    exit();
}

$group = new Group();
$group_detail = $group->getDetailGroup($group_id);
if (!$group_detail) {
    header("Location: dosen_group_diikuti.php");
    exit();
}

$event = new Event();
$group_events = $event->getEventsGroup($group_id);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Group & Event</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="../css/theme.css">

<style>
body {
    font-family: 'Times New Roman', serif;
    margin: 0;
    background-color: #f4f6f8;
}

h2 {
    text-align:center;
    margin-top:30px;
    font-size:32px;
    color: #2c3e50;
}

h3 {
    text-align:center;
    margin-bottom:15px;
    color: #2c3e50;
}

.center{
    text-align:center;
    margin-top:15px;
}

.button {
    padding: 10px 18px;
    font-weight: bold;
    border: none;
    border-radius: 6px;
    margin: 5px;
    color: #fff;
    background-color: #1E40AF;
    cursor: pointer;
    transition: background-color 0.2s;
}

.button:hover {
    background-color: #1E3A8A;
}

.informasiGrup {
    background: white;
    padding: 25px 30px;
    width: 450px;
    max-width: 95%;
    margin: 30px auto;
    border-radius: 8px;
    border: 1px solid #ccc;
}

.informasiGrup table {
    width: 100%;
    border-collapse: collapse;
}

.daftarEvent {
    margin: 40px auto;
    width: 95%;
    max-width: 1000px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
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

tr:hover {
    background-color: #f1f5f9;
}

img {
    max-width: 180px;
    height: auto;
    border-radius: 6px;
}

@media (max-width:768px){
    table, thead, tbody, tr, th, td {
        display:block;
        width:100%;
    }

    thead { display:none; }

    tr {
        border:2px solid #2c3e50;
        margin-bottom:15px;
        padding:10px;
        border-radius: 8px;
        background: #fff;
    }

    td {
        border:none;
        text-align:left;
        padding:6px 0;
        display:flex;
        flex-direction: column;
    }

    td::before {
        font-weight:bold;
        content: attr(data-label);
        margin-bottom: 4px;
        color: #2c3e50;
    }

    img {
        max-width: 100%;
        margin-bottom: 10px;
    }
}
</style>
</head>

<body class="<?= $themeClass ?>">

<h2>Detail Group</h2>

<div class="center">
    <form action="dosen_home.php" method="post">
        <button class="button" type="submit">Kembali ke Home</button>
    </form>
    <form action="dosen_group_diikuti.php" method="post">
        <button class="button" type="submit">Kembali ke Daftar Group</button>
    </form>
</div>

<div class="informasiGrup">
    <table>
        <tr><th colspan="2">Informasi Group</th></tr>
        <tr><td>Nama</td><td><?= htmlspecialchars($group_detail['nama']) ?></td></tr>
        <tr><td>Deskripsi</td><td><?= htmlspecialchars($group_detail['deskripsi']) ?></td></tr>
        <tr><td>Pembuat</td><td><?= htmlspecialchars($group_detail['username_pembuat']) ?></td></tr>
        <tr><td>Tanggal Dibentuk</td><td><?= $group_detail['tanggal_pembentukan'] ?></td></tr>
        <tr><td>Jenis</td><td><?= $group_detail['jenis'] ?></td></tr>
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
            <th>Poster</th>
        </tr>

        <?php if (empty($group_events)) : ?>
            <tr><td colspan="5">Belum ada event</td></tr>
        <?php else: ?>
            <?php foreach ($group_events as $events) : ?>
                <tr>
                    <td data-label="Judul"><?= htmlspecialchars($events['judul']) ?></td>
                    <td data-label="Tanggal"><?= $events['tanggal'] ?></td>
                    <td data-label="Keterangan"><?= htmlspecialchars($events['keterangan']) ?></td>
                    <td data-label="Jenis"><?= htmlspecialchars($events['jenis']) ?></td>
                    <td data-label="Poster">
                        <?php
                        if (!empty($events['poster_extension']) &&
                            file_exists("../image_events/".$events['idevent'].".".$events['poster_extension'])) {
                            echo '<img src="../image_events/'.$events['idevent'].'.'.$events['poster_extension'].'" alt="Poster Event">';
                        } else {
                            echo "No poster";
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</div>

</body>
</html>
