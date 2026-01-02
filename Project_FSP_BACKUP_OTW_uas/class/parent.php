<?php 
// kelas parent
require_once 'data.php';
class classParent {
    protected $mysqli;

    // konstruktor
    public function __construct() {
        $this->mysqli = new mysqli(SERVER, UID, PWD, DB);
    }
    // metode
    function __destruct(){
        $this->mysqli->close();
    }
}
?>