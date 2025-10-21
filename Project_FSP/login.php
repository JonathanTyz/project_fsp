<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
            width: 100px;
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
    <div class = "isiInput">
    <h2><b>Login</b></h2>
    <h4><b>Masukkan Username dan password anda! </b></h4>
        <form method="POST" action="login_proses.php" enctype="multipart/form-data">
            <label>Username: </label><br>
            <input type = "text" name="txtUsername" required><br>
            <label>Password: </label><br>
            <input type = "password" name="txtPassword" required><br><br>
            <button type="submit" value="simpan" name = "btnSubmit" >Login</button>
        </form>
    </div>
</body>
</html>