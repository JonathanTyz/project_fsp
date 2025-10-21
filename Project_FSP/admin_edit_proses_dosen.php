<?php
$mysqli = new mysqli("localhost", "root", "", "fullstack");
$username = $_POST['username'];
$username_lama = $_POST['username_lama'];
$npk = $_POST['npk'];
$nama = $_POST['nama'];
$npk_lama = $_POST['npk_lama'];
$ext_lama = $_POST['ext_lama'];


$sql = "SELECT * FROM akun WHERE username = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows > 0 && $username_lama != $username) { 
        echo "Username sudah ada, silakan gunakan username lain.";
        echo "<br><a href='admin_dosen.php'>Kembali ke halaman dosen</a>";
        $stmt->close();
        $mysqli->close();
        exit;
}
else 

    if ($stmt = $mysqli->prepare("SELECT npk FROM dosen WHERE npk = ?")) {
        $stmt->bind_param("s", $npk);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0 && $npk_lama != $npk) {
            $stmt->close(); 
            $mysqli->close();
            echo "NPK sudah ada!";
            echo "<br><a href='admin_edit_dosen.php'>Edit Ulang</a>";
            exit();
        }
        else
        { 
            if (!empty($_FILES['foto']['name'])) 
            { 
                $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
                $sql = "UPDATE dosen SET npk = ?, nama = ?, foto_extension = ? WHERE npk = ?";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("ssss", $npk, $nama, $ext, $npk_lama);
                $stmt->execute();
                $stmt->close();
                $foto_baru = "image_dosen/" . $npk . "." . $ext;
                $foto_lama = "image_dosen/" . $npk_lama . "." . $ext_lama;
                if (file_exists($foto_lama)) 
                {
                    unlink($foto_lama); 
                }
                move_uploaded_file($_FILES['foto']['tmp_name'], $foto_baru); 
            }
        
            else 
            { 
                $sql = "UPDATE dosen SET npk = ?, nama = ? WHERE npk = ?";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("sss", $npk, $nama, $npk_lama);
                $stmt->execute();
                $stmt->close();
                $foto_lama = "image_dosen/" . $npk_lama . "." . $ext_lama;
                $foto_baru = "image_dosen/" . $npk . "." . $ext_lama;
                if (file_exists($foto_lama)) 
                {
                    rename($foto_lama, $foto_baru);
                }
            }

        $sql = "UPDATE akun SET username = ?, npk_dosen = ? WHERE npk_dosen = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sss", $username, $npk, $npk_lama);
        $stmt->execute();

        $sql = "UPDATE akun SET username = ? WHERE npk_dosen = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ss", $username, $npk); 
        $stmt->execute();

        $stmt->close();
        $mysqli->close();
        }
    }
header("Location: admin_dosen.php");