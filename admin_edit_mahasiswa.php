    <?php
    $mysqli = new mysqli("localhost", "root", "", "fullstack");
    session_start();
    if (!isset($_SESSION['user'])) 
    {
        header("Location: login.php");
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
                    <input type = "file" name = "foto" accept = "image/jpg, image/png">
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