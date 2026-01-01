<?php
    require_once 'parent.php';
    class users extends classParent
    {
        public function __construct(){
            parent::__construct();
        }
    
        public function doLogin($username, $pwd)
        {
            $sql = "SELECT * FROM akun WHERE username = ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($row = $res->fetch_assoc()) 
            {
                if (password_verify($pwd, $row['password']))
                return $row;
                else
                {
                    return false;
                }
            } 
            else
            {
                return false;
            }
        }
        public function changePassword($username, $oldPassword, $newPassword)
    {
        $sql = "SELECT * FROM akun WHERE username = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($user = $res->fetch_assoc()) {
            if (!password_verify($oldPassword, $user['password'])) {
                return false; 
            }
            $hashedpassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql = "UPDATE akun SET password = ? WHERE username = ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("ss", $hashedpassword, $username);
            $stmt->execute();
            return true; 
        }
        return false; 
    }
    }
?>