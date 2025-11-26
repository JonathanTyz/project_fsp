<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); exit();
}

if (!isset($_POST['idevent']) || !isset($_POST['idgrup'])) {
    header("Location: dosen_home.php"); exit();
}

$idevent = $_POST['idevent'];
$idgrup  = $_POST['idgrup'];
$judul   = $_POST['judul'];
$tanggal = $_POST['tanggal'];
$jenis   = $_POST['jenis'];
$keterangan = $_POST['keterangan'];
$poster_extension = $_POST['poster_extension'];

?>
<!DOCTYPE html>
    <html>
        <head>
            <title>Edit Event</title>
            <style>
                h2{
                    margin-top: 30px;
                    color: #333;
                    font-size: 36px;
                }
                input{
                    margin: 10px;
                    padding: 5px;
                    width: 300px;
                }
                #pembukaanteks{
                    font-size: 26px;
                    text-decoration: underline;
                    text-decoration: bold;
                    font-family: 'Times New Roman', Times, serif;
                    color: #333;
                }
                .isiInput{
                    background-color: white;
                    border:10px solid  #333;
                    background: lightcyan;
                    padding: 30px 40px;
                    text-align: center;
                    width: 350px;
                }
            </style>
        </head>
    <body>

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
                <button type="submit" name = 'btnSubmit'>Update</button>

                <input type = "hidden" name = "poster_extension" value = "<?php echo $poster_extension?>">
            </form>
        </div>
    </body>
</html>
