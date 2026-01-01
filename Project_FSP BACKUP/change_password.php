<?php
session_start();
if (!isset($_SESSION['user'])) 
    {
        header("Location: login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <style>
        body{
            font-family: 'Times New Roman', Times, serif;
            background-color: #f4f4f4;
            align-items: center;
            height: 100vh;
            justify-content: center;
        }
        h2{
            text-align: center;
            margin-top: 30px;
            color: #333;
            font-size: 36px;
        }
        h4{
            margin-top: 10px;
            color: #555;
            font-size: 20px;
        }
        label{
            font-size: 18px;
            color: #333;
            text-align: left;
            margin-top: 15px;
            color: #444;
            font-weight: bold;
        }
        button{
            font-family: 'Times New Roman', Times, serif;
            padding: 12px;
            width: 300px;
            background-color: #e4f1ffff;
            color: #333;
            border-radius: 8px;
            font-size: 24px;
        }
        input{
            width: 300px;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
        }
        .isiInput{
            background-color: white;
            border:10px solid  #333;
            padding: 30px 40px;
            text-align: center;
            width: 350px;
        }
    </style>
</head>
<body>
    <div class="isiInput">
    <h2><b>Change Password</b></h2>
        <form method="POST" action="change_password_proses.php" >
            <p><label>Old Password:</label> <br>
            <input type="password" name="old_password" required></p><br>
            <p><label>Password:</label><br>
            <input type="password" name="password" required></p><br>
            <button type="submit">Change Password</button>
        </form>
    </div>
</body>
</html>