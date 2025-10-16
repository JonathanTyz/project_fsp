<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body{
            font-family: Arial, sans-serif;
            background-color: white;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        form{
            width: 250px;
        }
        h2{
            text-align: center;
            margin-bottom: 20px;
        }
        label{
            display: block;
            margin-bottom: 5px;
        }
        input{
            width: 100%;
            padding: 8px;   /* padding sederhana */
            margin-bottom: 15px;  /* jarak antar input */
            border: 1px solid #aaa;
        }
        button{
            width: 107%;
            padding: 8px;
            background: blue;
            border: none;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <form method="POST" action="login_proses.php">
        <h2>Login</h2>
        <label>Username</label>
        <input type="text" name="txtUsername" required>
        <label>Password</label>
        <input type="password" name="txtPassword" required>
        <button type="submit" name="btnSubmit">Login</button>
    </form>
</body>
</html>
