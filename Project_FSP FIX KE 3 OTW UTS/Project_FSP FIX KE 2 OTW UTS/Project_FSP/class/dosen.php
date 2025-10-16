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
       
    }
?>