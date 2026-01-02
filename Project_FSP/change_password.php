<?php
session_start();
if (!isset($_SESSION['user'])) 
    {
        header("Location: login.php");
        exit();
    }
if ($_SESSION['user']['role'] != 'mahasiswa' && $_SESSION['user']['role'] != 'dosen') 
    {
        header("Location: login.php");
        exit();
    }
else if ($_SESSION['user']['role'] == 'mahasiswa') 
    {
        $home_page = "mahasiswa/mahasiswa_home.php";
    } 
else if ($_SESSION['user']['role'] == 'dosen') 
    {
        $home_page = "dosen/dosen_home.php";
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
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .isiInput{
            background-color: white;
            border: 8px solid #333;
            padding: 30px;
            width: 100%;
            max-width: 420px;
        }

        h2{
            margin: 10px 0;
            color: #333;
            font-size: 34px;
            text-align: center;
        }

        h4{
            margin-top: 5px;
            color: #555;
            font-size: 20px;
            text-align: center;
        }

        label{
            font-size: 18px;
            color: #444;
            font-weight: bold;
            margin-top: 15px;
            display: block;
        }

        input{
            width: 90%;
            padding: 12px;
            margin-top: 6px;
            font-size: 16px;
        }

        button{
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background-color: #e4f1ff;
            color: #333;
            font-size: 22px;
            border: none;
        }

        button:hover{
            background-color: #d2e7ff;
        }

        .container-kembali{
            margin-bottom: 10px;
        }

        .container-kembali a{
            color: #333;
            font-weight: bold;
            text-decoration: none;
        }

        @media (max-width: 768px){
            .isiInput{
                padding: 25px;
            }

            h2{
                font-size: 28px;
            }

            label{
                font-size: 16px;
            }

            button{
                font-size: 20px;
            }
        }

        @media (max-width: 420px){
            body{
                padding: 10px;
            }

            .isiInput{
                border-width: 5px;
                padding: 20px;
            }

            h2{
                font-size: 24px;
            }

            button{
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="isiInput">
        <div class="container-kembali">
            <a href="<?php echo $home_page; ?>" class="kembali">← Kembali</a>
        </div>

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