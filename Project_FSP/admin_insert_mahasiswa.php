    <?php
    // koneksikan ke dababase
    $mysqli = new mysqli("localhost", "root", "", "fullstack");
    session_start();
    if (!isset($_SESSION['user'])) 
        {
            header("Location: login.php");
            exit();
        }
    if ($mysqli->connect_error) {
        die("Failed to connect to MySQL: " . $mysqli->connect_error);
    }
    ?>
    <html>
        <head> <?php //Insert data mahasiswa ?>
            <title>Insert Data Mahasiswa</title>
            <meta charset="UTF-8">
            <meta name = "viewport" content = "width=device-width, initial-scale=1">
            <title>Insert Mahasiswa</title>
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
            <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <body>
            <div class = 'isiInput'>
            <h2><b>Insert Data Mahasiswa</b></h2>
            <p id = 'pembukaanteks'>Masukkan data Mahasiswa </p>
            <form method="post" action="admin_insert_proses_mahasiswa.php" enctype="multipart/form-data">
                <p><label>Username:</label> <br> <input type = "text" name = "username"></p>
                <p><Label>Password:</Label><br> <input type = "password" name = "password"></p>
                <p><label>NRP: </label> <br> <input type = "text" name = "nrp"></p>
                <p><label>Nama: </label> <br><input type = "text" name = "nama"></p>
                <p><label>Gender: </label> 
                <select name="gender">
                    <option value="Pria">Pria</option>
                    <option value="Wanita">Wanita</option>
                </select></p>
                <p><label>Tanggal Lahir:</label> <input type = "date" name = "tanggal_lahir"></p>
                <p><label>Angkatan:</label> <br> <input type = "number" name = "angkatan"></p>

                <p>Foto Mahasiswa:</p>
                <p><label>Pilih Foto</label> 
                <div id = 'fotomahasiswa'>
                    <input type = "file" name = "foto[]" accept = "image/jpeg, image/png">
                </div>
                <p><button name="btnSimpan" value="simpan" type="submit">Simpan</button></p>
            </form>
            </div>
        </body>
        </head>