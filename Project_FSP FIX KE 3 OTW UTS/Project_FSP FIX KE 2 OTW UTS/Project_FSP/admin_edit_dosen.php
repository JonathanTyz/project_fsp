<?php
$mysqli = new mysqli("localhost", "root", "", "fullstack");

// Cek koneksi
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

if (!isset($_GET['npk'])) {
    echo "<p>NPK tidak ditemukan di URL.</p>";
    echo "<p style='text-align:center;'><a href='admin_dosen.php'>Kembali</a></p>";
    exit;
}

$id = $_GET['npk'];

// Ambil data dosen berdasarkan NPK
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

if (!$row) {
    echo "<p>Data dosen dengan NPK <b>$id</b> tidak ditemukan.</p>";
    echo "<p style='text-align:center;'><a href='admin_dosen.php'>Kembali</a></p>";
    exit;
}
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
        input[type="text"], input[type="password"], input[type="file"] {
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
        <p><label>Dosen yang diedit:</label> <b><?php echo ($row['nama']); ?></b></p>

        <p><label>Username:</label><br>
        <input type="text" name="username" value="<?php echo ($row['username']); ?>"></p>

        <p><label>NPK:</label><br>
        <input type="text" name="npk" value="<?php echo ($row['npk']); ?>"></p>

        <p><label>Nama:</label><br>
        <input type="text" name="nama" value="<?php echo ($row['nama']); ?>"></p>

        <p><label>Foto Dosen (opsional):</label><br>
        <input type="file" name="foto" accept="image/jpg,image/png"></p>

        <div class="foto-lama">
            <p>Foto Lama:</p>
            <?php 
            $fotoPath = "uploads/dosen/" . $row['npk'] . "." . $row['foto_extension'];
            if (!empty($row['foto_extension']) && file_exists($fotoPath)) {
                echo "<img src='$fotoPath' alt='Foto Dosen'>";
            } else {
                echo "<img src='uploads/dosen/default.jpg' alt='Foto Default'>";
            }
            ?>
        </div>

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
