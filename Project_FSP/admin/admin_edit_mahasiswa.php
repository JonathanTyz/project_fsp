    <?php
    $mysqli = new mysqli("localhost", "root", "", "fullstack");
    session_start();
    if (!isset($_SESSION['user'])) 
    {
        header("Location: ../login.php");
        exit();
    }

    if (!isset($_GET['nrp'])) 
    {
        echo "<p>NRP tidak ditemukan di URL.</p>";
        echo "<p style='text-align:center;'><a href='admin_mahasiswa.php'>Kembali</a></p>";
        exit;
    }
    

    $id = $_GET['nrp'];
    //dapatkan mahasiswa yang akan diedit
    $sql = "SELECT m.nrp, m.nama, m.gender, m.tanggal_lahir, m.angkatan, m.foto_extention,
                a.username, a.password
            FROM mahasiswa m
            INNER JOIN akun a ON m.nrp = a.nrp_mahasiswa
            WHERE m.nrp = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();

    if (!$row) {
        echo "<p>Data mahasiswa dengan NRP <b>$id</b> tidak ditemukan.</p>";
        echo "<p style='text-align:center;'><a href='admin_mahasiswa.php'>Kembali</a></p>";
        exit;
    }
    ?>

    <html>
        <head>
            <meta charset="UTF-8">
            <meta name = "viewport" content = "width=device-width, initial-scale=1">
            <title>Edit Data Mahasiswa</title>
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
        </head>
        <body>
            <div class="center">
                <form action="admin_mahasiswa.php" method="post">
                    <button class="kembaliForm" type="submit">Kembali ke Home</button>
                </form>
            </div>
            <div class = "isiInput">
            <h2><b>Edit Data Mahasiswa</b></h2>
            <p id = 'pembukaanteks'>Masukkan data mahasiswa </p>
            <form method = "post" action = "admin_edit_proses_mahasiswa.php" enctype="multipart/form-data">
                <p><Label>Username: </Label><br><input type="text" name="username" value="<?php echo $row['username']; ?>"></p>
                <p><label>NRP: </label> <br><input type = "text" name = "nrp" value = "<?php echo $row['nrp']; ?>"></p>
                <p><label>Nama: </label> <br><input type = "text" name = "nama" value = "<?php echo $row['nama']; ?>"></p>
                <p><label>Gender: </label> 
                <select name="gender">
                    <option value="Pria">Pria</option>
                    <option value="Wanita">Wanita</option>
                </select></p>
                <p><label>Tanggal Lahir: </label> <br> <input type = "date" name = "tanggal_lahir"  value = "<?php echo $row['tanggal_lahir']; ?>"></p>
                <p><label>Angkatan: </label> <br> <input type = "number" name = "angkatan" value = "<?php echo $row['angkatan']; ?>"></p>
                <div id = 'fotomahasiswa'>
                    <input type = "file" name = "foto" accept = "image/jpeg, image/png">
                </div>
                <br>
                <button name="btnEdit" value="Edit" type="submit">Simpan</button></p>
                <?php //buat agar ada nrp untuk update where (nrp_lama) serta penyimpanan atribut lama database 
                // apabila user tidak update semua
                // (menghindari kosong ketika diupdate waktu di post)
                ?>
                <input type="hidden" name="nrp_lama" value="<?php echo $row['nrp']; ?>">
                <input type="hidden" name = "username_lama" value = "<?php echo $row['username'];?>">
                <input type = "hidden" name = "ext_lama" value = "<?php echo $row['foto_extention']; ?>">     
            </form>
            </div>
        </body>
    </html>