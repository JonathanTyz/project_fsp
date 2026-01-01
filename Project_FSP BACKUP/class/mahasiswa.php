<?php
    require_once 'parent.php';
    class mahasiswa extends classParent {
        // metode untuk mendapatkan semua movie
        public function __construct(){
            parent::__construct();
        }
        public function getMahasiswa($npk, $offset = null, $limit = null){
            if (!is_null($offset)) {
               $sql = "SELECT * FROM MAHASISWA WHERE NRP LIKE ? LIMIT $offset, $limit";
                $stmt = $this->mysqli->prepare($sql);
                $stmt->bind_param('s', $npk);
            }
            else{
                $sql = 'SELECT * FROM MAHASISWA WHERE NRP LIKE ?';
                $stmt = $this->mysqli->prepare($sql);
                $stmt->bind_param('s', $npk);
            }
            $stmt->execute();
            $res = $stmt->get_result();
            return $res;
        }
        public function deleteMahasiswa($nrp)
        {
            // ambil foto
            $sql = "SELECT foto_extention FROM MAHASISWA WHERE NRP = ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("s", $nrp);
            $stmt->execute();
            $res = $stmt->get_result();
            $row = $res->fetch_assoc();
            $stmt->close();

            if ($row) 
            {
                if (!empty($row['foto_extention']))
                {
                    $path = "../image_mahasiswa/" . $nrp . "." . $row['foto_extention'];
                    if (file_exists($path)) {
                        unlink($path);
                }
                }
            }

            // hapus akun dulu
            $sql = "DELETE FROM AKUN WHERE NRP_MAHASISWA = ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("s", $nrp);
            $stmt->execute();
            $stmt->close();

            // hapus mahasiswa
            $sql = "DELETE FROM MAHASISWA WHERE NRP = ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("s", $nrp);
            $stmt->execute();
            $stmt->close();
        }
        public function insertMahasiswa(
        $nrp, $nama, $gender, $tanggal_lahir, $angkatan,
        $username, $password, $foto)
        {
       
            $sql = "SELECT username FROM akun WHERE username = ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->close();
                return "username sudah ada";
            }
            $stmt->close();

            // cek nrp
            $sql = "SELECT nrp FROM mahasiswa WHERE nrp = ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("s", $nrp);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->close();
                return "nrp sudah ada";
            }
            $stmt->close();

            // foto
            $foto_ext = null;
            if (!empty($foto['name'][0])) {
                $foto_ext = strtolower(pathinfo($foto['name'][0], PATHINFO_EXTENSION));
            }

            // insert mahasiswa
            $sql = "INSERT INTO mahasiswa 
                    (nrp, nama, gender, tanggal_lahir, angkatan, foto_extention)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param(
                "ssssis",
                $nrp, $nama, $gender, $tanggal_lahir, $angkatan, $foto_ext
            );
            $stmt->execute();
            $stmt->close();

            // insert akun
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO akun (username, password, nrp_mahasiswa, isadmin)
                    VALUES (?, ?, ?, 0)";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("sss", $username, $hashed, $nrp);
            $stmt->execute();
            $stmt->close();

            // upload foto
            if ($foto_ext) {
                move_uploaded_file(
                    $foto['tmp_name'][0],
                    "../image_mahasiswa/".$nrp.".".$foto_ext
                );
            }

            return "SUCCESS";
        }

        public function updateMahasiswa(
        $nrp,
        $nrp_lama,
        $nama,
        $gender,
        $tanggal_lahir,
        $angkatan,
        $username,
        $username_lama,
        $ext_lama,
        $foto)
        {
            // cek username duplikat
            $sql = "SELECT username FROM akun WHERE username = ? AND username != ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("ss", $username, $username_lama);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->close();
                return "username sudah ada";
            }
            $stmt->close();

            // cek nrp duplikat
            $sql = "SELECT nrp FROM mahasiswa WHERE nrp = ? AND nrp != ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("ss", $nrp, $nrp_lama);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->close();
                return "nrp sudah ada";
            }
            $stmt->close();

            if (!empty($foto['name'])) {
                $ext = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));

                $sql = "UPDATE mahasiswa 
                        SET nrp=?, nama=?, gender=?, tanggal_lahir=?, angkatan=?, foto_extention=?
                        WHERE nrp=?";
                $stmt = $this->mysqli->prepare($sql);
                $stmt->bind_param(
                    "sssssss",
                    $nrp, $nama, $gender, $tanggal_lahir, $angkatan, $ext, $nrp_lama
                );
                $stmt->execute();
                $stmt->close();

                // hapus foto lama
                $foto_lama = "../image_mahasiswa/".$nrp_lama.".".$ext_lama;
                if (file_exists($foto_lama)) {
                    unlink($foto_lama);
                }

                // upload foto baru
                move_uploaded_file(
                    $foto['tmp_name'],
                    "../image_mahasiswa/".$nrp.".".$ext
                );

            }
            //kalau ga ubah foto yaudah samain aja tanpa edit foto extension dan hapus di server
            else {
                $sql = "UPDATE mahasiswa 
                        SET nrp=?, nama=?, gender=?, tanggal_lahir=?, angkatan=?
                        WHERE nrp=?";
                $stmt = $this->mysqli->prepare($sql);
                $stmt->bind_param(
                    "ssssss",
                    $nrp, $nama, $gender, $tanggal_lahir, $angkatan, $nrp_lama
                );
                $stmt->execute();
                $stmt->close();

                // rename foto jika NRP berubah
                if ($nrp != $nrp_lama && !empty($ext_lama)) {
                    $lama = "../image_mahasiswa/".$nrp_lama.".".$ext_lama;
                    $baru = "../image_mahasiswa/".$nrp.".".$ext_lama;
                    if (file_exists($lama)) {
                        rename($lama, $baru);
                    }
                }
            }

            // update akun
            $sql = "UPDATE akun SET username=?, nrp_mahasiswa=? WHERE username=?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("sss", $username, $nrp, $username_lama);
            $stmt->execute();
            $stmt->close();

            return "SUCCESS";
        }

}
?>
