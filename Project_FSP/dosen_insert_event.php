<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$idgrup = $_POST['idgrup'];

?>
<!DOCTYPE html>
<html>
<head>
    <title>Insert Event</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style> 
        h2{
            text-align: center;
            margin-top: 30px;
            color: #333;
            font-size: 36px;
        }
        #pembukaanteks{
            font-size: 26px;
            text-decoration: underline;
            font-family: 'Times New Roman', Times, serif;
            color: #333;
        }
        .isiInput{
            background-color: lightcyan;
            border: 10px solid  #333;
            padding: 30px 40px;
            text-align: center;
            width: 600px;
            margin: 30px auto;
        }
        
    </style>
</head>
<body>
    <div class='isiInput'>
        <h2>Insert Data Event</h2>
        <p id='pembukaanteks'>Masukkan data Event</p>
        <form method="post" action="dosen_insert_event_proses.php" enctype="multipart/form-data">

            <input type="hidden" name="idgrup" value="<?php echo $idgrup; ?>">

            <p><label>Judul Event:</label><br>
            <input type="text" name="judul" required></p>

            <p><label>Tanggal Event:</label><br>
            <input type="date" name="tanggal" required></p>

            <p><label>Keterangan:</label><br>
            <textarea name="keterangan" required></textarea></p>

            <p><label>Jenis Event:</label><br>
            <select name="jenis" required>
                <option value="Publik">Privat</option>
                <option value="Privat">Publik</option>
            </select></p>

            <p><label>Poster Event:</label><br>
            <input type="file" name="poster" accept="image/jpeg,image/png"></p>
            <p><button name="btnSimpan" value="simpan" type="submit">Simpan</button></p>
        </form>
    </div>
</body>
</html>
