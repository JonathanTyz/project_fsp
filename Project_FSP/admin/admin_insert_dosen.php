<?php
$mysqli = new mysqli("localhost", "root", "", "fullstack");
if ($mysqli->connect_error) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

session_start();
require_once '../css/theme_session.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Insert Data Dosen</title>

    <link rel="stylesheet" href="../css/theme.css">

    <style>
    body{
        font-family:'Times New Roman', serif;
        margin:0;
        padding:20px;
    }

    h2{
        text-align:center;
        font-size:36px;
    }

    #pembukaanteks{
        font-size:22px;
        text-decoration:underline;
        font-weight:bold;
        text-align:center;
        margin-bottom:20px;
    }

    .isiInput{
        padding:30px 40px;
        width:400px;
        margin:30px auto;
        border-radius:8px;
        border:2px solid;
    }

    label{
        font-weight:bold;
    }

    input{
        width:100%;
        padding:8px;
        margin-top:5px;
    }

    button{
        width:100%;
        padding:12px;
        font-size:18px;
        font-weight:bold;
        border-radius:6px;
        border:1px solid;
        cursor:pointer;
    }

    .center{
        text-align:center;
        margin-bottom:15px;
    }

    .kembaliForm{
        width:500px;
    }

    /* ======================
       LIGHT THEME
    ====================== */
    body.light{
        background:#f4f6f8;
        color:#000;
    }

    body.light .isiInput{
        background:lightcyan;
        border-color:#333;
    }

    body.light button{
        background:#2c3e50;
        color:white;
        border-color:#2c3e50;
    }

    body.light button:hover{
        background:#1f2d3a;
    }

    /* ======================
       DARK THEME
    ====================== */
    body.dark{
        background:#1e1e1e;
        color:#eee;
    }

    body.dark .isiInput{
        background:#2a2a2a;
        border-color:#555;
    }

    body.dark input{
        background:#1e1e1e;
        color:white;
        border:1px solid #555;
    }

    body.dark button{
        background:#3a3a3a;
        color:white;
        border-color:#555;
    }

    body.dark button:hover{
        background:#555;
    }

    /* ======================
       RESPONSIVE
    ====================== */
    @media(max-width:500px){
        .isiInput{
            width:90%;
        }

        .kembaliForm{
            width:100%;
        }
    }
    </style>
</head>

<body class="<?= $themeClass ?>">

<div class="center">
    <form action="admin_dosen.php" method="post">
        <button class="kembaliForm" type="submit">← Kembali ke Home</button>
    </form>
</div>

<div class="isiInput">
<h2><b>Insert Data Dosen</b></h2>
<p id="pembukaanteks">Masukkan data dosen</p>

<form method="post" action="admin_insert_proses_dosen.php" enctype="multipart/form-data">
    <p>
        <label>Username</label>
        <input type="text" name="username">
    </p>

    <p>
        <label>Password</label>
        <input type="password" name="password">
    </p>

    <p>
        <label>NPK</label>
        <input type="text" name="npk">
    </p>

    <p>
        <label>Nama</label>
        <input type="text" name="nama">
    </p>

    <p>
        <label>Foto Dosen</label>
        <input type="file" name="foto[]" accept="image/jpeg,image/png">
    </p>

    <button type="submit" name="btnSimpan" value="simpan">Simpan</button>
</form>
</div>

</body>
</html>
