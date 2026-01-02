<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php"); exit();
}

if (!isset($_POST['idgrup'])) {
    header("Location: dosen_home.php"); exit();
}

$idgrup    = $_POST['idgrup'];
$nama      = $_POST['nama'];
$jenis     = $_POST['jenis'];
$deskripsi = $_POST['deskripsi'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Group</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f6f8;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            color: #333;
            font-size: 32px;
        }

        #pembukaanteks {
            font-size: 24px;
            text-decoration: underline;
            font-weight: bold;
            font-family: 'Times New Roman', Times, serif;
            color: #333;
            text-align: center;
        }

        .isiInput {
            background-color: lightcyan;
            border: 5px solid #333;
            padding: 25px 20px;
            width: 400px;
            max-width: 90%;
            margin: 20px auto;
            text-align: center;
        }

        label {
            display: block;
            text-align: left;
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"], textarea, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #333;
            font-size: 16px;
        }

        .button, button {
            padding: 12px 20px;
            background-color: #2c3e50;
            border: none;
            color: white;
            font-weight: bold;
            font-size: 16px;
            margin-top: 10px;
        }

        .button-secondary {
            background-color: #6c757d;
        }

        @media (max-width: 500px) {
            h2 {
                font-size: 24px;
            }

            #pembukaanteks {
                font-size: 20px;
            }

            input[type="text"], textarea, select {
                font-size: 14px;
                padding: 6px;
            }

            .button, button {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<form action="dosen_kelola_group.php" method="post">
    <button class="kembali" type="submit" class="button button-secondary">Kembali ke Daftar Group</button>
</form>

<h2 id='pembukaanteks'>Edit Group</h2>

<div class="isiInput">
    <h3>Lakukan Edit Group</h3>

    <form action="dosen_edit_group_proses.php" method="post">
        <input type="hidden" name="idgrup" value="<?= $idgrup ?>">

        <label>Nama Group:</label>
        <input type="text" name="nama" required value="<?= htmlspecialchars($nama) ?>">

        <label>Jenis Group:</label>
        <select name="jenis">
            <option value="Publik" <?= $jenis=="Publik" ? "selected" : "" ?>>Publik</option>
            <option value="Privat" <?= $jenis=="Privat" ? "selected" : "" ?>>Privat</option> 
        </select>

        <label>Deskripsi:</label>
        <textarea name="deskripsi" rows="4"><?= htmlspecialchars($deskripsi) ?></textarea>

        <button type="submit" name="btnSubmit">Update</button>
    </form>
</div>

</body>
</html>
