<!DOCTYPE html>
<html>
    <?php //Admin Kelola Data Dosen 
    require_once '../class/dosen.php';
    require_once '../css/theme_session.php';
    $mysqli = new mysqli("localhost", "root", "", "fullstack");
    if ($mysqli->connect_error) {
        die("Failed to connect to MySQL: " . $mysqli->connect_error);
    }
    ?>
<head>
    <title>Kelola Dosen</title>
    <link rel="stylesheet" href="../css/theme.css">
    <style>
        body{
            font-family: 'Times New Roman', serif;
            margin: 0;
            background-color: #f4f6f8;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        body.dark{
            background-color: #1e1e1e;
        }

        h2{
            text-align: center;
            margin-top: 30px;
            color: #2c3e50;
            font-size: 36px;
            font-weight: bold;
        }

        body.dark h2{
            color: #ffffff;
        }

        table{
            width: 80%;
            margin: 20px auto;
            background: white;
        }

        body.dark table{
            background-color: #2a2a2a;
        }

        th, td{
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        body.dark th,
        body.dark td{
            border-color: #555;
            color: #eeeeee;
        }

        th{
            background-color: #f2f2f2;
        }

        body.dark th{
            background-color: #333;
        }

        #linkInsert, #balikHome{
            display: inline-block;
            padding: 10px 20px;
            font-size: 20px;
            font-weight: bold;
            text-decoration: none;
            color: white;
            background-color: #2c3e50;
            margin: 10px auto;
        }

        #balikHome{
            background-color: steelblue;
        }

        .tabelKontainer{
            width: 90%;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border: 10px solid #333;        
        }

        body.dark .tabelKontainer{
            background-color: #2a2a2a;
            border-color: #555;
        }

        .linkKontainer{
            width: 40%;
            margin: 20px auto;
            text-align: center;
        }

        .paging{
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            display: inline-block;
            margin: 0 5px;
            color: #2c3e50;
            text-decoration: none;
        }

        body.dark .paging{
            color: #ffffff;
        }

        img{
            border: 2px solid #ddd;
            border-radius: 6px;
        }

        @media (max-width: 768px){
            table, thead, tbody, th, td, tr{
                display: block;
                width: 90%;
                margin: 0 auto;
            }

            tr{
                background: #fff;
                border: 2px solid #2c3e50;
                margin-bottom: 15px;
                padding: 15px;
            }

            body.dark tr{
                background-color: #2a2a2a;
                border-color: #555;
            }

            td{
                display: flex;
                align-items: center;
                border: none;
                padding: 6px 10px;
                margin: 0 auto;
                text-align: left;
                max-width: 400px;
            }

            img{
                max-width: 80px;
                height: auto;
                border-radius: 8px;
                margin-right: 10px;
            }

            #linkInsert, #balikHome{
                width: 90%;
                font-size: 18px;
                padding: 12px 0;
            }

            .linkKontainer{
                width: 90%;
            }
        }

        @media (max-width: 480px){
            h2{ font-size: 24px; }
            td{ flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body class="<?= $_SESSION['theme'] ?? 'light' ?>">
    <h2><b>Kelola Dosen</b></h2>
    <div class='tabelKontainer'>
    <table>
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
                $PER_PAGE = 3;
                $dosen = new dosen();
                $cari = isset($_GET['cari']) ? $_GET['cari'] : '';
                $cari_persen = "%" . $cari . "%";
                $offset = isset($_GET['start']) ? (int)$_GET['start'] : 0;
                $res = $dosen->getDosen($cari_persen, $offset, $PER_PAGE);
                while($row = $res->fetch_assoc()) {
                    echo "<tr>";
                        echo "<td><img src='../image_dosen/".$row['npk'].".".$row['foto_extension']."' width='100'></td>";
                        echo "<td>".$row['nama']."</td>";
                        echo "<td>".$row['npk']."</td>";
                        echo "<td><a href='admin_edit_dosen.php?npk=".$row['npk']."'>Edit</a></td>";
                        echo "<td><a href='admin_delete_dosen.php?npk=".$row['npk']."'>Delete</a></td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
    </div>

    <div style="text-align:center;">
        <p>
        <?php
            $res = $dosen->getDosen($cari_persen);
            $total_data = $res->num_rows;
            $max_page = ceil($total_data / $PER_PAGE);
            $current_page = floor($offset / $PER_PAGE) + 1;

            if ($current_page > 1){
                $prev = $offset - $PER_PAGE;
                echo "<a class='paging' href='?start=$prev&cari=$cari'>Sebelumnya</a>";
            }

            for($page=1; $page <= $max_page; $page++){
                $offs = ($page - 1) * $PER_PAGE;
                if ($page == $current_page){
                    echo "<b class='paging'>$page</b> ";
                } else {
                    echo "<a class='paging' href='?start=$offs&cari=$cari'>$page</a> ";
                }
            }

            if ($current_page < $max_page){
                $next = $offset + $PER_PAGE;
                echo "<a class='paging' href='?start=$next&cari=$cari'>Selanjutnya</a>";
            }
        ?>
        </p>
    </div>

    <div class='linkKontainer'>
        <a id='linkInsert' href="admin_insert_dosen.php">Tambah Dosen</a>
    </div>
    <div class='linkKontainer'>
        <a id='balikHome' href="admin_home.php">Kembali ke home</a>
    </div>
</body>
</html>
