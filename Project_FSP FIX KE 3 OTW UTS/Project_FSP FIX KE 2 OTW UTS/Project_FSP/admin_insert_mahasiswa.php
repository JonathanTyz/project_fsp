<?php
// koneksi ke database
$mysqli = new mysqli("localhost", "root", "", "fullstack");
if ($mysqli->connect_error) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insert Data Mahasiswa</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style> 
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        h2 {
            margin-bottom: 10px;
            color: black;
        }
        #pembukaanteks {
            font-size: 20px;
            margin-bottom: 20px;
            color: #333;
        }
        form {
            width: 400px;
            margin: 0 auto;
            text-align: left;
            border: 1px solid #ccc;
            padding: 20px;
            background: #f9f9f9;
        }
        form p {
            margin: 10px 0;
        }
        input[type="text"], input[type="password"], 
        input[type="number"], input[type="date"], 
        select, input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
        }
        button {
            background: blue;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
        }
        .menu-links {
            margin-top: 20px;
            text-align: center;
        }
        .menu-links a {
            display: inline-block;
            margin: 0 10px;
            padding: 8px 12px;
            background: blue;
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <h2>Insert Data Mahasiswa</h2>
    <p id="pembukaanteks">Masukkan data mahasiswa</p>

    <form method="post" action="admin_insert_proses_mahasiswa.php" enctype="multipart/form-data">
        <p><label>Username:</label><br>
        <input type="text" name="username" required></p>

        <p><label>Password:</label><br>
        <input type="password" name="password" required></p>

        <p><label>NRP:</label><br>
        <input type="text" name="nrp" required></p>

        <p><label>Nama:</label><br>
        <input type="text" name="nama" required></p>

        <p><label>Gender:</label><br>
        <select name="gender" required>
            <option value="Pria">Pria</option>
            <option value="Wanita">Wanita</option>
        </select></p>

        <p><label>Tanggal Lahir:</label><br>
        <input type="date" name="tanggal_lahir" required></p>

        <p><label>Angkatan:</label><br>
        <input type="number" name="angkatan" required></p>

        <p><label>Foto Mahasiswa:</label><br>
        <input type="file" name="foto[]" accept="image/jpg, image/png" required></p>

        <p style="text-align:center;">
            <button name="btnSimpan" value="simpan" type="submit">Simpan</button>
        </p>
    </form>

    <div class="menu-links">
        <a href="admin_mahasiswa.php">Kembali</a>
        <a href="admin_home.php">Home</a>
    </div>

</body>
</html>
