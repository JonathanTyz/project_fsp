<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php"); exit();
}

if (!isset($_POST['idgrup'])) {
    header("Location: dosen_home.php"); exit();
}

$idgrup  = $_POST['idgrup'];
$nama    = $_POST['nama'];
$jenis   = $_POST['jenis'];
$deskripsi = $_POST['deskripsi'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edit Group</title>
        <style>
            h2{
                margin-top: 30px;
                color: #333;
                font-size: 36px;
            }
            input, textarea, select {
                margin: 10px;
                padding: 5px;
                width: 300px;
            }
            #pembukaanteks{
                font-size: 26px;
                text-decoration: underline;
                text-decoration: bold;
                font-family: 'Times New Roman', Times, serif;
                color: #333;
            }
            .isiInput{
                background-color: white;
                border:10px solid  #333;
                background: lightcyan;
                padding: 30px 40px;
                text-align: center;
                width: 350px;
            }
            .button {
                padding: 10px 18px;
                background-color: #2c3e50;
                border: none;
                color: white;
                font-weight: bold;
            }

        </style>
    </head>
<body>

    <form action="dosen_kelola_group.php" method="post">
        <button class="button" type="submit">Kembali ke Daftar Group</button>
    </form>
    <h2 class='pembukaanteks'>Edit Group</h2>
    
    <div class="isiInput">
        <h3>Lakukan Edit Group</h3>

        <form action="dosen_edit_group_proses.php" method="post">
            
            <input type="hidden" name="idgrup" value="<?php echo $idgrup ?>">

            <label>Nama Group:</label><br>
            <input type="text" name="nama" required value="<?php echo htmlspecialchars($nama) ?>"><br><br>

            <label>Jenis Group:</label><br>
            <select name="jenis">
                <option value="Publik" <?php if($jenis=="Publik") echo "selected"; ?>>Publik</option>
                <option value="Privat" <?php if($jenis=="Privat") echo "selected"; ?>>Privat</option> 
            </select><br><br>

            <label>Deskripsi:</label><br>
            <textarea name="deskripsi" rows="4"><?php echo htmlspecialchars($deskripsi) ?></textarea><br><br>

            <button type="submit" name="btnSubmit">Update</button>
        </form>
    </div>

</body>
</html>
