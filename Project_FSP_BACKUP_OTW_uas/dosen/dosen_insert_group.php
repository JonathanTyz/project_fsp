<?php
// koneksikan ke dababase
$mysqli = new mysqli("localhost", "root", "", "fullstack");
session_start();
if (!isset($_SESSION['user'])) 
    {
        header("Location: ../login.php");
        exit();
    }

if ($mysqli->connect_error) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}
?>
<html>
    <head> <?php //Insert data dosen ?>
        <title>Insert Data Dosen</title>
        <meta charset="UTF-8">
        <meta name = "viewport" content = "width=device-width, initial-scale=1">
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <style> 
        h2{
            text-align: center;
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
            font-weight: bold;
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
        .button {
                padding: 10px 18px;
                background-color: #2c3e50;
                border: none;
                color: white;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
    <div class = 'center'>
    <form action="dosen_kelola_event.php" method="post">
        <button class="button" type="submit">Kembali ke Daftar Event</button>
    </form>
        <div class = 'isiInput'>
        <h2><b>Buat Group</b></h2>
        <p id = 'pembukaanteks'>Masukkan data untuk pembuatan grup </p>
        <form method="post" action="dosen_insert_group_proses.php" enctype="multipart/form-data">
            <p><label>Nama grup:</label><br><input type = "text" name = "name" required></p>
            <p><Label>Deskripsi grup:</Label><br> <input type = "text" name = "deskripsi"></p>
            <p>
                <select name="jenis" required>
                    <option value="">Pilih jenis grup:</option>
                    <option value="Privat">Privat</option>
                    <option value="Publik">Publik</option>
                </select>
            </p>
            <p><button name="btnSimpan" value="simpan" type="submit">Simpan</button></p>
        </form>
        <script>
        </script>
        </div>