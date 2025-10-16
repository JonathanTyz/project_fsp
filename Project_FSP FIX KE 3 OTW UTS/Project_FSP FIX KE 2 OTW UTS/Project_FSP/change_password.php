<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
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
        form {
            width: 250px;
            text-align: left;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: black;
        }
        label {
            font-size: 14px;
            display: block;
            margin-bottom: 5px;
            color: black;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #aaa;
        }
        button {
            width: 107%;
            padding: 8px;
            background: blue;
            border: none;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <form method="POST" action="change_password_proses.php">
        <h2>Change Password</h2>

        <label>Old Password</label>
        <input type="password" name="old_password" required>

        <label>New Password</label>
        <input type="password" name="password" required>

        <button type="submit">Change Password</button>
    </form>
</body>
</html>
