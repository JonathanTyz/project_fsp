<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

/* ambil theme dari session */
$themeClass = $_SESSION['theme'] ?? 'light';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dosen Home</title>

    <!-- THEME -->
    <link rel="stylesheet" href="../css/theme.css">

    <style>
        body{
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
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
        }

        /* === CARD SAMA PERSIS MAHASISWA === */
        .isi{
            background-color: #ffffff;
            width: 90%;
            max-width: 420px;
            padding: 35px 40px;
            text-align: center;
        }

        body.dark .isi{
            background-color: #2a2a2a;
        }

        .judul{
            font-size: 28px;
            color: #2c3e50;
        }

        body.dark .judul{
            color: #ffffff;
        }

        .user{
            margin: 5px 0 20px;
            font-weight: normal;
            color: #333;
        }

        body.dark .user{
            color: #eee;
        }

        /* === TOMBOL (STRUKTUR DOSEN, WARNA MAHASISWA) === */
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
            background-color: #2c3e50;
            color: #fff;
        }

        .btn-diikuti{
            background-color: #1f2f3d;
            color: #fff;
        }

        .btn-publik{
            background-color: #1f2f3d;
            color: #fff;
        }

        .btn-change-password{
            background-color: #6c757d;
            color: #fff;
        }

        .btn-theme{
            background-color: #888;
            color: #fff;
        }

        .btn-logout{
            background-color: #a94442;
            color: #fff;
        }

        @media (max-width: 600px){
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
            .isi{
                padding: 25px 20px;
            }
        }
    </style>
</head>

<body class="<?= $themeClass ?>">

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

        <a href="../css/toggle_theme.php">
            <button class="menu-button btn-theme">Change Theme</button>
        </a>

        <a href="../logout.php">
            <button class="menu-button btn-logout">Logout</button>
        </a>
    </div>
</div>

</body>
</html>
