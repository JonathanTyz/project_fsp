<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dosen Home</title>
    <style>
        /* ===== Body & Container ===== */
        body{
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            background-color: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container{
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .isi{
            background-color: #ffffff;
            width: 400px;
            max-width: 100%;
            padding: 35px 30px;
            text-align: center;
        }

        .judul{
            margin-top: 0;
            font-size: 28px;
            color: #2c3e50;
        }

        .user{
            margin: 5px 0 20px;
            font-weight: normal;
            color: #333;
        }

        .menu-button{
            display: block;
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            font-size: 16px;
            font-weight: bold;
            border: none;
        }

        .menu-button:hover{
            opacity: 0.9;
        }

        .btn-kelola{
            background-color: darkslategray;
            color: white;
        }

        .btn-diikuti{
            background-color: midnightblue; 
            color: white;
        }

        .btn-publik{
            background-color: steelblue; 
            color: white;
        }

        .btn-change-password{
            background-color: darkcyan;
            color: white;
        }

        .btn-logout{
            background-color: darkred; 
            color: white;
        }

        @media (max-width: 480px){
            .isi{
                padding: 25px 20px;
            }

            .judul{
                font-size: 22px;
            }

            .user{
                font-size: 16px;
            }

            .menu-button{
                font-size: 14px;
                padding: 10px;
            }
        }

    </style>
</head>
<body>

<div class="container">
    <div class="isi">
        <h2 class="judul">Welcome</h2>
        <h3 class="user"><?= $_SESSION['user']['username']; ?></h3>
        <h3 class="user">Role: Dosen</h3>

        <a href="dosen_kelola_group.php">
            <button class="menu-button btn-kelola">Kelola Group</button>
        </a>

        <a href="dosen_group_diikuti.php">
            <button class="menu-button btn-diikuti">Group yang Diikuti</button>
        </a>

        <a href="dosen_group_publik.php">
            <button class="menu-button btn-publik">Daftar Group Publik</button>
        </a>

        <a href="../change_password.php">
            <button class="menu-button btn-change-password">Change Password</button>
        </a>

        <a href="../logout.php">
            <button class="menu-button btn-logout">Logout</button>
        </a>
    </div>
</div>

</body>
</html>
