<?php
$mysqli = new mysqli("localhost", "root", "", "fullstack");
$id = $_GET['npk'];

// dapatkan dosen yang akan diedit
$sql = "SELECT d.npk, d.nama, d.foto_extension, a.username, a.password 
        FROM dosen d 
        LEFT JOIN akun a ON d.npk = a.npk_dosen 
        WHERE d.npk = ?";
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Data Dosen</title>
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
        input[type="text"], input[type="password"], 
        input[type="file"] {
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
    </style>
</head>
<body>

    <h2>Edit Data Dosen</h2>
    <p id="pembukaanteks">Perbarui data dosen berikut</p>

    <form method="post" action="admin_edit_proses_dosen.php" enctype="multipart/form-data">
        <p><label>Dosen yang diedit:</label> <b><?php echo $row['nama']; ?></b></p>

        <p><label>Username:</label><br>
        <input type="text" name="username" value="<?php echo $row['username']; ?>"></p>

        <p><label>NPK:</label><br>
        <input type="text" name="npk" value="<?php echo $row['npk']; ?>"></p>

        <p><label>Nama:</label><br>
        <input type="text" name="nama" value="<?php echo $row['nama']; ?>"></p>

        <p><label>Foto Dosen (opsional):</label><br>
        <input type="file" name="foto" accept="image/jpg, image/png"></p>

        <?php if (!empty($row['foto_extension'])): ?>
        <div class="foto-lama">
            <p>Foto Lama:</p>
            <img src="uploads/dosen/<?php echo $row['npk'] . '.' . $row['foto_extension']; ?>" alt="Foto Dosen">
        </div>
        <?php endif; ?>

        <p style="text-align:center;">
            <button name="btnEdit" value="Edit" type="submit">Simpan</button>
        </p>

        <!-- hidden input untuk data lama -->
        <input type="hidden" name="npk_lama" value="<?php echo $row['npk']; ?>">
        <input type="hidden" name="username_lama" value="<?php echo $row['username']; ?>">
        <input type="hidden" name="ext_lama" value="<?php echo $row['foto_extension']; ?>">
    </form>

    <div class="menu-links">
        <a href="admin_dosen.php">Kembali</a>
        <a href="admin_home.php">Home</a>
    </div>

</body>
</html>
