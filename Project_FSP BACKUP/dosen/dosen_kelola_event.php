    <?php
    session_start();
    require_once '../class/group.php';
    require_once '../class/event.php';
    require_once '../class/chat.php';

    if (!isset($_SESSION['user'])) {
        header("Location: ../login.php");
        exit();
    }

    if (isset($_POST['idgrup'])) {
        $group_id = $_POST['idgrup'];
    } 
    elseif (isset($_GET['idgrup'])) {
        $group_id = $_GET['idgrup'];
    } else 
    {
        header(header: "Location: dosen_kelola_group.php");
        exit();
    }

    $group = new group();
    $group_detail = $group->getDetailGroup($group_id);

    if (!$group_detail) {
        header(header: "Location: dosen_kelola_group.php");
        exit();
    }


    $event = new event();
    $group_events = $event->getEventsGroup($group_id);

    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Detail Event Group</title>
        <style>
            body {
                font-family: 'Times New Roman', serif;
                margin: 0;
                background-color: #f4f6f8;
            }

            h2 {
                text-align: center;
                margin-top: 30px;
                font-size: 36px;
                color: #2c3e50;
            }

            h3 {
                color: #2c3e50;
            }

            .center {
                text-align: center;
                margin-top: 15px;
            }

            .button {
                padding: 10px 18px;
                background-color: #2c3e50;
                border: none;
                color: white;
                font-weight: bold;
            }

            .informasiGrup {
                background: white;
                padding: 25px 30px;
                width: 450px;
                margin: 30px auto;
            }

            table {
                width: 90%;
                margin: 20px auto;
                background: white;
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

            .informasiGrup table {
                width: 100%;
                margin: 0;
            }

            .daftarEvent {
                margin: 40px auto;
                width: 95%;
                text-align: center;
            }
            
            .insert-event{
                align-items: center;
                text-align: center;
                margin-bottom: 20px;
                margin-top: 20px;
                padding: 10px 18px;

            }

        </style>

    </head>
    <body>
    <h2>Detail Event</h2>

    <div class="center">
        <form action="dosen_home.php" method="post">
            <button class="button" type="submit">Kembali ke Home</button>
        </form>
        <br>
        <form action="dosen_kelola_group.php" method="post">
            <button class="button" type="submit">Kembali ke Daftar Group</button>
        </form>
    </div>

    <div class="informasiGrup">
        <table>
            <tr>
                <th colspan="2">Informasi Group</th>
            </tr>
            <tr><td>Nama</td><td><?= $group_detail['nama']; ?></td></tr>
            <tr><td>Deskripsi</td><td><?= $group_detail['deskripsi']; ?></td></tr>
            <tr><td>Pembuat</td><td><?= $group_detail['username_pembuat']; ?></td></tr>
            <tr><td>Tanggal Dibentuk</td><td><?= $group_detail['tanggal_pembentukan']; ?></td></tr>
            <tr><td>Jenis</td><td><?= $group_detail['jenis']; ?></td></tr>
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
                    <td><?= $events['judul']; ?></td>
                    <td><?= $events['tanggal']; ?></td>
                    <td><?= $events['keterangan']; ?></td>
                    <td><?= $events['jenis']; ?></td>
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
                            <input type = "hidden" name = "idgrup" value ="<?= $events['idgrup']; ?>">
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                    <td>
                        <form action="dosen_edit_event.php" method="post">
                            <input type="hidden" name="idevent" value="<?= $events['idevent']; ?>">
                            <input type = "hidden" name = "idgrup" value ="<?= $events['idgrup']; ?>">
                            <input type="hidden" name="judul" value="<?= $events['judul']; ?>">
                            <input type="hidden" name="tanggal" value="<?= $events['tanggal']; ?>">
                            <input type="hidden" name="keterangan" value="<?= $events['keterangan']; ?>">
                            <input type="hidden" name="jenis" value="<?= $events['jenis']; ?>">
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
