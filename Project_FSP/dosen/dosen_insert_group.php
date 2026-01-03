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
            font-size: 22px;
            text-decoration: underline;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .isiInput {
            background-color: lightcyan;
            border: 5px solid #333;
            padding: 25px 20px;
            width: 600px;
            max-width: 95%;
            margin: 20px auto;
            text-align: center;
        }

        label {
            display: block;
            text-align: left;
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"], input[type="date"], textarea, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #333;
            font-size: 16px;
        }

        textarea {
            min-height: 80px;
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
            margin-bottom: 15px;
        }

        @media (max-width: 650px) {
            h2 {
                font-size: 24px;
            }

            #pembukaanteks {
                font-size: 18px;
            }

            input[type="text"], input[type="date"], textarea, select, button {
                font-size: 14px;
                padding: 8px;
            }

            .isiInput {
                padding: 20px 15px;
            }
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