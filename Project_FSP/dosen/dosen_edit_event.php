<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php"); exit();
}

if (!isset($_POST['idevent']) || !isset($_POST['idgrup'])) {
    header("Location: dosen_home.php"); exit();
}

require_once '../class/event.php';
require_once '../class/group.php';

$event = new event();
$idevent = $_POST['idevent'];
$idgrup  = $_POST['idgrup'];
$judul   = $_POST['judul'];
$tanggal = $_POST['tanggal'];
$jenis   = $_POST['jenis'];
$keterangan = $_POST['keterangan'];
$event = new Event();
// Ambil detail event dari database
$detail = $event->getDetailEvent($idevent)->fetch_assoc();
$poster_extension = $detail['poster_extension'];

?>
<!DOCTYPE html>
    <html>
        <head>
            <title>Edit Event</title>
            <style>
                body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f6f8;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            color: #333;
            font-size: 32px;
        }

        #pembukaanteks {
            font-size: 24px;
            text-decoration: underline;
            font-weight: bold;
            font-family: 'Times New Roman', Times, serif;
            color: #333;
            text-align: center;
        }

        .isiInput {
            background-color: lightcyan;
            border: 5px solid #333;
            padding: 25px 20px;
            width: 400px;
            max-width: 90%;
            margin: 20px auto;
            text-align: center;
        }

        label {
            display: block;
            text-align: left;
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"], textarea, select {
            width: 95%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #333;
            font-size: 16px;
        }

        .button, button {
            padding: 12px 20px;
            background-color: #2c3e50;
            border: none;
            color: white;
            font-weight: bold;
            font-size: 16px;
            margin-top: 10px;
        }

        .button-secondary {
            background-color: #6c757d;
        }

        @media (max-width: 500px) {
            h2 {
                font-size: 24px;
            }

            #pembukaanteks {
                font-size: 20px;
            }

            input[type="text"], textarea, select {
                font-size: 14px;
                padding: 6px;
            }

            .button, button {
                font-size: 14px;
                padding: 10px;
            }
        }
            </style>
        </head>
    <body>
        
    <form action="dosen_kelola_group.php" method="post">
        <button class="kembali" type="submit" class="button button-secondary">Kembali ke Daftar Group</button>
    </form>
        <h2 class = 'pembukaanteks'>Edit Event</h2>
        <div class="isiInput">
            <h3>Lakukan Edit Event</h3>
            <form action="dosen_edit_event_proses.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="idevent" value="<?php echo $idevent ?>">
                <input type="hidden" name="idgrup" value="<?php echo $idgrup ?>">

                <label>Judul:</label><br>
                <input type="text" name="judul" value="<?php echo $judul ?>"><br><br>

                <label>Tanggal:</label><br>
                <input type="date" name="tanggal" required value = "<?php echo $tanggal?>"><br>

                <label>Jenis:</label><br>
                
                <select name="jenis">
                    <option value="Privat">Privat</option>
                    <option value="Publik">Publik</option>
                </select><br><br>

                <label>Keterangan:</label><br>
                <textarea name="keterangan"><?php echo $keterangan ?></textarea><br><br>

                <label>Foto:</label><br>
                <input type = "file" name = "foto" accept = "image/jpeg, image/png">
                <br><br>
                <button type="submit" name = 'btnSubmit'>Update</button>

                <input type = "hidden" name = "poster_extension" value = "<?php echo $poster_extension?>">
            </form>
        </div>
    </body>
</html>
