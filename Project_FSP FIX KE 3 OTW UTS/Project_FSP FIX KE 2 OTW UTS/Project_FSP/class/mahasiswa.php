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
        
}
?>
