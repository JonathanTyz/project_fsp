    <?php
    session_start();
    require_once 'class/group.php';

    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit();
    }

    $group = new group();
    $PER_PAGE = 3;
    $offset = isset($_GET['start']) ? (int)$_GET['start'] : 0;
    $res = $group->getAllGroup($_SESSION['user']['username'], $offset, $PER_PAGE);  


    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Home</title>
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
            .paging{
                font-size: 20px;
                font-weight: bold;
            }
            .isi{
                background-color: white;
                padding: 30px 40px;
                text-align: center;
                width: 400px;
                margin: 30px auto;
                border: 10px solid #333;
            }
        </style>
    </head>
    <body>

    <h2>Kelola Group</h2>

    <table>
        <thead>
            <tr>
                <th>Nama Pembuat</th>
                <th>Nama Grup</th>
                <th>Deskripsi Grup</th>
                <th>Tanggal Dibentuk</th>
                <th>Jenis</th>
                <th>Kode Pendaftaran</th>
                <th colspan="2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while ($row = $res->fetch_assoc()) { 
                echo "<tr>";
                echo "<td>{$row['username_pembuat']}</td>";
                echo "<td>{$row['nama']}</td>";
                echo "<td>{$row['deskripsi']}</td>";
                echo "<td>{$row['tanggal_pembentukan']}</td>";
                echo "<td>{$row['jenis']}</td>";
                echo "<td>{$row['kode_pendaftaran']}</td>";
                
                echo "<td><form action ='dosen_detail_group.php' method='post'>
                    <input type='hidden' name='idgrup' value='{$row['idgrup']}'>
                    <button type='submit'>Lihat Detail</button> 
                </form></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <p style="text-align:center;">
    <?php
    $res_total = $group->getAllGroup($_SESSION['user']['username']);
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

    <div class="isi">
        <h2>Welcome <?php echo $_SESSION['user']['username']; ?></h2>
        <h4>Role: Dosen</h4>

        <button><a href="dosen_insert_group.php">Insert Group</a></button><br><br>
        <button><a href="change_password.php">Change Password</a></button><br><br>
        <button><a href="logout.php">EXIT</a></button><br>
    </div>

    </body>
    </html>
