<!DOCTYPE html>
<html>
<head>
    <title>Kelola Mahasiswa</title>
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
    <h2>Kelola Mahasiswa</h2>
    
    <table>
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
            require_once 'class/mahasiswa.php';
            $mysqli = new mysqli("localhost", "root", "", "fullstack");
            if ($mysqli->connect_error) {
                die("Failed to connect to MySQL: " . $mysqli->connect_error);
            }

            $PER_PAGE = 3;
            $mahasiswa = new mahasiswa();
            $cari = isset($_GET['cari']) ? $_GET['cari'] : '';
            $cari_persen = "%" . $cari . "%";
            $offset = isset($_GET['start']) ? (int)$_GET['start'] : 0;

            $res = $mahasiswa->getMahasiswa($cari_persen, $offset, $PER_PAGE);
            while($row = $res->fetch_assoc()) {
                echo "<tr>";
                    echo "<td><img class='poster' src='image_mahasiswa/" . $row['nrp'] . "." . $row['foto_extention'] . "' width='100'></td>";
                    echo "<td>" . $row['nrp'] . "</td>";
                    echo "<td>" . $row['nama'] . "</td>";
                    echo "<td>" . $row['gender'] . "</td>";
                    echo "<td>" . $row['tanggal_lahir'] . "</td>";
                    echo "<td>" . $row['angkatan'] . "</td>";
                    echo "<td><a href='admin_edit_mahasiswa.php?nrp=".$row['nrp']."'>Edit</a></td>";
                    echo "<td><a href='admin_delete_mahasiswa.php?nrp=".$row['nrp']."'>Delete</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php
        $res = $mahasiswa->getMahasiswa($cari_persen);
        $total_data = $res->num_rows;
        $max_page = ceil($total_data / $PER_PAGE);
        for($page=1; $page <= $max_page; $page++) {
            $offs = ($page - 1) * $PER_PAGE;
            echo "<a href='?start=$offs&cari=$cari'>$page</a> ";
        }
        ?>
    </div>

    <div class="menu-links">
        <a href="admin_insert_mahasiswa.php">Tambah Mahasiswa</a>
        <a href="admin_home.php">Kembali ke Home</a>
    </div>

</body>
</html>
