<?php
session_start();
unset($_SESSION['user']);
$_SESSION = [];        
session_unset();       
session_destroy();     

header("Location: login.php"); 
exit();
?>
