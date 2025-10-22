<!DOCTYPE html>
<html>
    <?php //Admin Kelola Data Dosen 
    require_once 'class/mahasiswa.php';
    session_start();
    if (!isset($_SESSION['user'])) 
        {
            header("Location: login.php");
            exit();
        }
        $mysqli = new mysqli("localhost", "root", "", "fullstack");
    if ($mysqli->connect_error) {
        die("Failed to connect to MySQL: " . $mysqli->connect_error);
    }
    ?>
<head>
    <title>Kelola Mahasiswa</title>
    <style>
        h2{
            text-align: center;
            margin-top: 30px;
            color: #333;
            font-size: 36px;
            font-weight: bold;
        }
        img{
            border: 2px solid #ddd;
        }
        p{
            text-align: center;
            margin-top: 25px;
            color: #333;
            font-size: 20px;
        }
        table {
           width: 80%;
            margin: 20px auto;
            background: white;
            border: 10px #333;
        }
        th, td {
            border: 1px solid black; 
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2; 
        }
        #linkInsert{
            margin-left: 100px;
            padding: 8px;
            font-size: 20px;
            font-weight: bold;
        }
        #balikHome{
            margin-left: 100px;
            padding: 8px;
            font-size: 20px;
            font-weight: bold;
        }
        .tabelKontainer{
            width: 90%;
            margin: 20px auto;
            background: lightblue;
            padding: 20px;
            border: 10px solid #333;
        }
        .linkKontainer{
            width: 40%;
            margin: 20px auto;
            background: lightblue;
            padding: 20px;
            border: 10px solid #333;
        }
        .paging{
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class = 'tabelKontainer'>
    <h2><b>Kelola Mahasiswa</b></h2>
    <table>
        <thead>
            <thead>
            <tr>
                <th>Foto</th>
                <th>NRP</th>
                <th>Nama</th>
                <th>Gender</th>
                <th>Tanggal Lahir</th>
                <th>Angkatan</th>
                <th colspan="2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $PER_PAGE = 3;
                $mahasiswa = new mahasiswa();
                $cari = isset($_GET['cari']) ? $_GET['cari'] : '';
                $cari_persen = "%" . $cari . "%";
                $offset = isset($_GET['start']) ? (int)$_GET['start'] : 0;
               // agar tahu berapa data tiap halaman
                $res = $mahasiswa->getMahasiswa($cari_persen, $offset, $PER_PAGE);
                while($row = $res->fetch_assoc()) {
                    echo "<tr>";//buat nampilin foto mahasiswa 
                        echo "<td> <img src = 'image_mahasiswa/" . $row['nrp'] . "." . $row['foto_extention'] . "' width='100'></td>";
                        echo "<td>" . $row['nrp'] . "</td>";
                        echo "<td>" . $row['nama'] . "</td>";
                        echo "<td>" . $row['gender'] . "</td>";
                        echo "<td>" . $row['tanggal_lahir'] . "</td>";
                        echo "<td>" . $row['angkatan'] . "</td>";

                        echo "<td>";
                            echo "<a href = 'admin_edit_mahasiswa.php?nrp=".$row['nrp']."'>Edit</a>";
                        echo "</td>";
                        echo "<td>";    
                            echo "<a href='admin_delete_mahasiswa.php?nrp=".$row['nrp']."'>Delete</a>";  
                        echo "</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
    </div>
    <p>
        <?php
        $res = $mahasiswa->getMahasiswa($cari_persen);
        $total_data = $res->num_rows;
        $max_page = ceil($total_data / $PER_PAGE);
        $current_page = floor($offset / $PER_PAGE) + 1;
        if ($current_page > 1)
        {
            $prev = $offset - $PER_PAGE;
            echo "<a class = 'paging' href ='?start=$prev&cari=$cari'>Sebelumnya</a>
";
        }
        
        for($page=1; $page <= $max_page; $page++) 
        {
            $offs = ($page - 1) * $PER_PAGE;
            if ($page == $current_page) 
            {
                echo "<b class = 'paging'>$page</b> ";
            }
            else{
                echo "<a class='paging' href='?start=$offs&cari=$cari'>$page</a> ";
            }
        }
        if ($current_page < $max_page)
        {
            $next = $offset + $PER_PAGE;
            echo "<a class='paging' href='?start=$next&cari=$cari'> Selanjutnya</a> ";
        }
        ?>

    </p> <br>
    <div class = 'linkKontainer'>
        <a id = 'linkInsert' href = "admin_insert_mahasiswa.php">Tambah Mahasiswa</a>
        <a id = 'balikHome' href = "admin_home.php">Kembali ke home</a>
    </div>
</body>
</html>