<?php //buat ini sebagai UI untuk admin memilih ke admin_dosen.php atau admin_mahasiswa.php
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Halaman Admin</title>
    </head>
    <style>
        body{
            font-family: 'Times New Roman', Times, serif;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .isi{
            background-color: white;
            padding: 30px 40px;
            text-align: center;
            width: 400px;
            border: 10px solid #333;
        }
        button{
            width: 200px;
            background-color: #ffffffff;
            color: white;
            padding: 10px;
            margin: 10px;
            font-weight: bold;
        }
    </style>
    <body>
        <div class = 'isi'>
            <h2><b>Welcome Admin</b></h2>
            <p>Silakan pilih halaman yang ingin Anda lihat:</p>
            Kelola Data Dosen: <br><button><a href="admin_dosen.php">Lihat Dosen</a></button><br>
            Kelola Data Mahasiswa: <br><button><a href="admin_mahasiswa.php">Lihat Mahasiswa</a></button>
        </div>
    </body>