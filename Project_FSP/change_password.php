<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['user']['role'] != 'mahasiswa' && $_SESSION['user']['role'] != 'dosen') {
    header("Location: login.php");
    exit();
}

/* home berdasarkan role */
if ($_SESSION['user']['role'] == 'mahasiswa') {
    $home_page = "mahasiswa/mahasiswa_home.php";
} else {
    $home_page = "dosen/dosen_home.php";
}

/* theme */
$themeClass = $_SESSION['theme'] ?? 'light';
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
            cursor: pointer;
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

        /* =====================
           DARK MODE
        ===================== */
        body.dark{
            background-color: #121212;
            color: #f1f1f1;
        }

        body.dark .isiInput{
            background-color: #1e1e1e;
            border-color: #555;
        }

        body.dark h2{
            color: #ffffff;
        }

        body.dark label{
            color: #dddddd;
        }

        body.dark input{
            background-color: #2a2a2a;
            color: #ffffff;
            border: 1px solid #555;
        }

        body.dark button{
            background-color: #3a3a3a;
            color: #ffffff;
        }

        body.dark button:hover{
            background-color: #555;
        }

        body.dark .container-kembali a{
            color: #cccccc;
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

<body class="<?= $themeClass ?>">

<div class="isiInput">
    <div class="container-kembali">
        <a href="<?= $home_page ?>">← Kembali</a>
    </div>

    <h2><b>Change Password</b></h2>

    <form method="POST" action="change_password_proses.php">
        <p>
            <label>Old Password:</label>
            <input type="password" name="old_password" required>
        </p>

        <p>
            <label>Password Baru:</label>
            <input type="password" name="password" required>
        </p>

        <button type="submit">Change Password</button>
    </form>
</div>

</body>
</html>
