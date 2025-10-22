<!DOCTYPE html>
<html>
    <?php //Admin Kelola Data Dosen 
    require_once 'class/dosen.php';
    $mysqli = new mysqli("localhost", "root", "", "fullstack");
    if ($mysqli->connect_error) {
        die("Failed to connect to MySQL: " . $mysqli->connect_error);
    }
    ?>
<head>
    <title>Kelola Dosen</title>
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
    <h2><b>Kelola Dosen</b></h2>
    <div class = 'tabelKontainer'>
    <table>
        <thead>
            <thead>
            <tr>
                <th>Foto</th>
                <th>Nama</th>
                <th>NPK</th>
                <th colspan="2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Mendapatkan semau data dosen beserta fotonya dari database
                $PER_PAGE = 3;
                $dosen = new dosen();
                $cari = isset($_GET['cari']) ? $_GET['cari'] : '';
                $cari_persen = "%" . $cari . "%";
                $offset = isset($_GET['start']) ? (int)$_GET['start'] : 0;
                // agar tahu berapa data tiap halaman
                $res = $dosen->getDosen($cari_persen, $offset, $PER_PAGE);
                while($row = $res->fetch_assoc()) {
                    echo "<tr>";
                        // Tampilkan foto & data dosen
                        echo "<td> <img src = 'image_dosen/" . $row['npk'] . "." . $row['foto_extension'] . "' width='100'></td>";
                        echo "<td>" . $row['nama'] . "</td>";
                        echo "<td>" . $row['npk'] . "</td>";
                        echo "<td>";
                            echo "<a href = 'admin_edit_dosen.php?npk=".$row['npk']."'>Edit</a>";
                        echo "</td>";
                        echo "<td>";    
                            echo "<a href='admin_delete_dosen.php?npk=".$row['npk']."'>Delete</a>";  
                        echo "</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
    </div>
    <p>
        <?php
        $res = $dosen->getDosen($cari_persen);
        $total_data = $res->num_rows;
        $max_page = ceil($total_data / $PER_PAGE);
        $current_page = floor($offset / $PER_PAGE) + 1;
        if ($current_page > 1)
        {
            $prev = $offset - $PER_PAGE;
            echo "<a class = 'paging' href ='?start=$prev&cari=$cari'>Sebelumnya</a>";
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
        <a id='linkInsert' href = "admin_insert_dosen.php">Tambah Dosen</a>
        <a id = 'balikHome' href = "admin_home.php">Kembali ke home</a>
    </div>
</body>
</html>