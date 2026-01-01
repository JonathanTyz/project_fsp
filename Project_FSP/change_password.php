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
            display: flex;
            align-items: center;
            min-height: 100vh;
        }

        .isiInput{
            background-color: white;
            border: 10px solid #333;
            padding: 30px 40px;
            text-align: center;
            width: 90%;
            max-width: 400px;
            margin: auto;
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
            color: #444;
            font-weight: bold;
            margin-top: 15px;
            display: block;
            text-align: left;
        }

        input, button{
            width: 100%;
            max-width: 300px;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        button{
            background-color: #e4f1ffff;
            color: #333;
            font-size: 24px;
            margin-top: 10px;
        }

        .container-kembali{
            display: inline-block;
            margin-bottom: 10px;
        }
        .container-kembali a{
            color: #333;
            font-weight: bold;
            text-decoration: none;
        }

        @media (max-width: 600px) {
            .isiInput{
                padding: 20px;
                border-width: 5px;
            }
            h2{
                font-size: 28px;
            }
            h4{
                font-size: 16px;
            }
            label{
                font-size: 16px;
            }
            button{
                font-size: 20px;
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