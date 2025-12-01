<?php
session_start();
require_once 'class/group.php';
require_once 'class/event.php';
require_once 'class/chat.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['idgrup'])) 
{
    $group_id = (int)$_POST['idgrup'];
}
elseif (isset($_GET['idgrup'])) 
{
    $group_id = (int)$_GET['idgrup'];
}

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

$membersMahasiswa = $group->getGroupMembersMahasiswa($group_id);
$membersDosen = $group->getGroupMembersDosen($group_id);

$event = new event();
$group_events = $event->getEventsGroup($group_id);

$chat = new chat();
$group_threads = $chat->getThreadGroup($group_id);

$result_mahasiswa = null;
$result_dosen = null;

$conn = new mysqli("localhost", "root", "", "fullstack");

// Ambil semua mahasiswa
$stmt = $conn->prepare("
    SELECT m.nrp, m.nama, a.username
    FROM mahasiswa m
    JOIN akun a ON a.nrp_mahasiswa = m.nrp
    LEFT JOIN member_grup mg 
        ON mg.username = a.username 
        AND mg.idgrup = ?
    WHERE mg.username IS NULL
    AND a.username != ?
");
$stmt->bind_param("is", $group_id, $_SESSION['user']['username']);
$stmt->execute();
$all_mahasiswa = $stmt->get_result();


// Ambil semua dosen
$stmt2 = $conn->prepare("
    SELECT d.npk, d.nama, a.username
    FROM dosen d
    JOIN akun a ON a.npk_dosen = d.npk
    LEFT JOIN member_grup mg 
        ON mg.username = a.username 
        AND mg.idgrup = ?
    WHERE mg.username IS NULL
    AND a.username != ?
");
$stmt2->bind_param("is", $group_id, $_SESSION['user']['username']);
$stmt2->execute();
$all_dosen = $stmt2->get_result();

$conn->close();


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
    <div class = 'center'>
        <form action="dosen_home.php" method="post">
            <button class="button" type="submit">Kembali ke Home</button>
        </form>
    </div>
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
            <tr>
                <td><p>Hapus Group</p></td>
                <?php echo "<td><p>
                    <form action ='dosen_delete_group.php' method='post'>
                        <input type='hidden' name='idgrup' value='{$group_id}'>
                        <button class='button' name='btnHapus' value='hapus' type='submit'>Hapus Group</button>
                    </form>
                    </p></td>;"?>
            </tr>
            <tr>
    <td><p>Edit Group</p></td>
    <td>
        <form action="dosen_edit_group.php" method="post">

            <input type="hidden" name="idgrup" value="<?php echo $group_id; ?>">
            <input type="hidden" name="nama" value="<?php echo $group_detail['nama']; ?>">
            <input type="hidden" name="deskripsi" value="<?php echo $group_detail['deskripsi']; ?>">
            <input type="hidden" name="jenis" value="<?php echo $group_detail['jenis']; ?>">

            <button class="button" type="submit">Edit Group</button>
        </form>
    </td>
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
                <th colspan = '2'>Aksi</th>
            </tr>

            <?php foreach ($group_events as $events) { ?>
                <tr>
                    <td><?php echo $events['judul']; ?></td>
                    <td><?php echo $events['tanggal']; ?></td>
                    <td><?php echo $events['keterangan']; ?></td>
                    <td><?php echo $events['jenis']; ?></td>
                    <td>
                        <?php
                            if (!empty($events['poster_extension'])) {
                                $filename = $events['idevent'] . "." . $events['poster_extension'];
                                if (file_exists("image_events/" . $filename)) 
                                {
                                    echo '<img src="image_events/' . $filename . '" width="200">';
                                } 
                                else 
                                {
                                    echo "No photo";
                                }
                            } else {
                                echo "No photo";
                            }
                        ?>
                    </td>
                    <td>
                        <form method="post" action="dosen_delete_event.php" style="margin:0;">
                            <input type="hidden" name="idgrup" value="<?php echo $events['idgrup']; ?>">
                            <input type="hidden" name="idevent" value="<?php echo $events['idevent']; ?>">
                            <input type = "hidden" name = "poster_extension" value = "<?php echo $events['poster_extension'];?>">
                            <button class="button" name="btnHapus" value="hapus" type="submit">Hapus</button>
                        </form>
                    </td>
                    <td>
                        <form method="post" action="dosen_edit_event.php" style="margin:0;">
                            <input type="hidden" name="idgrup" value="<?php echo $events['idgrup']; ?>">
                            <input type="hidden" name="idevent" value="<?php echo $events['idevent']; ?>">
                            <input type="hidden" name="judul" value="<?php echo htmlspecialchars($events['judul']); ?>">
                            <input type="hidden" name="tanggal" value="<?php echo $events['tanggal']; ?>">
                            <input type="hidden" name="jenis" value="<?php echo $events['jenis']; ?>">
                            <input type="hidden" name="keterangan" value="<?php echo htmlspecialchars($events['keterangan']); ?>">
                            <input type="hidden" name="poster_extension" value="<?php echo $events['poster_extension']; ?>">
                            <button class="button" type="submit">Edit</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <br>
        <form action = "dosen_insert_event.php" method = 'post' >
            <input type="hidden" name="idgrup" value="<?php echo $group_id; ?>">
            <button class = 'button' type="submit">Tambah Event</button>
        </form>
    </div>

    <div class="daftarMember">
        <h3>Daftar Member Mahasiswa</h3>
        <table>
            <tr>
                <th>Username</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>

            <?php foreach ($membersMahasiswa as $member) { ?>
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
        <?php   
            if ($result_mahasiswa !== null) {
                $hasil = $result_mahasiswa;
            } else 
            {
                $hasil = $all_mahasiswa;
            }

            echo "<h4>Daftar Mahasiswa</h4>";
            echo "<table>";
            echo "<tr>";
            echo "<th>NRP</th>";
            echo "<th>Nama</th>";
            echo "<th>Aksi</th>";
            echo "</tr>";

            if ($hasil->num_rows > 0) {
                while ($mahasiswa = $hasil->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $mahasiswa['nrp'] . "</td>";
                    echo "<td>" . $mahasiswa['nama'] . "</td>";
            ?>
                <form method="post" action="dosen_insert_member_proses.php">
                    <input type="hidden" name="id" value="<?php echo $group_id; ?>">
                    <input type="hidden" name="username" value="<?php echo $mahasiswa['username']; ?>">
                    <td><button class="button" name="btnTambah" value="tambah" type="submit">Tambah</button></td>
                </form>
            <?php
                    echo "</tr>";
                }
            } 
            else 
            {
                echo "<tr><td colspan='3'>Tidak ada data</td></tr>";
            }
            echo "</table>";
            ?>
    </div>
    
    <div class="daftarMember">
        <h3>Daftar Member Dosen</h3>
        <table>
            <tr>
                <th>Username</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>

            <?php foreach ($membersDosen as $member) { ?>
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
        <?php   
            if ($result_dosen !== null) {
                $hasil = $result_dosen;
            } else 
            {
                $hasil = $all_dosen;
            }

            echo "<h4>Daftar Dosen</h4>";
            echo "<table>";
            echo "<tr>";
            echo "<th>NRP</th>";
            echo "<th>Nama</th>";
            echo "<th>Aksi</th>";
            echo "</tr>";

            if ($hasil->num_rows > 0) {
                while ($dosen = $hasil->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $dosen['npk'] . "</td>";
                    echo "<td>" . $dosen['nama'] . "</td>";
            ?>
                <form method="post" action="dosen_insert_member_proses.php">
                    <input type="hidden" name="id" value="<?php echo $group_id; ?>">
                    <input type="hidden" name="username" value="<?php echo $dosen['username']; ?>">
                    <td><button class="button" name="btnTambah" value="tambah" type="submit">Tambah</button></td>
                </form>
            <?php
                    echo "</tr>";
                }
            } 
            else 
            {
                echo "<tr><td colspan='3'>Tidak ada data</td></tr>";
            }
            echo "</table>";
            ?>
    </div>

</body>
</html>
