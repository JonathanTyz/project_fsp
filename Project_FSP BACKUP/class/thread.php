<?php
require_once 'parent.php'; // koneksi DB

class Thread extends classParent {

    public function __construct() {
        parent::__construct();
    }

    // =======================
    // Buat thread baru
    // =======================
    public function createThread($idgrup, $username_pembuat, $status) {
        $sql = "INSERT INTO thread 
                (idgrup, username_pembuat, tanggal_pembuatan, status) 
                VALUES (?, ?, NOW(), ?)";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("iss", $idgrup, $username_pembuat, $status);

        if ($stmt->execute()) {
            return $stmt->insert_id;
        }
        return false;
    }

    // =======================
    // Ambil semua thread dalam grup
    // =======================
    public function getThreads($idgrup) {
        $sql = "SELECT * 
                FROM thread 
                WHERE idgrup = ? 
                ORDER BY tanggal_pembuatan DESC";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $idgrup);
        $stmt->execute();
        return $stmt->get_result();
    }

    // =======================
    // Ambil satu thread
    // =======================
    public function getThread($idthread) {
        $sql = "SELECT * 
                FROM thread 
                WHERE idthread = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $idthread);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // =======================
    // Tutup thread (hanya pembuat)
    // =======================
    public function closeThread($idthread, $username_pembuat) {
        $sql = "UPDATE thread 
                SET status = 'Close' 
                WHERE idthread = ? 
                  AND username_pembuat = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("is", $idthread, $username_pembuat);
        return $stmt->execute();
    }

    // =======================
    // Hapus thread (hanya pembuat)
    // =======================
    public function deleteThread($idthread, $username_pembuat) {
        $sql = "DELETE FROM thread 
                WHERE idthread = ? 
                  AND username_pembuat = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("is", $idthread, $username_pembuat);
        return $stmt->execute();
    }

    // =======================
    // Edit status thread (hanya pembuat)
    // =======================
    public function editThread($idthread, $username_pembuat, $new_status) {
        $sql = "UPDATE thread 
                SET status = ? 
                WHERE idthread = ? 
                  AND username_pembuat = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("sis", $new_status, $idthread, $username_pembuat);
        return $stmt->execute();
    }

    // =======================
    // DOSEN: Edit thread (tanpa cek pembuat)
    // =======================
    public function dosenEditThread($idthread, $new_status) {
        $sql = "UPDATE thread SET status=? WHERE idthread=?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("si", $new_status, $idthread);
        return $stmt->execute();
    }

    // =======================
    // DOSEN: Delete thread
    // =======================
    public function dosenDeleteThread($idthread) {
        $sql = "DELETE FROM thread WHERE idthread=?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $idthread);
        return $stmt->execute();
    }

}
?>
