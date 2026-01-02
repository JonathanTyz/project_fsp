<!DOCTYPE html>
<html>
    <?php //Admin Kelola Data Dosen 
    require_once '../class/mahasiswa.php';
    session_start();
    if (!isset($_SESSION['user'])) 
        {
            header("Location: ../login.php");
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
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            background-color: #f4f6f8;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
            color: #333;
            font-size: 36px;
            font-weight: bold;
        }

        table {
            width: 80%;
            margin: 20px auto;
            background: white;

        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        #linkInsert, #balikHome {
            display: inline-block;
            padding: 10px 20px;
            font-size: 20px;
            font-weight: bold;
            text-decoration: none;
            color: white;
            background-color: #3498db;
            margin: 10px auto;
        }

        .tabelKontainer {
            width: 90%;
            margin: 20px auto;
            background: lightblue;
            padding: 20px;
            border: 10px solid #333;        
        }

        .linkKontainer {
            width: 40%;
            margin: 20px auto;
            text-align: center;
        }

        .paging {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            display: inline-block;
        }

        img {
            border: 2px solid #ddd;
            border-radius: 6px;
        }

        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
                width: 90%;
                margin: 0 auto;
            }


            tr {
                background: #fff;
                border: 2px solid #2c3e50;
                margin-bottom: 15px;
                padding: 15px;
            }

            td {
                display: flex;
                align-items: center;
                border: none;
                padding: 6px 10px;
                margin: 0 auto;
                text-align: left;
                max-width: 400px;
            }


            img {
                max-width: 80px;
                height: auto;
                border-radius: 8px;
                margin-right: 10px;
            }

            #linkInsert, #balikHome {
                width: 90%;
                font-size: 18px;
                padding: 12px 0;
            }

            .linkKontainer {
                width: 90%;
            }
        }

        @media (max-width: 480px) {
            h2 { font-size: 24px; }
            td { flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body>
    <div class = 'tabelKontainer'>
    <h2><b>Kelola Mahasiswa</b></h2>
     <div class="rwd"></div>
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
                        echo "<td> <img src = '../image_mahasiswa/" . $row['nrp'] . "." . $row['foto_extention'] . "' width='100'></td>";
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
    </div>
    <div style = "text-align: center;">
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

    </p></div>
    <br>
    <div class = 'linkKontainer'>
        <a id = 'linkInsert' href = "admin_insert_mahasiswa.php">Tambah Mahasiswa</a>
    </div>
    <div class = 'linkKontainer'>
        <a id = 'balikHome' href = "admin_home.php">Kembali ke home</a>
    </div>
</body>
</html>