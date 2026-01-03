<?php
require_once 'parent.php';

class group extends classParent {

    public function __construct() {
        parent::__construct();
    }

    public function getAllMadeGroup($username, $offset = null, $limit = null)
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

    public function getGroupMembersMahasiswa($idgrup)
    {
        $sql = "SELECT mg.username, m.nama, m.gender, m.nrp, m.angkatan, m.foto_extention, m.nrp
            FROM member_grup mg
            JOIN akun a ON mg.username = a.username
            JOIN mahasiswa m ON a.nrp_mahasiswa = m.nrp
            WHERE mg.idgrup = ?
            ORDER BY m.nama ASC";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $idgrup);
        $stmt->execute();

        return $stmt->get_result(); 
    }


    public function getUsernameById($type, $id)
    {
    if ($type === 'dosen') {
        $sql = "SELECT a.username 
                FROM dosen d 
                JOIN akun a ON a.npk_dosen = d.npk 
                WHERE d.npk = ?";
    } else { // mahasiswa
        $sql = "SELECT a.username 
                FROM mahasiswa m 
                JOIN akun a ON a.nrp_mahasiswa = m.nrp 
                WHERE m.nrp = ?";
    }

    $stmt = $this->mysqli->prepare($sql);
    if (!$stmt) return false;

    $stmt->bind_param("s", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->fetch_assoc()['username'] ?? false;
    }

    public function getGroupMembersDosen($idgrup)
    {
        $sql = "SELECT mg.username, d.nama, d.foto_extension, d.npk
            FROM member_grup mg
            JOIN akun a ON mg.username = a.username
            JOIN dosen d ON a.npk_dosen = d.npk
            WHERE mg.idgrup = ?
            ORDER BY d.nama ASC";

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
        $kodePendaftaran = "";
        //insert tanpa kode
        $sql = "INSERT INTO grup (username_pembuat, nama, deskripsi, tanggal_pembentukan, jenis, kode_pendaftaran)
                VALUES (?, ?, ?, NOW(), ?, ?)";

        $stmt = $this->mysqli->prepare($sql);
        if (!$stmt) 
        {
            return false;
        }

        $stmt->bind_param("sssss", $username, $nama, $desk, $jenis, $kodePendaftaran);


        if ($stmt->execute()) 
        {
            $idgrup = $stmt->insert_id;
            $kodePendaftaran = "grup".$idgrup;
            $sql = "UPDATE grup SET kode_pendaftaran = ? WHERE idgrup = ?";
            $stmtUpdate = $this->mysqli->prepare($sql);
            $stmtUpdate->bind_param("si", $kodePendaftaran, $idgrup);
            $stmtUpdate->execute();
            return $stmt -> insert_id;
        } else {
            return false;
        }
    }

    public function getMahasiswaNotInGroup($idgrup, $username)
    {
        $sql = "
            SELECT m.nrp, m.nama, a.username, m.foto_extention
            FROM mahasiswa m
            JOIN akun a ON a.nrp_mahasiswa = m.nrp
            LEFT JOIN member_grup mg 
                ON mg.username = a.username 
                AND mg.idgrup = ?
            WHERE mg.username IS NULL
            AND a.username != ?
        ";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("is", $idgrup, $username);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function getDosenNotInGroup($idgrup, $username)
    {
        $sql = "
            SELECT d.npk, d.nama, a.username, d.foto_extension
            FROM dosen d
            JOIN akun a ON a.npk_dosen = d.npk
            LEFT JOIN member_grup mg 
                ON mg.username = a.username 
                AND mg.idgrup = ?
            WHERE mg.username IS NULL
            AND a.username != ?
        ";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("is", $idgrup, $username);
        $stmt->execute();

        return $stmt->get_result();
    }



   public function getAllPublicGroups($username, $offset = null, $limit = null)
    {
    if ($offset !== null && $limit !== null) {
        $sql = "SELECT g.*
                FROM grup g
                LEFT JOIN member_grup mg
                    ON g.idgrup = mg.idgrup 
                    AND mg.username = ?
                WHERE g.jenis = 'Publik'
                AND mg.idgrup IS NULL
                AND g.username_pembuat != ?
                ORDER BY g.idgrup DESC
                LIMIT ?, ?";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ssii", $username, $username, $offset, $limit);
    }
    else {
        $sql = "SELECT g.*
                FROM grup g
                LEFT JOIN member_grup mg
                    ON g.idgrup = mg.idgrup 
                    AND mg.username = ?
                WHERE g.jenis = 'Publik'
                AND mg.idgrup IS NULL
                AND g.username_pembuat != ?
                ORDER BY g.idgrup DESC";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ss", $username, $username);
    }

    $stmt->execute();
    return $stmt->get_result();
}


    

