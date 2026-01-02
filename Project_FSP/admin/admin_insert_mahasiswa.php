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
        <head> <?php //Insert data mahasiswa ?>
            <title>Insert Data Mahasiswa</title>
            <meta charset="UTF-8">
            <meta name = "viewport" content = "width=device-width, initial-scale=1">
            <title>Insert Mahasiswa</title>
            <style> 
            body {
                font-family: 'Times New Roman', serif;
                margin: 0;
                padding: 0;
                background-color: #f4f6f8;
            }

            h2 {
                text-align: center;
                margin-top: 30px;
                color: #333;
                font-size: 36px;
            }

            #pembukaanteks {
                font-size: 22px;
                text-decoration: underline;
                font-weight: bold;
                font-family: 'Times New Roman', Times, serif;
                color: #333;
                text-align: center;
                margin-bottom: 20px;
            }

            .isiInput {
                background: lightcyan;
                border: 3px solid #333;
                padding: 30px 40px;
                width: 400px;
                margin: 30px auto;
            }

            .isiInput p {
                margin-bottom: 15px;
            }

            label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
            }

            button {
                width: 100%;
                padding: 12px 0;
                font-size: 18px;
                font-weight: bold;
                color: white;
                background-color: #3498db;
                border: none;
                margin-top: 10px;
            }

            button:hover {
                background-color: #2980b9;
            }

            .center {
                text-align: center;
                margin-top: 15px;
            }

            .kembaliForm{
                width: 500px;
            }


            @media (max-width: 768px) {
                .isiInput {
                    width: 90%;
                    padding: 20px;
                }

                h2 {
                    font-size: 28px;
                }

                #pembukaanteks {
                    font-size: 20px;
                }

                input, select, button {
                    font-size: 16px;
                }
            }

            @media (max-width: 480px) {
                h2 {
                    font-size: 24px;
                }

                #pembukaanteks {
                    font-size: 18px;
                }

                button {
                    font-size: 16px;
                    padding: 10px 0;
                }
            }
            </style>
            <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <body>
            <div class="center">
                <form action="admin_mahasiswa.php" method="post">
                    <button class="kembaliForm" type="submit">Kembali ke Home</button>
                </form>
            </div>
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