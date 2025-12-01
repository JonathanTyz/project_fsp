<?php
session_start();
require_once 'class/group.php';
require_once 'class/event.php';
require_once 'class/chat.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['idgrup'])) {
    $group_id = $_POST['idgrup'];
} 
elseif (isset($_GET['idgrup'])) {
    $group_id = $_GET['idgrup'];
} else 
{
    header("Location: mahasiswa_home.php");
    exit();
}

$group = new group();
$group_detail = $group->getDetailGroup($group_id);

if (!$group_detail) {
    header("Location: mahasiswa_home.php");
    exit();
}


$event = new event();
$group_events = $event->getEventsGroup($group_id);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail Group Mahasiswa</title>
    <style>
        body 
        { 
            font-family:'Times New Roman';
             margin:0; 
        }
        h2 
        { 
            text-align:center; 
            margin-top:30px; 
            font-size:36px; 
            font-weight:bold; 
        }

        table {
            width:90%; 
            margin:20px auto; 
            background:white; 
            border:10px solid #333;
        }
        th, td { 
            border:1px solid black; padding:8px; text-align:center; 
        }

        .informasiGrup {
            background:white; padding:30px 40px; text-align:center;
            width:400px; margin:30px auto; border:10px solid #333;
        }

        .center { 
            text-align:center; 
        }
        .button 
        {
            padding:8px 12px; background:#ccc; border:1px solid black;
            font-weight:bold; text-decoration:none; color:black;
        }
        .daftarEvent{
            margin-top:40px;
            margin-bottom:40px;
            text-align:center;
            
        }
    </style>
</head>
<body>

<h2>Detail Group</h2>

<div class="center">
    <form action="mahasiswa_home.php" method="post">
        <button class="button" type="submit">Kembali ke Home</button>
    </form>
</div>

<div class="informasiGrup">
    <table>
        <tr><th colspan="2">Informasi Group</th></tr>

        <tr><th>Informasi</th><th>Detail</th></tr>

        <tr><td>Nama</td><td><?php echo $group_detail['nama']; ?></td></tr>
        <tr><td>Deskripsi</td><td><?php echo $group_detail['deskripsi']; ?></td></tr>
        <tr><td>Pembuat</td><td><?php echo $group_detail['username_pembuat']; ?></td></tr>
        <tr><td>Tanggal Dibentuk</td><td><?php echo $group_detail['tanggal_pembentukan']; ?></td></tr>
        <tr><td>Jenis</td><td><?php echo $group_detail['jenis']; ?></td></tr>
        <tr><td>Kode Pendaftaran</td><td><?php echo $group_detail['kode_pendaftaran']; ?></td></tr>
    </table>
</div>


<div class="daftarEvent">
    <h3 style="text-align:center;">Daftar Event</h3>

    <table>
        <tr>
            <th>Judul</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Jenis</th>
            <th>Foto</th>
        </tr>

        <?php foreach ($group_events as $events) { ?>
            <tr>
                <td><?php echo $events['judul']; ?></td>
                <td><?php echo $events['tanggal']; ?></td>
                <td><?php echo $events['keterangan']; ?></td>
                <td><?php echo $events['jenis']; ?></td>

                <td>
                    <?php
                    if (!empty($events['poster_extension'])) {;
                        if (file_exists("image_events/" . $events['idevent'] . "." . $events['poster_extension'])) {
                            echo '<img src="image_events/' . $events['idevent'] . "." . $events['poster_extension'] . '" width="200">';
                        } else {
                            echo "No photo";
                        }
                    } else {
                        echo "No photo";
                    }
                    ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
