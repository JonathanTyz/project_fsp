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
<html>
<head>
    <title>Halaman Admin</title>
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

        .isi{
            background-color: #ffffff;
            padding: 35px 40px;
            text-align: center;
            width: 400px;
            border: 10px solid #333;
        }

        body.dark .isi{
            background-color: #2a2a2a;
            border-color: #555;
        }

        h2{
            font-size: 28px;
            color: #2c3e50;
        }

        body.dark h2{
            color: #ffffff;
        }

        h4, p{
            color: #333;
        }

        body.dark h4,
        body.dark p{
            color: #eeeeee;
        }

        button{
            width: 200px;
            padding: 12px;
            margin: 10px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            color: white;
        }

        button a{
            color: white;
            text-decoration: none;
            display: block;
        }

        .btn-dosen{
            background-color: #2c3e50;
        }

        .btn-mahasiswa{
            background-color: #1f2f3d;
        }

        .btn-theme{
            background-color: #888;
        }

        .btn-logout{
            background-color: #a94442;
        }

        @media (max-width: 600px){
            .isi{
                width: 90%;
                padding: 25px 20px;
            }

            h2{
                font-size: 22px;
            }

            button{
                width: 100%;
            }
        }
    </style>
</head>

<body class="<?= $themeClass ?>">

<div class="isi">
    <h2><b>Welcome Dosen <?= $_SESSION['user']['username']; ?></b></h2>
    <h4><b>Role: Admin</b></h4>

    <p>Silakan pilih halaman yang ingin Anda lihat:</p>

    Kelola Data Dosen: <br>
    <button class="btn-dosen">
        <a href="admin_dosen.php">Lihat Dosen</a>
    </button><br>

    Kelola Data Mahasiswa: <br>
    <button class="btn-mahasiswa">
        <a href="admin_mahasiswa.php">Lihat Mahasiswa</a>
    </button><br>

    Ganti Theme:<br>
    <a href="../css/toggle_theme.php">
        <button class="btn-theme">
            Change Theme
        </button>
    </a></br>

    Keluar: <br>
    <button class="btn-logout">
        <a href="../logout.php">EXIT</a>
    </button>
</div>

</body>
</html>
