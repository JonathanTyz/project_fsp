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
            body{
                font-family: 'Times New Roman', Times, serif;
                margin: 0;
                background-color: #f4f6f8;
            }

            h2{
                text-align: center;
                margin-top: 30px;
                font-size: 36px;
                color: #2c3e50;
            }

            h3{
                color: #2c3e50;
                text-align: center;
                margin-top: 30px;
            }

            .center{
                text-align: center;
                margin-top: 15px;
            }

            .button{
                padding: 10px 18px;
                background-color: #2c3e50;
                border: none;
                color: white;
                font-weight: bold;
                margin: 5px 0;
            }

            .informasiGrup{
                background: white;
                padding: 25px 30px;
                width: 450px;
                margin: 30px auto;
            }

            .informasiGrup table{
                width: 100%;
            }

            .daftarEvent table{
                width: 90%;
                margin: 20px auto;
                background: white;
            }

            th, td{
                border: 1px solid #ccc;
                padding: 10px;
                text-align: center;
            }

            th{
                background-color: #e9ecef;
                font-weight: bold;
            }

            .daftarEvent img{
                max-width: 180px;
                height: auto;
            }

            .insert-event{
                text-align: center;
                margin: 20px 0;
            }

            @media (max-width: 1024px){
                table, thead, tbody, tr, th, td{
                    display: block;
                    width: 95%;
                    margin: 0 auto;
                }

                thead{
                    display: none;
                }

                tr{
                    background: white;
                    border: 2px solid #2c3e50;
                    margin-bottom: 15px;
                    padding: 15px;
                }

                td{
                    text-align: left;
                    border: none;
                    padding: 8px 10px;
                    display: flex;
                    align-items: center;
                    flex-wrap: wrap;
                }

                td::before{
                    content: attr(data-label);
                    font-weight: bold;
                    width: 45%;
                    color: #2c3e50;
                }

                td button, td form{
                    width: 100%;
                    margin-top: 5px;
                }

                .informasiGrup, .daftarEvent table{
                    width: 95%;
                }

                .daftarEvent img{
                    max-width: 120px;
                    margin-top: 5px;
                }
            }

            @media (max-width: 480px){
                h2{ font-size: 24px; }
                h3{ font-size: 20px; }
                td{
                    flex-direction: column;
                    align-items: flex-start;
                }
                td::before{
                    width: 100%;
                    margin-bottom: 4px;
                }
                .button{
                    width: 100%;
                    padding: 8px;
                    font-size: 14px;
                }
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
            <tr><td data-label="Nama:">Nama</td><td><?= $group_detail['nama']; ?></td></tr>
            <tr><td data-label="Deskripsi:">Deskripsi</td><td><?= $group_detail['deskripsi']; ?></td></tr>
            <tr><td data-label="Pembuat:">Pembuat</td><td><?= $group_detail['username_pembuat']; ?></td></tr>
            <tr><td data-label="Tanggal Dibentuk:">Tanggal Dibentuk</td><td><?= $group_detail['tanggal_pembentukan']; ?></td></tr>
            <tr><td data-label="Jenis:">Jenis</td><td><?= $group_detail['jenis']; ?></td></tr>
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
