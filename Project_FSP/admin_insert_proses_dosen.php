<?php
$mysqli = new mysqli("localhost", "root", "", "fullstack");

$npk = $_POST['npk'];
$nama = $_POST['nama'];
$ext = strtolower(pathinfo($_FILES['foto']['name'][0], PATHINFO_EXTENSION));


// atribut tabel akun: username, password, nrp_mahasiswa (jadikan kosong), npk_dosen, is_admin (jadikan 0)
//username harus dicek agar tidak fk duplicate constriant

$username = $_POST['username'];
$password = $_POST['password'];
$is_admin = 0;
$nrp_mahasiswa = NULL;
$npk_dosen = $npk;

if ($stmt = $mysqli->prepare("SELECT username FROM akun WHERE username = ?")) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 0) { //ga ada duplikat username 

        //cek apakah ada duplikat npk 
        if ($stmt = $mysqli->prepare("SELECT npk FROM dosen WHERE npk = ?")) {
            $stmt->bind_param("s", $npk);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->close(); 
                $mysqli->close();
                echo "NPK sudah ada!";
                echo "<br><a href='admin_insert_dosen.php'>Insert Ulang</a>";
                exit();
            }
            else
            {
                //insertkan data ke tabel dosen
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO dosen (npk, nama, foto_extension) VALUES (?, ?, ?)";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("sss", $npk, $nama, $ext);
                $stmt->execute();

                $sql2 = "INSERT INTO akun (username, password, nrp_mahasiswa, npk_dosen, isadmin) VALUES (?, ?, ?, ?, ?)";
                $stmt = $mysqli->prepare($sql2);
                $stmt->bind_param("ssssi", $username, $hashed_password, $nrp_mahasiswa, $npk_dosen, $is_admin);
                $stmt->execute();

                $jumlah_yang_dieksekusi = $stmt->affected_rows; 
                $stmt->close(); 
                $mysqli->close();
                if (!empty($_FILES['foto']['name'][0])) 
                {
                    move_uploaded_file($_FILES['foto']['tmp_name'][0], "image_dosen/" .$npk.".".$ext);
                }
                header("Location: admin_dosen.php");
                exit();     
            }
        }
    }
    else{ /// ada duplikat
        $stmt->close(); 
        $mysqli->close();
        echo "Username sudah ada!";
        echo "<br><a href='admin_insert_dosen.php'>Insert Ulang</a>";
        exit();
    }
}
?>