<!DOCTYPE html>
<html>
<head>
    <title>Halaman Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        h2 {
            margin-bottom: 10px;
            color: black;
        }
        p {
            margin-bottom: 20px;
            font-size: 18px;
            color: #333;
        }
        .menu {
            margin: 20px 0;
        }
        .menu a {
            display: inline-block;
            margin: 10px;
            padding: 10px 15px;
            background: blue;
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h2>Halaman Admin</h2>
    <p>Silakan pilih halaman yang ingin Anda kelola:</p>

    <div class="menu">
        <a href="admin_dosen.php">Kelola Data Dosen</a>
        <a href="admin_mahasiswa.php">Kelola Data Mahasiswa</a>
        <a href="login.php">Logout</a>
    </div>
</body>
</html>
