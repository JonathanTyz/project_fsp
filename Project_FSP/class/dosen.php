<?php
    require_once 'parent.php';
    class dosen extends classParent {
        // metode untuk mendapatkan semua movie
        public function __construct(){
            parent::__construct();
        }
        public function getDosen($npk, $offset = null, $limit = null){
            if (!is_null($offset)) {
               $sql = "SELECT * FROM DOSEN WHERE NPK LIKE ? LIMIT $offset, $limit";
                $stmt = $this->mysqli->prepare($sql);
                $stmt->bind_param('s', $npk);
            }
            else{
                $sql = 'SELECT * FROM DOSEN WHERE NPK LIKE ?';
                $stmt = $this->mysqli->prepare($sql);
                $stmt->bind_param('s', $npk);
            }
            $stmt->execute();
            $res = $stmt->get_result();
            return $res;
        }
        public function deleteDosen($npk)
        {
            // ambil foto
            $sql = "SELECT foto_extension FROM DOSEN WHERE NPK = ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("s", $npk);
            $stmt->execute();
            $res = $stmt->get_result();
            $row = $res->fetch_assoc();
            $stmt->close();

            if ($row) 
            {
                if (!empty($row['foto_extension']))
                {
                    $path = "../image_dosen/" . $npk . "." . $row['foto_extension'];
                    if (file_exists($path)) {
                        unlink($path);
                }
                }
            }

            // hapus akun dulu
            $sql = "DELETE FROM AKUN WHERE NPK_DOSEN = ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("s", $npk);
            $stmt->execute();
            $stmt->close();

            // hapus dosen
            $sql = "DELETE FROM DOSEN WHERE NPK = ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("s", $npk);
            $stmt->execute();
            $stmt->close();
        }

        public function insertDosen($npk, $nama, $username, $password, $foto)
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

            $sql = "SELECT npk FROM dosen WHERE npk = ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("s", $npk);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->close();
                return "npk sudah ada";
            }
            $stmt->close();

            $foto_extension = null;

            if (!empty($foto['name'][0])) {
                $foto_extension = strtolower(
                    pathinfo($foto['name'][0], PATHINFO_EXTENSION)
                );
            }

            $sql = "INSERT INTO dosen (npk, nama, foto_extension) VALUES (?, ?, ?)";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("sss", $npk, $nama, $foto_extension);
            $stmt->execute();
            $stmt->close();

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $is_admin = 0;
            $nrp_mahasiswa = NULL;
            $npk_dosen = $npk;

            $sql = "INSERT INTO akun (username, password, nrp_mahasiswa, npk_dosen, isadmin)
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param(
                "ssssi",
                $username,
                $hashed_password,
                $nrp_mahasiswa,
                $npk_dosen,
                $is_admin
            );
            $stmt->execute();
            $stmt->close();


            if (!empty($foto['name'][0])) {
                move_uploaded_file(
                    $foto['tmp_name'][0],
                    "../image_dosen/" . $npk . "." . $foto_extension
                );
            }

            return "SUCCESS";
        }
        public function updateDosen(
        $npk,
        $npk_lama,
        $nama,
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

            // cek npk duplikat
            $sql = "SELECT npk FROM dosen WHERE npk = ? AND npk != ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("ss", $npk, $npk_lama);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->close();
                return "npk sudah ada";
            }
            $stmt->close();

            //kalau ada foto baru
            if (!empty($foto['name'])) {
                $ext = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));

                $sql = "UPDATE dosen 
                        SET npk = ?, nama = ?, foto_extension = ?
                        WHERE npk = ?";
                $stmt = $this->mysqli->prepare($sql);
                $stmt->bind_param("ssss", $npk, $nama, $ext, $npk_lama);
                $stmt->execute();
                $stmt->close();

                // hapus foto lama
                $foto_lama = "../image_dosen/".$npk_lama.".".$ext_lama;
                if (file_exists($foto_lama)) {
                    unlink($foto_lama);
                }

                // upload foto baru
                move_uploaded_file(
                    $foto['tmp_name'],
                    "../image_dosen/".$npk.".".$ext
                );
            }
            //kalau ga update photo
            else {
                $sql = "UPDATE dosen SET npk = ?, nama = ? WHERE npk = ?";
                $stmt = $this->mysqli->prepare($sql);
                $stmt->bind_param("sss", $npk, $nama, $npk_lama);
                $stmt->execute();
                $stmt->close();

                // rename foto jika npk berubah
                if ($npk != $npk_lama && !empty($ext_lama)) {
                    $lama = "../image_dosen/".$npk_lama.".".$ext_lama;
                    $baru = "../image_dosen/".$npk.".".$ext_lama;
                    if (file_exists($lama)) {
                        rename($lama, $baru);
                    }
                }
            }

            // update akun
            $sql = "UPDATE akun SET username = ?, npk_dosen = ? WHERE username = ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("sss", $username, $npk, $username_lama);
            $stmt->execute();
            $stmt->close();

            return "SUCCESS";
        }

    }
?>