    public function deleteGroupMembers($group_id, $username)
    {
        $sql = "DELETE c FROM chat c 
                         JOIN thread t ON c.idthread = t.idthread 
                         WHERE t.idgrup = ? AND t.username_pembuat = ?";
        $stmtChat = $this->mysqli->prepare($sql);
        if ($stmtChat) {
            $stmtChat->bind_param("is", $group_id, $username);
            $stmtChat->execute();
        }

        $sqlThread = "DELETE FROM thread WHERE idgrup = ? AND username_pembuat = ?";
        $stmtThread = $this->mysqli->prepare($sqlThread);
        if ($stmtThread) {
            $stmtThread->bind_param("is", $group_id, $username);
            $stmtThread->execute();
        }

        $sqlMember = "DELETE FROM member_grup 
                    WHERE idgrup = ? AND username = ?";
        $stmtMember = $this->mysqli->prepare($sqlMember);

        if (!$stmtMember) {
            return false; 
        }

        $stmtMember->bind_param("is", $group_id, $username);

        if ($stmtMember->execute()) {
            return true;
        } else {
            return false; 
        }
}

    public function checkOwnGroup($username, $idgrup)
    {
        //if not own group (username_pembuat is different or not found then return true)
        $sql = "SELECT * FROM grup 
                WHERE idgrup = ? AND username_pembuat = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("is", $idgrup, $username);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->num_rows > 0;
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

public function getAllEvents($idgrup)
{
    $sql = "SELECT idevent, poster_extension FROM event WHERE idgrup = ?";
    $stmt = $this->mysqli->prepare($sql);
    if (!$stmt) return false;

    $stmt->bind_param("i", $idgrup);
    $stmt->execute();

    return $stmt->get_result(); 
}

public function countGroupByMember($username)
{
    $sql = "SELECT COUNT(*) AS total
            FROM grup g
            JOIN member_grup mg ON g.idgrup = mg.idgrup
            WHERE mg.username = ?";

    $stmt = $this->mysqli->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $res = $stmt->get_result()->fetch_assoc();
    return (int)$res['total'];
}


public function editGroup($idgrup, $nama, $jenis, $deskripsi)
{
    $sql = "UPDATE grup 
            SET nama = ?, jenis = ?, deskripsi = ?
            WHERE idgrup = ?";
    $stmt = $this->mysqli->prepare($sql);

    if ($stmt === false) 
    {
        return false; 
    }

    $stmt->bind_param("sssi", $nama, $jenis, $deskripsi, $idgrup);
    if ($stmt->execute()) 
    {
        return $stmt->affected_rows > 0; 
    } 
    else 
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
        return $stmt->affected_rows > 0;
    } 
    else 
    {
        return false; 
    }
}

public function getAllGroupByMember($username, $offset = null, $limit = null)
{
    if ($offset !== null && $limit !== null) {
        $sql = "SELECT g.* 
                FROM grup g
                JOIN member_grup mg ON g.idgrup = mg.idgrup
                WHERE mg.username = ?
                ORDER BY g.idgrup DESC
                LIMIT ?, ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("sii", $username, $offset, $limit);
    } 
    else {
        $sql = "SELECT g.* 
                FROM grup g
                JOIN member_grup mg ON g.idgrup = mg.idgrup
                WHERE mg.username = ?
                ORDER BY g.idgrup DESC";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("s", $username);
    }

    $stmt->execute();
    return $stmt->get_result();
}

public function getGroupByKode($kode)
{
    $sql = "SELECT * FROM grup WHERE kode_pendaftaran = ?";
    $stmt = $this->mysqli->prepare($sql);
    $stmt->bind_param("s", $kode);
    $stmt->execute();
    if ($stmt === false) {
        return false;
    }
    else{
        return $stmt->get_result();
    }
}

public function isMember($idgrup, $username)
{
    $sql = "SELECT * FROM member_grup WHERE idgrup = ? AND username = ?";
    $stmt = $this->mysqli->prepare($sql);
    $stmt->bind_param("is", $idgrup, $username);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->num_rows > 0;
}
}