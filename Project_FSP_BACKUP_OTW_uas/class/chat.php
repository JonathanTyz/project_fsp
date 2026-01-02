<?php
require_once 'parent.php';

class Chat extends classParent {

    public function __construct() {
        parent::__construct();
    }

    public function addChat($idthread, $username_pembuat, $isi) {
        $thread = $this->mysqli->prepare("SELECT status FROM thread WHERE idthread=?");
        $thread->bind_param("i", $idthread);
        $thread->execute();
        $result = $thread->get_result()->fetch_assoc();
        if ($result['status'] == 'Open') {
            $sql = "INSERT INTO chat (idthread, username_pembuat, isi, tanggal_pembuatan) VALUES (?, ?, ?, now())";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("iss", $idthread, $username_pembuat, $isi );
            return $stmt->execute();
        }
        return false; 
    }

    public function getChats($idthread) {
    $sql = "
        SELECT 
            c.username_pembuat,
            c.isi,
            c.tanggal_pembuatan,
            a.nrp_mahasiswa,
            a.npk_dosen,
            m.nama AS nama_mahasiswa,
            d.nama AS nama_dosen
        FROM chat c
        JOIN akun a ON a.username = c.username_pembuat
        LEFT JOIN mahasiswa m ON a.nrp_mahasiswa = m.nrp
        LEFT JOIN dosen d ON a.npk_dosen = d.npk
        WHERE c.idthread=?
        ORDER BY c.tanggal_pembuatan ASC
    ";
    $stmt = $this->mysqli->prepare($sql);
    $stmt->bind_param("i", $idthread);
    $stmt->execute();
    return $stmt->get_result();
}

}
?>
