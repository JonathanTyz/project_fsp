<?php
session_start();
require_once '../class/group.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$group = new group();

$PER_PAGE = 3;
$offset = isset($_GET['start']) ? (int)$_GET['start'] : 0;

$result_grup = $group->getAllMadeGroup($_SESSION['user']['username'], $offset, $PER_PAGE);
$detail_grup = $group->getDetailGroup($_SESSION['user']['username']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Grup Saya</title>
    <style>
    body{
    font-family: 'Times New Roman', Times, serif;
    margin: 0;
    background-color: #f4f6f8;
    }

    h2{
        text-align: center;
        margin: 30px 0 10px;
        color: #2c3e50;
        font-size: 34px;
    }

    .container-kembali{
        width: 90%;
        margin: auto;
    }

    .kembali{
        display: inline-block;
        padding: 8px 14px;
        background-color: #6c757d;
        color: white;
        font-weight: bold;
        text-decoration: none;
        margin-bottom: 10px;
    }

    table{
        width: 90%;
        margin: 15px auto;
        background: white;
    }

    th, td{
        border: 1px solid #333;
        padding: 10px;
        text-align: center;
    }

    th{
        background-color: #e9ecef;
    }

    button{
        padding: 6px 12px;
        font-weight: bold;
        border: none;
        background-color: #2c3e50;
        color: white;
    }

    .paging{
        text-align: center;
        margin: 25px;
    }

    .paging a{
        margin: 0 6px;
        font-weight: bold;
        color: #2c3e50;
        text-decoration: none;
    }

    .kosong{
        text-align: center;
        padding: 20px;
        color: #555;
    }

    .insert-kode{
        text-align: center;
        padding: 20px;
        color: #262626ff;
        border: 5px solid #2c3e50;
        width: 400px;
        margin: 30px auto;
    }

    .insert-group {
        text-align: center;
        margin-bottom: 20px;
        margin-top: 20px;
        padding: 10px 18px; 
    }

    @media (max-width: 1024px){
        table, thead, tbody, tr, th, td {
            display: block;
            width: 95%;
            margin: 0 auto;
        }

        tr {
            background: white;
            border: 2px solid #2c3e50;
            margin-bottom: 15px;
            padding: 15px;
        }

        td {
            text-align: left;
            border: none;
            padding: 8px 10px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }

        td::before {
            content: attr(data-label);
            font-weight: bold;
            width: 45%;
            color: #2c3e50;
        }

        td button, td form, td a {
            width: 100%;
            margin-top: 5px;
        }
    }

    @media (max-width: 480px){
        h2{ font-size: 24px; }
        button{
            padding: 8px;
            font-size: 14px;
        }
        td::before{
            width: 100%;
            margin-bottom: 4px;
        }
        td{
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
        </style>
</head>
<body>

<h2>Grup Anda</h2>

    <div class="container-kembali">
        <a href="dosen_home.php" class="kembali">← Kembali</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama Grup</th>
                <th>Deskripsi</th>
                <th>Pembuat</th>
                <th>Tanggal Dibentuk</th>
                <th>Jenis</th>
                <th>Kelola Event</th>
                <th>Thread</th>
                <th colspan = '3'>Kelola Member</th>
                <th>Edit</th>
                <th>Hapus</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_grup->num_rows == 0) {
                echo "<tr><td colspan='11'>Anda belum Punya grup.</td></tr>";
            } else {
                while ($row = $result_grup->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td data-label='Nama Grup'>{$row['nama']}</td>";
                    echo "<td data-label='Deskripsi'>{$row['deskripsi']}</td>";
                    echo "<td data-label='Pembuat'>{$row['username_pembuat']}</td>";
                    echo "<td data-label='Tanggal Dibentuk'>{$row['tanggal_pembentukan']}</td>";
                    echo "<td data-label='Jenis'>{$row['jenis']}</td>";
                    // LIHAT DETAIL GROUP
                    echo "<td>
                        <form action='dosen_kelola_event.php' method='post'>
                            <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                            <button type='submit'>Event</button>
                        </form>
                    </td>";
                    
                    // THREAD
                    echo "<td>
                        <form action='dosen_thread.php' method='get'>
                            <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                            <button type='submit'>Thread</button>
                        </form>
                    </td>";
                    
                    // LIHAT MEMBER
                    echo "<td>
                        <form action='dosen_view_member.php' method='post'>
                            <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                            <button type='submit'>Lihat Semua Member</button>
                        </form>
                    </td>";

                    echo "<td>
                        <form action='dosen_view_member_mahasiswa.php' method='post'>
                            <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                            <button type='submit'>Tambah Member mahasiswa</button>
                        </form>
                    </td>";

                    echo "<td>
                        <form action='dosen_view_member_dosen.php' method='post'>
                            <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                            <button type='submit'>Tambah Member Dosen</button>
                        </form>
                    </td>";

                    //EDIT GROUP
                    echo "<td>
                        <form action='dosen_edit_group.php' method='post'>
                            <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                            <input type='hidden' name='nama' value='".$row['nama']. "'>
                            <input type='hidden' name='jenis' value='{$row['jenis']}'>
                            <input type='hidden' name='deskripsi' value='".$row['deskripsi']. "'>
                            <button type='submit'>Edit Group</button>
                        </form>
                    </td>";

                    //HAPUS GROUP
                    echo "<td>
                        <form action='dosen_delete_group.php' method='post'>
                            <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                            <button type='submit'>Hapus Group</button>
                        </form>
                    </td>";

                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>


    <p style="text-align:center;">
    <?php
    $res_total = $group->getAllGroupByMember($_SESSION['user']['username']);
    $total_data = $res_total->num_rows;
    $max_page = ceil($total_data / $PER_PAGE);
    $current_page = floor($offset / $PER_PAGE) + 1;

    if ($current_page > 1) {
        $prev = $offset - $PER_PAGE;
        echo "<a class='paging' href='?start=$prev'>Sebelumnya</a> ";
    }

    for ($page = 1; $page <= $max_page; $page++) {
        $offs = ($page - 1) * $PER_PAGE;
        if ($page == $current_page) {
            echo "<b class='paging'>$page</b> ";
        } else {
            echo "<a class='paging' href='?start=$offs'>$page</a> ";
        }
    }

    if ($current_page < $max_page) {
        $next = $offset + $PER_PAGE;
        echo "<a class='paging' href='?start=$next'>Selanjutnya</a>";
    }
    ?>
    </p>
    <div class = "insert-group">
        <a href="dosen_insert_group.php">
            <button>
                + Buat Group Baru
            </button>
        </a>
    </div>
</body>
</html>
