<?php
require_once 'parent.php';

class Chat extends classParent {

    public function __construct() {
        parent::__construct();
    }

    // Tambah chat ke thread
    public function addChat($idthread, $username_pembuat, $isi) {
        // cek status thread
        $thread = $this->mysqli->prepare("SELECT status FROM thread WHERE idthread=?");
        $thread->bind_param("i", $idthread);
        $thread->execute();
        $result = $thread->get_result()->fetch_assoc();
        if ($result['status'] == 'Open') {
            $sql = "INSERT INTO chat (idthread, username_pembuat, isi) VALUES (?, ?, ?)";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("iss", $idthread, $username_pembuat, $isi);
            return $stmt->execute();
        }
        return false; // tidak bisa chat di thread Close
    }

    // Ambil semua chat thread
    public function getChats($idthread) {
        $sql = "SELECT * FROM chat WHERE idthread=? ORDER BY tanggal_pembuatan ASC";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $idthread);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
