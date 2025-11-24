<?php
require_once 'parent.php';

class group extends classParent {

    public function __construct() {
        parent::__construct();
    }

    public function getAllGroup($username, $offset = null, $limit = null)
    {
        if ($offset !== null && $limit !== null) {
            $sql = "SELECT * FROM grup 
                    WHERE username_pembuat = ?
                    ORDER BY idgrup DESC
                    LIMIT ?, ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("sii", $username, $offset, $limit);
        } 
        else {
            $sql = "SELECT * FROM grup 
                    WHERE username_pembuat = ?
                    ORDER BY idgrup DESC";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("s", $username);
        }

        $stmt->execute();
        return $stmt->get_result();
    }

    public function getDetailGroup($id)
    {
        $sql = "SELECT * FROM grup WHERE idgrup = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getGroupMembers($idgrup)
    {
        $sql = "SELECT mg.username, m.nama
            FROM member_grup mg
            LEFT JOIN akun a ON mg.username = a.username
            LEFT JOIN mahasiswa m ON a.nrp_mahasiswa = m.nrp
            WHERE mg.idgrup = ?
            ORDER BY m.nama ASC";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $idgrup);
        $stmt->execute();

        return $stmt->get_result(); 
    }

    public function insertGroup($data)
    {
        if (!isset($_SESSION['user'])) {
            return false;
        }

        $username = $_SESSION['user']['username'];

        $nama  = $data['name'];
        $desk  = $data['deskripsi'];
        $jenis = $data['jenis'];
        $kodePendaftaran = strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));

        $sql = "INSERT INTO grup (username_pembuat, nama, deskripsi, tanggal_pembentukan, jenis, kode_pendaftaran)
                VALUES (?, ?, ?, NOW(), ?, ?)";

        $stmt = $this->mysqli->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("sssss", $username, $nama, $desk, $jenis, $kodePendaftaran);

        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }
    public function deleteGroupMembers($group_id, $username)
    {
        $sql = "DELETE FROM member_grup 
                WHERE idgrup = ? AND username = ?";
        $stmt = $this->mysqli->prepare($sql);

        if (!$stmt)
        {
            return false; 
        }

        $stmt->bind_param("is", $group_id, $username);

        if ($stmt->execute()) 
        {
            return true;
        } 
        else 
        {
            return false; 
        }
}
    public function deleteGroup($idgrup)
    {
        $sql = "DELETE FROM member_grup WHERE idgrup = ?";
        $stmt = $this->mysqli->prepare($sql);

        if ($stmt === false) 
        {
            return false; 
        }

        $stmt->bind_param("i", $idgrup);
        if (!$stmt->execute()) 
        {
            return false; 
        }

        $sql = "DELETE FROM grup WHERE idgrup = ?";
        $stmt = $this->mysqli->prepare($sql);

        if (!$stmt) {
            return false; 
        }

        $stmt->bind_param("i", $idgrup);
        if ($stmt->execute()) {
            return $stmt->affected_rows > 0; 
        } else 
        {
            return false;
        }
    }

public function insertMember($idgrup, $username)
{
    $sql = "INSERT INTO member_grup (idgrup, username) VALUES (?, ?)";
    $stmt = $this->mysqli->prepare($sql);

    if ($stmt === false) 
    {
        return false; 
    }

    $stmt->bind_param("is", $idgrup, $username);
    if ($stmt->execute())
    {
        return true; 
    } 
    else 
    {
        return false; 
    }
}
}
