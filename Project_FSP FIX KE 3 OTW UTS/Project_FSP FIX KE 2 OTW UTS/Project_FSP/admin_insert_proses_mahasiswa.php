<?php
$mysqli = new mysqli("localhost", "root", "", "fullstack");

$username = $_POST['username'];
$password = $_POST['password'];
$nrp = $_POST['nrp'];
$nama = $_POST['nama'];
$gender = $_POST['gender'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$angkatan = $_POST['angkatan'];
$ext = strtolower(pathinfo($_FILES['foto']['name'][0], PATHINFO_EXTENSION));
$is_admin = 0;
$nrp_mahasiswa = $nrp;
$npk_dosen = NULL;

//ambil id terbaru
$last_id = $mysqli->insert_id;

//simpan ke folder 
if (!empty($_FILES['foto']['name'][0])) {
    move_uploaded_file($_FILES['foto']['tmp_name'][0], "image_mahasiswa/" .$nrp.".".$ext);
}


// atribut tabel akun: username, password, nrp_mahasiswa , npk_dosen (jadikan kosong), is_admin (jadikan 0)
//username harus dicek agar tidak fk duplicate constraint
$index = $last_id; 

//lakukan pengecekan username karena dia foreign key
if ($stmt = $mysqli->prepare("SELECT username FROM akun WHERE username = ?")) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 0) { //ga ada duplikat username

        //cek lagi apakah duplikat nrp
        if ($stmt = $mysqli->prepare("SELECT nrp FROM mahasiswa WHERE nrp = ?")) {
            $stmt->bind_param("s", $nrp);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->close(); 
                $mysqli->close();
                echo "NRP sudah ada!";
                echo "<br><a href='admin_insert_mahasiswa.php'>Insert Ulang</a>";
                exit();
            }
            else
            {
                $sql = "INSERT INTO mahasiswa (nrp, nama, gender, tanggal_lahir, angkatan, foto_extention) 
                VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("ssssis", $nrp, $nama, $gender, $tanggal_lahir, $angkatan, $ext);
                $stmt->execute();

                $sql2 = "INSERT INTO akun (username, password, nrp_mahasiswa, npk_dosen, isadmin) VALUES (?, ?, ?, ?, ?)";
                $stmt = $mysqli->prepare($sql2);
                $stmt->bind_param("ssssi", $username, $password, $nrp_mahasiswa, $npk_dosen, $is_admin);
                $stmt->execute();

                $jumlah_yang_dieksekusi = $stmt->affected_rows; // untuk melihat jumlah row yang terefek
                $stmt->close(); 
                $mysqli->close();
                header("Location: admin_mahasiswa.php");
                exit();       
            }
        }
    }
    else
    {
        $stmt->close(); 
        $mysqli->close();
        echo "Username sudah ada!";
        echo "<br><a href='admin_insert_mahasiswa.php'>Insert Ulang</a>";
        exit();
    }
}

