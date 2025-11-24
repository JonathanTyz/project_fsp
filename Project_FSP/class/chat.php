<?php
require_once 'parent.php';

class Chat extends classParent {

    public function __construct() {
        parent::__construct();
    }

    /* =======================
         GET CHAT BY THREAD
    ========================== */
    public function getChatThread($idthread)
    {
        $sql = "SELECT * FROM chat 
                WHERE idthread = ?
                ORDER BY tanggal_pembuatan ASC";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $idthread);
        $stmt->execute();
        return $stmt->get_result();
    }

    /* =======================
          INSERT CHAT MESSAGE
    ========================== */
    public function insertChat($idthread, $username, $isi)
    {
        $sql = "INSERT INTO chat (idthread, username_pembuat, isi, tanggal_pembuatan)
                VALUES (?, ?, ?, NOW())";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("iss", $idthread, $username, $isi);

        return $stmt->execute();
    }

    /* =======================
          CREATE THREAD
    ========================== */
    public function insertThread($idgrup, $username)
    {
        $sql = "INSERT INTO thread (username_pembuat, idgrup, tanggal_pembuatan, status)
                VALUES (?, ?, NOW(), 'active')";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("si", $username, $idgrup);

        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    public function getThreadGroup($idgrup)
    {
        $sql = "SELECT * FROM thread
                WHERE idgrup = ?
                ORDER BY tanggal_pembuatan DESC";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $idgrup);
        $stmt->execute();
        return $stmt->get_result();
    }
}
