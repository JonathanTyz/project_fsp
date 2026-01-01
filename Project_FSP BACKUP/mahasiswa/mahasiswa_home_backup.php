<?php
session_start();
// require_once '../class/group.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

// $group = new group();

// // PAGING
// $PER_PAGE = 3;
// $offset = isset($_GET['start']) ? (int)$_GET['start'] : 0;

// // GROUP YANG DI IKUTI MAHASISWA
// $res = $group->getAllGroupByMember($_SESSION['user']['username'], $offset, $PER_PAGE);
// $result_public = $group->getAllPublicGroups($_SESSION['user']['username'], $offset, $PER_PAGE);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Mahasiswa Home</title>
    <style>
        body{
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
        }
        h2{
            text-align: center;
            margin-top: 30px;
            color: #333;
            font-size: 36px;
            font-weight: bold;
        }
        table {
            width: 90%;
            margin: 20px auto;
            background: white;
            border: 10px solid #333;
        }
        th, td {
            border: 1px solid black; 
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2; 
        }
        .isi{
            background-color: white;
            padding: 30px 40px;
            text-align: center;
            width: 400px;
            margin: 30px auto;
            border: 10px solid #333;
        }
        button{
            padding: 10px;
            margin: 5px;
            font-weight: bold;
        }
        a{
            text-decoration: none;
        }
    </style>
</head>
<body>

<!-- <h2>Group Yang Anda Ikuti</h2>

<table>
    <thead>
        <tr>
            <th>Nama Grup</th>
            <th>Deskripsi</th>
            <th>Pembuat</th>
            <th>Tanggal Dibentuk</th>
            <th>Jenis</th>
            <th colspan="3">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php 
        // while ($row = $res->fetch_assoc()) {
        //     echo "<tr>";
        //     echo "<td>{$row['nama']}</td>";
        //     echo "<td>{$row['deskripsi']}</td>";
        //     echo "<td>{$row['username_pembuat']}</td>";
        //     echo "<td>{$row['tanggal_pembentukan']}</td>";
        //     echo "<td>{$row['jenis']}</td>";

        //     // LIHAT DETAIL GROUP
        //     echo "<td>
        //         <form action='mahasiswa_view_group.php' method='post'>
        //             <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
        //             <button type='submit'>Detail</button>
        //         </form>
        //     </td>";

        //     // LIHAT MEMBER
        //     echo "<td>
        //         <form action='mahasiswa_view_member.php' method='post'>
        //             <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
        //             <button type='submit'>Member</button>
        //         </form>
        //     </td>";

        //     // KELUAR DARI GROUP
        //     echo "<td>
        //         <form action='mahasiswa_keluar_group.php' method='post'>
        //             <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
        //             <button type='submit'>Keluar</button>
        //         </form>
        //     </td>";

        //     echo "</tr>";
        // }
        ?>
    </tbody>
</table>
<h2>Daftar Group Publik</h2>

<table>
<thead>
<tr>
    <th>Nama Grup</th>
    <th>Deskripsi</th>
    <th>Pembuat</th>
    <th>Tanggal Dibentuk</th>
    <th>Jenis</th>
</tr>
</thead>

<tbody>
<?php 
// while ($row = $result_public->fetch_assoc()) {
//     echo "<tr>";
//     echo "<td>{$row['nama']}</td>";
//     echo "<td>{$row['deskripsi']}</td>";
//     echo "<td>{$row['username_pembuat']}</td>";
//     echo "<td>{$row['tanggal_pembentukan']}</td>";
//     echo "<td>{$row['jenis']}</td>";
//     echo "</tr>";
// }
// ?>
// </tbody>
// </table>


// <p style="text-align:center;">
// <?php
// $total_data = $group->countGroupByMember($_SESSION['user']['username']);
// $max_page = ceil($total_data / $PER_PAGE);
// $current_page = floor($offset / $PER_PAGE) + 1;

// if ($current_page > 1) {
//     $prev = $offset - $PER_PAGE;
//     echo "<a href='?start=$prev'>Sebelumnya</a> ";
// }

// for ($page = 1; $page <= $max_page; $page++) {
//     $offs = ($page - 1) * $PER_PAGE;
//     if ($page == $current_page) {
//         echo "<b>$page</b> ";
//     } else {
//         echo "<a href='?start=$offs'>$page</a> ";
//     }
// }

// if ($current_page < $max_page) {
//     $next = $offset + $PER_PAGE;
//     echo "<a href='?start=$next'>Selanjutnya</a>";
// }
?>
</p> -->

<div class="isi">
    <h2>Welcome <?php echo $_SESSION['user']['username']; ?></h2>
    <h4>Role: Mahasiswa</h4>

    <!-- <form action="mahasiswa_join_group.php" method="post">
        <p>Masukkan Kode Pendaftaran:</p>
        <input type="text" name="kode" required>
        <button type="submit">Join Group</button>
    </form> -->

    <button><a href = "mahasiswa_daftar_group_join.php">Lihat grup yang telah anda join</a></button>
    <br>
    <button><a href = "mahasiswa_daftar_group_tersedia.php">Lihat grup yang tersedia</a></button>
    <br>
    <button><a href="../change_password.php">Change Password</a></button><br>
    <button><a href="../logout.php">EXIT</a></button>
</div>

</body>
</html>
