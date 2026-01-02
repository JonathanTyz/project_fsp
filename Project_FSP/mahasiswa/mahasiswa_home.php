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
    <title>Mahasiswa Home</title>
    <style>
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
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .isi{
            background-color: #ffffff;
            width: 90%;
            max-width: 420px;
            padding: 35px 40px;
            text-align: center;
        }

        .judul{
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
        }

        .menu-button-daftar-group-join{
            background-color: #2c3e50;
            color: #ffffff;
        }

        .menu-button-daftar-group-publik{
            background-color: #1f2f3d;
            color: #ffffff;
        }

        .menu-button-change-password{
            background-color: #6c757d;
            color: #ffffff;
        }

        .menu-button-logout{
            background-color: #a94442;
            color: #ffffff;
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
<body>
<div class="container">
    <div class="isi">
        <h2 class="judul">Welcome</h2>
        <h3 class="user"><?php echo $_SESSION['user']['username']; ?></h3>
        <h3 class = "user">Role: Mahasiswa</h3>

        <a href="mahasiswa_daftar_group_join.php">
            <button class="menu-button menu-button-daftar-group-join">
                Lihat Grup yang Telah Anda Join
            </button>
        </a>

        <a href="mahasiswa_daftar_group_tersedia.php">
            <button class="menu-button menu-button-daftar-group-publik">
                Lihat Grup yang Tersedia
            </button>
        </a>

        <a href="../change_password.php">
            <button class="menu-button menu-button-change-password">
                Change Password
            </button>
        </a>

        <a href="../logout.php">
            <button class="menu-button menu-button-logout">
                Logout
            </button>
        </a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function(){
        $('#toggleTheme').click(function(){
            $('body').toggleClass('dark');
        });
    });
</script>

</body>
</html>