<?php
$mysqli = new mysqli("localhost", "root", "", "fullstack");
$id = $_GET['nrp'];

// dapatkan mahasiswa yang akan diedit
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
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1">
    <title>Edit Data Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: white;
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
        label {
            font-weight: bold;
        }
        input[type="text"], input[type="number"], 
        input[type="date"], select, input[type="file"] {
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
        .foto-lama {
            margin: 10px 0;
            text-align: center;
        }
        .foto-lama img {
            max-width: 150px;
            border: 1px solid #aaa;
            padding: 5px;
            background: white;
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

    <h2>Edit Data Mahasiswa</h2>
    <p id="pembukaanteks">Perbarui data mahasiswa berikut</p>

    <form method="post" action="admin_edit_proses_mahasiswa.php" enctype="multipart/form-data">
        <p><label>Username:</label><br>
        <input type="text" name="username" value="<?php echo $row['username']; ?>"></p>

        <p><label>NRP:</label><br>
        <input type="text" name="nrp" value="<?php echo $row['nrp']; ?>"></p>

        <p><label>Nama:</label><br>
        <input type="text" name="nama" value="<?php echo $row['nama']; ?>"></p>

        <p><label>Gender:</label><br>
        <select name="gender">
            <option value="Pria" <?php if($row['gender']=="Pria") echo "selected"; ?>>Pria</option>
            <option value="Wanita" <?php if($row['gender']=="Wanita") echo "selected"; ?>>Wanita</option>
        </select></p>

        <p><label>Tanggal Lahir:</label><br>
        <input type="date" name="tanggal_lahir" value="<?php echo $row['tanggal_lahir']; ?>"></p>

        <p><label>Angkatan:</label><br>
        <input type="number" name="angkatan" value="<?php echo $row['angkatan']; ?>"></p>

        <p><label>Foto Mahasiswa (opsional):</label><br>
        <input type="file" name="foto" accept="image/jpg,image/png"></p>

        <?php if (!empty($row['foto_extention'])): ?>
        <div class="foto-lama">
            <p>Foto Lama:</p>
            <img src="image_mahasiswa/<?php echo $row['nrp'].".".$row['foto_extention']; ?>" alt="Foto Mahasiswa">
        </div>
        <?php endif; ?>

        <p style="text-align:center;">
            <button name="btnEdit" value="Edit" type="submit">Simpan</button>
        </p>

        <!-- hidden input -->
        <input type="hidden" name="nrp_lama" value="<?php echo $row['nrp']; ?>">
        <input type="hidden" name="username_lama" value="<?php echo $row['username']; ?>">
        <input type="hidden" name="ext_lama" value="<?php echo $row['foto_extention']; ?>">
    </form>

    <div class="menu-links">
        <a href="admin_mahasiswa.php">Kembali</a>
        <a href="admin_home.php">Home</a>
    </div>

</body>
</html>
