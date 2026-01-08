<!DOCTYPE html>
<html>
<?php
require_once '../class/mahasiswa.php';
session_start();
require_once '../css/theme_session.php';

if (!isset($_SESSION['user'])) {
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

    <link rel="stylesheet" href="../css/theme.css">

    <style>
        body{
            font-family:'Times New Roman', serif;
            margin:0;
            padding:20px;
        }

        h2{
            text-align:center;
            margin-top:30px;
            font-size:36px;
            font-weight:bold;
        }

        table{
            width:80%;
            margin:20px auto;
            border-collapse:collapse;
        }

        th, td{
            border:1px solid;
            padding:8px;
            text-align:center;
        }

        #linkInsert, #balikHome{
            display:inline-block;
            padding:10px 20px;
            font-size:20px;
            font-weight:bold;
            text-decoration:none;
            margin:10px auto;
        }

        .tabelKontainer{
            width:90%;
            margin:20px auto;
            padding:20px;
            border:10px solid;
        }

        .linkKontainer{
            width:40%;
            margin:20px auto;
            text-align:center;
        }

        .paging{
            font-size:20px;
            font-weight:bold;
            margin:0 5px;
        }

        img{
            border:2px solid #ddd;
            border-radius:6px;
        }

        /* ======================
           LIGHT THEME
        ====================== */
        body.light{
            background:#f4f6f8;
            color:#000;
        }

        body.light h2{
            color:#333;
        }

        body.light table{
            background:white;
        }

        body.light th{
            background:#f2f2f2;
        }

        body.light .tabelKontainer{
            background:lightblue;
            border-color:#333;
        }

        body.light #linkInsert,
        body.light #balikHome{
            background:#2c3e50;
            color:white;
        }

        body.light .paging{
            color:#2c3e50;
        }

        /* ======================
           DARK THEME
        ====================== */
        body.dark{
            background:#1e1e1e;
            color:#eee;
        }

        body.dark h2{
            color:white;
        }

        body.dark table{
            background:#2a2a2a;
        }

        body.dark th{
            background:#333;
        }

        body.dark td{
            background:#2a2a2a;
        }

        body.dark .tabelKontainer{
            background:#2a2a2a;
            border-color:#555;
        }

        body.dark #linkInsert,
        body.dark #balikHome{
            background:#3a3a3a;
            color:white;
        }

        body.dark .paging{
            color:#ddd;
        }

        @media (max-width:768px){
            table, thead, tbody, th, td, tr{
                display:block;
                width:90%;
                margin:0 auto;
            }

            tr{
                margin-bottom:15px;
                padding:15px;
            }

            #linkInsert, #balikHome{
                width:90%;
            }

            .linkKontainer{
                width:90%;
            }
        }

        @media (max-width:480px){
            h2{ font-size:24px; }
        }
    </style>
</head>

<body class="<?= $themeClass ?>">

<div class='tabelKontainer'>
<h2><b>Kelola Mahasiswa</b></h2>

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
$PER_PAGE = 3;
$mahasiswa = new mahasiswa();
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$cari_persen = "%" . $cari . "%";
$offset = isset($_GET['start']) ? (int)$_GET['start'] : 0;

$res = $mahasiswa->getMahasiswa($cari_persen, $offset, $PER_PAGE);
while($row = $res->fetch_assoc()){
    echo "<tr>";
    echo "<td><img src='../image_mahasiswa/".$row['nrp'].".".$row['foto_extention']."' width='100'></td>";
    echo "<td>".$row['nrp']."</td>";
    echo "<td>".$row['nama']."</td>";
    echo "<td>".$row['gender']."</td>";
    echo "<td>".$row['tanggal_lahir']."</td>";
    echo "<td>".$row['angkatan']."</td>";
    echo "<td><a href='admin_edit_mahasiswa.php?nrp=".$row['nrp']."'>Edit</a></td>";
    echo "<td><a href='admin_delete_mahasiswa.php?nrp=".$row['nrp']."'>Delete</a></td>";
    echo "</tr>";
}
?>
</tbody>
</table>
</div>

<div style="text-align:center;">
<p>
<?php
$res = $mahasiswa->getMahasiswa($cari_persen);
$total_data = $res->num_rows;
$max_page = ceil($total_data / $PER_PAGE);
$current_page = floor($offset / $PER_PAGE) + 1;

if ($current_page > 1){
    $prev = $offset - $PER_PAGE;
    echo "<a class='paging' href='?start=$prev&cari=$cari'>Sebelumnya</a>";
}

for($page=1;$page<=$max_page;$page++){
    $offs = ($page-1)*$PER_PAGE;
    if($page==$current_page){
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
<a id='linkInsert' href='admin_insert_mahasiswa.php'>Tambah Mahasiswa</a>
</div>

<div class='linkKontainer'>
<a id='balikHome' href='admin_home.php'>Kembali ke home</a>
</div>

</body>
</html>
