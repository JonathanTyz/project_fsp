<?php
$mysqli = new mysqli("localhost", "root", "", "fullstack");
// Cek koneksi
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}
session_start();
if (!isset($_SESSION['user'])) 
    {
        header("Location: login.php");
        exit();
    }

if (!isset($_GET['npk'])) {
    echo "<p>NPK tidak ditemukan di URL.</p>";
    echo "<p style='text-align:center;'><a href='admin_dosen.php'>Kembali</a></p>";
    exit;
}
$id = $_GET['npk'];

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

<html>
    <head>
        <meta charset="UTF-8">
        <meta name = "viewport" content = "width=device-width, initial-scale=1">
        <title>Edit Data Dosen</title>
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
        <div class = 'isiInput'>
        <h2><b>Edit Data Dosen</b></h2>
        <p id = 'pembukaanteks'>Masukkan data dosen </p>
        <form method = "post" action = "admin_edit_proses_dosen.php" enctype="multipart/form-data">
            <p><label>Dosen yang diedit: </label><?php echo $row['nama']; ?></p>
            <p><label>Username: </label><br>  <input type="text" name="username" value="<?php echo $row['username']; ?>"></p>
            <p><label>NPK: </label><br><input type = "text" name = "npk" value = "<?php echo $row['npk']; ?>"></p>
            <p><label>Nama: </label><br><input type = "text" name = "nama" value = "<?php echo $row['nama']; ?>"></p>
            <div id = 'fotodosen'>
                <input type = "file" name = "foto" accept = "image/jpeg, image/png">
            </div>
            <br>
            <p><button name="btnEdit" value="Edit" type="submit">Simpan</button></p>
            <?php //buat agar ada npk untuk update where (npk_lama) serta penyimpanan atribut lama database 
            // apabila user tidak update semua
            ?>
            <input type="hidden" name="npk_lama" value="<?php echo $row['npk']; ?>">
            <input type="hidden" name = "username_lama" value = "<?php echo $row['username'];?>">
            <input type = "hidden" name = "ext_lama" value = "<?php echo $row['foto_extension']; ?>">
        </form>
        </div>
    </body>
</html>