<!DOCTYPE html>
<html>
<head>
    <title>DOSEN</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            width: 250px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: black;
        }
        .menu-item {
            margin-bottom: 15px;
            text-align: left;
        }
        label {
            font-size: 14px;
            display: block;
            margin-bottom: 5px;
            color: black;
        }
        button {
            width: 107%;
            padding: 8px;
            background: blue;
            border: none;
            color: white;
            cursor: pointer;
        }
        button a {
            text-decoration: none;
            color: white;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome Dosen</h2>

        <div class="menu-item">
            <label>Change Password</label>
            <button><a href="change_password.php">Change Password</a></button>
        </div>

        <div class="menu-item">
            <label>Exit to Login</label>
            <button><a href="Login.php">EXIT</a></button>
        </div>
    </div>
</body>
</html>
