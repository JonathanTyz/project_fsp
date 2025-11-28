<?php
session_start();
require_once 'class/group.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_POST['idgrup'])) {
    header("Location: dosen_home.php");
    exit();
}

$group_id = (int)$_POST['idgrup'];

$group = new group();
$group_detail = $group->getDetailGroup($group_id);

if (!$group_detail) {
    header("Location: dosen_home.php");
    exit();
}

if ($group_detail['username_pembuat'] !== $_SESSION['user']['username']) {
    header("Location: dosen_home.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "FULLSTACK");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnUpdate'])) {
    
    $nama = $conn->real_escape_string($_POST['nama']);
    $jenis = $conn->real_escape_string($_POST['jenis']);

    $sqlCek = "SELECT idgrup FROM grup WHERE nama = '$nama' AND idgrup != $group_id";
    $cekNama = $conn->query($sqlCek);

    if ($cekNama->num_rows > 0) {
        $error = "Nama group sudah digunakan. Silakan gunakan nama lain.";
    } else {

        $sql = "UPDATE grup SET 
                    nama = '$nama', 
                    jenis = '$jenis'
                WHERE idgrup = $group_id";

        if ($conn->query($sql)) {
            header("Location: dosen_detail_group.php?id=$group_id");
            exit();
        } else {
            $error = "Gagal mengupdate data.";
        }
    }
}


?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Group</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
        }
        .container {
            width: 500px;
            margin: 40px auto;
            padding: 20px;
            border: 10px solid #333;
            background: white;
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin: 6px 0 20px 0;
        }
        .button {
            width: 100%;
            padding: 10px;
            background: #ccc;
            border: 1px solid #333;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Group</h2>

    <?php if (!empty($error)) { echo "<p style='color:red;'>$error</p>"; } ?>

    <form method="post">
        <input type="hidden" name="idgrup" value="<?php echo $group_id; ?>">

        <label>Nama Group:</label>
        <input type="text" name="nama" value="<?php echo $group_detail['nama']; ?>" required>

        <label>Jenis Group:</label>
        <select name="jenis">
            <option value="publik" <?php if($group_detail['jenis']=='publik=') echo 'selected'; ?>>Publik</option>
            <option value="privat" <?php if($group_detail['jenis']=='privat') echo 'selected'; ?>>Privat</option>
        </select>

        <button class="button" type="submit" name="btnUpdate">Update</button>
    </form>

    <form action="dosen_detail_group.php?id=<?php echo $group_id; ?>" method="post">
        <button class="button" style="margin-top:10px;">Kembali</button>
    </form>
</div>

</body>
</html>
