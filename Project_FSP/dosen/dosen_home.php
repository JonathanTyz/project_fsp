<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dosen Home</title>
    <style>
        body{
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            background-color: #f4f6f8;
        }

        .container{
            justify-content: center;
            align-items: center;
        }

        .isi{
            background-color: #ffffff;
            width: 450px;
            padding: 35px 40px;
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
            font-size: 15px;
            font-weight: bold;
            border: none;
            cursor: pointer;
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

        .btn-logout{
            background-color: darkred; 
            color: white;
            margin-top: 20px;
        }

        .btn-change-password{
            background-color: darkcyan;
            color: white;
            margin-top: 20px;
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
