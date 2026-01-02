<?php
$mysqli = new mysqli("localhost", "root", "", "fullstack");
// Cek koneksi
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}
session_start();
if (!isset($_SESSION['user'])) 
    {
        header("Location: ../login.php");
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
                <form action="admin_dosen.php" method="post">
                    <button class="kembaliForm" type="submit">Kembali ke Home</button>
                </form>
            </div>
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
            <?php
            ?>
            <input type="hidden" name="npk_lama" value="<?php echo $row['npk']; ?>">
            <input type="hidden" name = "username_lama" value = "<?php echo $row['username'];?>">
            <input type = "hidden" name = "ext_lama" value = "<?php echo $row['foto_extension']; ?>">
        </form>
        </div>
    </body>
</html>