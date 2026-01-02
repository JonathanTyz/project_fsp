<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
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

        @media (max-width: 550px) {
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
    <form action="dosen_kelola_event.php" method="post">
        <input type = "hidden" name = "idgrup" value = "<?php echo $idgrup; ?>">
        <button class="button" type="submit">Kembali ke Daftar Event</button>
    </form>
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
                <option value="Publik">Publik</option>
                <option value="Privat">Privat</option>
            </select></p>

            <p><label>Poster Event:</label><br>
            <input type="file" name="poster" accept="image/jpeg,image/png"></p>
            <p><button name="btnSimpan" value="simpan" type="submit">Simpan</button></p>
        </form>
    </div>
</body>
</html>
