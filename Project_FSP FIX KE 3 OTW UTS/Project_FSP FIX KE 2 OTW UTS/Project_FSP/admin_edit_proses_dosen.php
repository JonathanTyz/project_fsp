<?php
$mysqli = new mysqli("localhost", "root", "", "fullstack");
//yang diupdate hanya sesuai yang diisi jadi kalau kosong tidak ke overwrite data lama
// (pakai input hidden lama di form admin_edit_dosen.php)
$username = $_POST['username'];
$username_lama = $_POST['username_lama'];
$npk = $_POST['npk'];
$nama = $_POST['nama'];
$npk_lama = $_POST['npk_lama'];
$ext_lama = $_POST['ext_lama'];

// Update Tabel Dosen dengan foto juga
//cek agar yang diedit username tidak duplikat
$sql = "SELECT * FROM akun WHERE username = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows > 0 && $username_lama != $username) { //jika duplikat (dan juga tidak 
    //sama dengan username lama user yang di edit), berhenti dilakukan agar tidak duplikat dengan user lain 
        echo "Username sudah ada, silakan gunakan username lain.";
        echo "<br><a href='admin_dosen.php'>Kembali ke halaman dosen</a>";
        $stmt->close();
        $mysqli->close();
        exit;
}
else //KALAU TIDAK DUPLIKAT USERNAME

    //cek lagi ada yang duplikat npk?
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
            { //Kalau user ganti foto
                //$ext = extension yang didapatkan dari foto user dari post form form_admin_edit_dosen.php
                //HAPUS FOTO LAMA GANTI DENGAN FOTO BARU
                $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
                // update bareng foto di database 
                $sql = "UPDATE dosen SET npk = ?, nama = ?, foto_extension = ? WHERE npk = ?";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("ssss", $npk, $nama, $ext, $npk_lama);
                $stmt->execute();
                $stmt->close();
                // simpan ke server fotonya di folder image_dosen
                $foto_baru = "image_dosen/" . $npk . "." . $ext;
                $foto_lama = "image_dosen/" . $npk_lama . "." . $ext_lama;
                if (file_exists($foto_lama)) 
                {
                    unlink($foto_lama); //hapus foto lama
                }
                move_uploaded_file($_FILES['foto']['tmp_name'], $foto_baru); //simpan foto baru
            }
        
            else 
            { //kalau user tidak ganti foto ga di update cuma di rename nama foto npk_lama ke npk_baru
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
        //update tabel akun juga kecuali password (diubah user sendiri admin cuma insert password)
        $sql = "UPDATE akun SET username = ?, npk_dosen = ? WHERE npk_dosen = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sss", $username, $npk, $npk_lama);
        $stmt->execute();

        $sql = "UPDATE akun SET username = ? WHERE npk_dosen = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ss", $username, $npk); // pakai npk baru, karena cascade sudah jalan
        $stmt->execute();

        $stmt->close();
        $mysqli->close();
        }
    }
header("Location: admin_dosen.php");