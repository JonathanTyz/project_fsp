<?php
session_start();
require_once 'class/group.php';
require_once 'class/event.php';
require_once 'class/chat.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$group_id = (int)$_POST['id'];
$group = new group();
$group_detail = $group->getDetailGroup($group_id);

if (!$group_detail) {
    header("Location: dosen_home.php");
    exit();
}

if ($group_detail['username_pembuat'] !== $_SESSION['user']['username']) {
    header("Location: dosen_home.php");
    exit();
}

$members = $group->getGroupMembers($group_id);

$event = new event();
$group_events = $event->getEventsGroup($group_id);

$chat = new chat();
$group_threads = $chat->getThreadGroup($group_id);

$search_result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $keyword = $_POST['search'];

    $conn = new mysqli("localhost", "root", "", "FULLSTACK"); 
    $keyword = $conn->real_escape_string($keyword);

    $sql = "SELECT m.nrp, m.nama, a.username
        FROM mahasiswa m
        JOIN akun a ON a.nrp_mahasiswa = m.nrp
        WHERE m.nrp LIKE '%$keyword%' 
           OR m.nama LIKE '%$keyword%'";

    $search_result = $conn->query($sql);
}   
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail Group</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
        }
        h2 {
            text-align: center;
            margin-top: 30px;
            color: #333;
            font-size: 36px;
            font-weight: bold;
        }
        table {
            width: 90%;
            margin: 20px auto;
            background: white;
            border: 10px solid #333;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .informasiGrup {
            background-color: white;
            padding: 30px 40px;
            text-align: center;
            width: 400px;
            margin: 30px auto;
            border: 10px solid #333;
        }
        .daftarMember {
            margin: 30px auto;
            width: 90%;
            text-align: center;
        }

        .daftarEvent {
            margin: 30px auto;
            width: 90%; 
            text-align: center;
        }

        .tambahMember {
            margin: 30px auto;
            width: 90%;
            text-align: center;
        }

        .search-box {
            margin: 10px 0;
            padding: 8px;
            width: 300px;
        }
        .button {
            padding: 5px 10px;
            background: #ccc;
            border: 1px solid black;
            font-weight: bold;
            color: black;
            text-align: center;
        }
        .center{
            text-align: center;
        }
    </style>
</head>
<body>

    <h2>Detail Group</h2>

   <div class="informasiGrup">
        <table>
            <tr>
                <th colspan="2">Informasi Group</th>
            </tr>
            <tr>
                <th>Informasi</th>
                <th>Detail</th>
            </tr>
            <tr>
                <td><p>Nama</p></td>
                <td><p><?php echo $group_detail['nama']; ?></p></td>
            </tr>

            <tr>
                <td><p>Keterangan</p></td>
                <td><p><?php echo $group_detail['deskripsi']; ?></p></td>
            </tr>

            <tr>
                <td><p>Username Pembuat</p></td>
                <td><p><?php echo $group_detail['username_pembuat']; ?></p></td>
            </tr>

            <tr>
                <td><p>Tanggal Dibentuk</p></td>
                <td><p><?php echo $group_detail['tanggal_pembentukan']; ?></p></td>
            </tr>

            <tr>
                <td><p>Jenis</p></td>
                <td><p><?php echo $group_detail['jenis']; ?></p></td>
            </tr>

            <tr>
                <td><p>Kode Pendaftaran</p></td>
                <td><p><?php echo $group_detail['kode_pendaftaran']; ?></p></td>
            </tr>
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
                <th>Aksi</th>
            </tr>

            <?php foreach ($group_events as $events) { ?>
                <tr>
                    <td><?php echo $events['judul']; ?></td>
                    <td><?php echo $events['tanggal']; ?></td>
                    <td><?php echo $events['keterangan']; ?></td>
                    <td><?php echo $events['jenis']; ?></td>
                    <td>
                        <?php
                            if (!empty($events['foto']) && file_exists("image_events/" . $events['foto'])) {
                                echo '<img src="image_events/' . $events['foto'] . '" width="50">';
                            } else {
                                echo 'No photo';
                            }
                        ?>
                    </td>
                    <td>
                        <form method="post" action="dosen_delete_event.php" style="margin:0;">
                            <input type="hidden" name="idgrup" value="<?php echo $events['idgrup']; ?>">
                            <input type="hidden" name="idevent" value="<?php echo $events['idevent']; ?>">
                            <button class="button" name="btnHapus" value="hapus" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <br>
        <a href = "dosen_insert_event.php" class = 'button' type="submit">Insert Event</a>
    </div>

    <div class="daftarMember">
        <h3>Daftar Member</h3>
        <table>
            <tr>
                <th>Username</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>

            <?php foreach ($members as $member) { ?>
                <tr>
                    <td><?php echo $member['username']; ?></td>
                    <td><?php echo $member['nama']; ?></td>
                    <form method = "post" action = "dosen_delete_member.php">
                        <input type="hidden" name="idgrup" value="<?php echo $group_id; ?>">
                        <input type="hidden" name="username" value="<?php echo $member['username']; ?>">
                        <td><button class = "button" name="btnHapus" value="hapus" type="submit">Hapus</button></td>
                    </form>
                </tr>
            <?php } ?>
        </table>
    </div>

    <div class="tambahMember">
        <h3>Tambah Member</h3>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo $group_id; ?>">
            <input type="text" name="search" class="search-box" placeholder="Cari NRP atau Nama">
            <button type="submit">Cari</button>
        </form>

        <?php   
        if ($search_result !== null) { 
            
            echo "<h4>Hasil Pencarian:</h4>";

            echo "<table>";
            echo "<tr>";
            echo "<th>NRP</th>";
            echo "<th>Nama</th>";
            echo "<th>Aksi</th>";
            echo "</tr>";

            if ($search_result->num_rows > 0) {

                while ($message = $search_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $message['nrp'] . "</td>";
                    echo "<td>" . $message['nama'] . "</td>";
                    ?>
                    <form method="post" action="dosen_insert_member_proses.php">
                        <input type="hidden" name="id" value="<?php echo $group_id; ?>">
                        <input type="hidden" name="username" value="<?php echo $message['username']; ?>">
                        <td><button class="button" name="btnTambah" value="tambah" type="submit">Tambah</button></td>
                    </form>
                    <?php echo "</tr>";

                }
            } else 
            {
                echo "<tr>";
                echo "<td colspan='3'>Tidak ada hasil</td>";
                echo "</tr>";
            }
            echo "</table>";
        } 
        ?>

    </div>

</body>
</html>
