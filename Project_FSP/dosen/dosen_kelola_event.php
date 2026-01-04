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
<title>Detail Event Group</title>

<!-- THEME -->
<link rel="stylesheet" href="../css/theme.css">

<style>
body{
    font-family: 'Times New Roman', Times, serif;
    margin: 0;
}

h2, h3{
    text-align: center;
    margin-top: 30px;
    color: #1E3A8A;
}

.center{
    text-align: center;
    margin-top: 15px;
}

button{
    padding: 10px 18px;
    font-weight: bold;
    border: none;
    margin: 5px 0;
    border-radius: 6px;
    background-color: #1E40AF;
    color: white;
    cursor: pointer;
    transition: background-color 0.2s;
}

button:hover{
    background-color: #1E3A8A;
}

.informasiGrup{
    padding: 25px;
    width: 450px;
    margin: 30px auto;
    background: #f8fafc;
    border-radius: 8px;
}

.informasiGrup table,
.daftarEvent table{
    width: 100%;
    border-collapse: collapse;
}

.daftarEvent table{
    width: 90%;
    margin: 20px auto;
}

th, td{
    border: 1px solid #ccc;
    padding: 10px;
    text-align: center;
}

th{
    background-color: #e0e7ff;
    font-weight: bold;
}

img{
    max-width: 180px;
    border-radius: 6px;
}

.insert-event{
    text-align: center;
    margin: 20px 0;
}

@media (max-width: 768px){
    table, thead, tbody, tr, th, td{
        display: block;
        width: 95%;
        margin: auto;
    }

    thead{ display: none; }

    tr{
        margin-bottom: 15px;
        padding: 10px;
        border: 2px solid #1E40AF;
        border-radius: 8px;
    }

    td{
        text-align: left;
        border: none;
    }

    td::before{
        content: attr(data-label);
        font-weight: bold;
        display: block;
        margin-bottom: 4px;
    }

    img{
        max-width: 120px;
    }

    button{
        width: 100%;
        margin-top: 5px;
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
                        file_exists("../image_events/" . $events['idevent'] . "." . $events['poster_extension'])) {
                        echo '<img src="../image_events/' . $events['idevent'] . "." . $events['poster_extension'] . '" width="180">';
                    } else {
                        echo "No photo";
                    }
                    ?>
                </td>
                <td>
                    <form action="dosen_delete_event.php" method="post">
                        <input type="hidden" name="idevent" value="<?= $events['idevent']; ?>">
                        <input type="hidden" name="idgrup" value="<?= $events['idgrup']; ?>">
                        <button type="submit" style="background-color:#2c3e50; color:white;">Hapus</button>
                    </form>
                </td>
                <td>
                    <form action="dosen_edit_event.php" method="post">
                        <input type="hidden" name="idevent" value="<?= $events['idevent']; ?>">
                        <input type="hidden" name="idgrup" value="<?= $events['idgrup']; ?>">
                        <input type="hidden" name="judul" value="<?= $events['judul']; ?>">
                        <input type="hidden" name="tanggal" value="<?= $events['tanggal']; ?>">
                        <input type="hidden" name="keterangan" value="<?= $events['keterangan']; ?>">
                        <input type="hidden" name="jenis" value="<?= $events['jenis']; ?>">
                        <button type="submit" style="background-color:#2c3e50; color:white;">Edit</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

    <div class="insert-event">
        <form action="dosen_insert_event.php" method="post">
            <input type="hidden" name="idgrup" value="<?= $group_detail['idgrup']; ?>">
            <button type="submit" style="background-color:#2c3e50; color:white;">+ Buat Event Baru</button>
        </form>
    </div>
</div>

</body>
</html>
