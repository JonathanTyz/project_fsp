<!DOCTYPE html>
<?php
    require_once 'class/dosen.php';
?>
<html>
<head>
    <title>Kelola Dosen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: black;
        }
        table {
            width: 90%;
            margin: 0 auto 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black; 
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2; 
        }
        img.poster {
            border: 1px solid #ccc;
            padding: 2px;
        }
        .pagination {
            text-align: center;
            margin: 15px 0;
        }
        .pagination a {
            margin: 0 3px;
            text-decoration: none;
            color: blue;
        }
        .menu-links {
            text-align: center;
            margin-top: 20px;
        }
        .menu-links a {
            display: inline-block;
            margin: 0 10px;
            padding: 8px 12px;
            background: blue;
            color: white;
            text-decoration: none;
            border: none;
        }
    </style>
</head>
<body>
    <h2>Kelola Dosen</h2>
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
            $mysqli = new mysqli("localhost", "root", "", "fullstack");
            if ($mysqli->connect_error) {
                die("Failed to connect to MySQL: " . $mysqli->connect_error);
            }

            $PER_PAGE = 3;
            $dosen = new dosen();
            $cari = isset($_GET['cari']) ? $_GET['cari'] : '';
            $cari_persen = "%" . $cari . "%";
            $offset = isset($_GET['start']) ? (int)$_GET['start'] : 0;

            $res = $dosen->getDosen($cari_persen, $offset, $PER_PAGE);
            while($row = $res->fetch_assoc()) {
                echo "<tr>";
                    echo "<td><img class='poster' src='image_dosen/" . $row['npk'] . "." . $row['foto_extension'] . "' width='100'></td>";
                    echo "<td>" . $row['nama'] . "</td>";
                    echo "<td>" . $row['npk'] . "</td>";
                    echo "<td><a href='admin_edit_dosen.php?npk=".$row['npk']."'>Edit</a></td>";
                    echo "<td><a href='admin_delete_dosen.php?npk=".$row['npk']."'>Delete</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php
        $res = $dosen->getDosen($cari_persen);
        $total_data = $res->num_rows;
        $max_page = ceil($total_data / $PER_PAGE);
        for($page=1; $page <= $max_page; $page++) {
            $offs = ($page - 1) * $PER_PAGE;
            echo "<a href='?start=$offs&cari=$cari'>$page</a> ";
        }
        ?>
    </div>

    <div class="menu-links">
        <a href="admin_insert_dosen.php">Tambah Dosen</a>
        <a href="admin_home.php">Kembali ke Home</a>
    </div>

</body>
</html>
