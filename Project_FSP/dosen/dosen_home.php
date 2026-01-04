<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

/* ambil theme dari session */
$themeClass = '';
if (isset($_SESSION['theme']) && $_SESSION['theme'] === 'dark') {
    $themeClass = 'dark';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dosen Home</title>

    <!-- PANGGIL THEME -->
    <link rel="stylesheet" href="../css/theme.css">

    <style>
        body{
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            background-color: var(--bg-body);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            transition: background-color 0.3s ease;
        }

        .container{
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .isi{
            background-color: var(--bg-card);
            width: 400px;
            max-width: 100%;
            padding: 35px 30px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .judul{
            margin-top: 0;
            font-size: 28px;
            color: var(--text-title);
        }

        .user{
            margin: 5px 0 20px;
            font-weight: normal;
            color: var(--text-normal);
        }

        .menu-button{
            display: block;
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            font-size: 16px;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        .menu-button:hover{
            opacity: 0.9;
        }

        .btn-kelola{ background-color: darkslategray; color: white; }
        .btn-diikuti{ background-color: midnightblue; color: white; }
        .btn-publik{ background-color: steelblue; color: white; }
        .btn-change-password{ background-color: darkcyan; color: white; }
        .btn-theme{ background-color: gray; color: white; }
        .btn-logout{ background-color: darkred; color: white; }
    </style>
</head>

<!-- TERAPKAN THEME -->
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
            <button class="menu-button btn-theme">
                Change Theme
            </button>
        </a>

        <a href="../logout.php">
            <button class="menu-button btn-logout">Logout</button>
        </a>
    </div>
</div>

</body>
</html>
