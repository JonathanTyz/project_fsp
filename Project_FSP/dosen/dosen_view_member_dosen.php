<?php
session_start();
require_once '../class/group.php';
require_once '../css/theme_session.php';

/* =====================
   CEK LOGIN
===================== */
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

/* =====================
   AMBIL ID GROUP
===================== */
if (isset($_GET['id'])) {
    $idgrup = (int)$_GET['id'];
} elseif (isset($_POST['idgrup'])) {
    $idgrup = (int)$_POST['idgrup'];
} else {
    header("Location: dosen_home.php");
    exit();
}

/* =====================
   DATA
===================== */
$group = new group();
$detail = $group->getDetailGroup($idgrup);
$result_dosen = $group->getGroupMembersDosen($idgrup);
$dosen_search = $group->getDosenNotInGroup($idgrup, $_SESSION['user']['username']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Member Dosen Group</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="../css/theme.css">

<style>
body{
    font-family: 'Times New Roman', serif;
    margin: 0;
}

h2{
    text-align: center;
    margin-top: 30px;
    font-size: 36px;
}

h3{
    text-align: center;
    margin-top: 40px;
    font-size: 28px;
}

.center{
    text-align: center;
    margin-top: 15px;
}

/* BUTTON KONSISTEN */
.button{
    padding: 10px 18px;
    font-weight: bold;
    border: none;
    margin: 6px;
    cursor: pointer;
}

/* INFORMASI GROUP */
.informasiGrup{
    padding: 25px 30px;
    width: 450px;
    max-width: 95%;
    margin: 30px auto;
    border: 4px solid;
}

/* TABLE */
table{
    width: 90%;
    margin: 20px auto;
    border-collapse: collapse;
    border: 4px solid;
}

th, td{
    border: 1px solid;
    padding: 10px;
    text-align: center;
}

.empty{
    text-align: center;
    font-style: italic;
}

img{
    max-width: 100px;
    border-radius: 6px;
}

/* SEARCH */
.search-box{
    width: 300px;
    padding: 8px;
    margin: 10px auto 20px;
    display: block;
}

@media (max-width: 768px) {
            table, thead, tbody, tr, th, td {
                display: block;
                width: 95%;
            }

            thead { display: none; }

            tr {
                border: 2px solid #2c3e50;
                margin-bottom: 15px;
                padding: 15px;
                border-radius: 10px;
            }

            td {
                padding: 6px 0;
                display: flex;
                align-items: center;
            }

            td::before {
                content: attr(data-label);
                font-weight: bold;
                flex-basis: 40%;
            }

            .button {
                width: 90%;
                margin: 10px auto;
                display: block;
            }

            .informasiGrup {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            h2 { font-size: 24px; }
            h3 { font-size: 20px; }

            td {
                font-size: 14px;
                flex-direction: column;
                text-align: left;
            }

            td::before {
                width: 100%;
                margin-bottom: 4px;
            }
        }
</style>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>

<body class="<?= $themeClass ?>">

<h2>Member Dosen Group</h2>

<div class="center">
    <form action="dosen_home.php" method="post">
        <button class="button">Kembali ke Home</button>
    </form>

    <form action="dosen_kelola_group.php" method="post">
        <button class="button">Kembali ke Daftar Group</button>
    </form>
</div>

<!-- INFO GROUP -->
<div class="informasiGrup">
<table>
<tr><th colspan="2">Informasi Group</th></tr>
<tr><td>Nama</td><td><?= htmlspecialchars($detail['nama']) ?></td></tr>
<tr><td>Deskripsi</td><td><?= htmlspecialchars($detail['deskripsi']) ?></td></tr>
<tr><td>Pembuat</td><td><?= htmlspecialchars($detail['username_pembuat']) ?></td></tr>
<tr><td>Tanggal</td><td><?= $detail['tanggal_pembentukan'] ?></td></tr>
<tr><td>Jenis</td><td><?= $detail['jenis'] ?></td></tr>
</table>
</div>

<h3>Daftar Member Dosen</h3>
<table>
<tr>
    <th>Username</th>
    <th>Nama</th>
    <th>NPK</th>
    <th>Foto</th>
    <th>Aksi</th>
</tr>

<?php
if ($result_dosen->num_rows == 0) {
    echo "<tr><td colspan='5' class='empty'>Tidak ada dosen</td></tr>";
} else {
    while ($row = $result_dosen->fetch_assoc()) {
        echo "
        <tr>
            <td data-label='Username'>{$row['username']}</td>
            <td data-label='Nama'>{$row['nama']}</td>
            <td data-label='NPK'>{$row['npk']}</td>
            <td data-label='Foto'>
                <img src='../image_dosen/{$row['npk']}.{$row['foto_extension']}'>
            </td>
            <td data-label='Aksi'>
                <form action='dosen_delete_member_proses.php' method='post'>
                    <input type='hidden' name='idgrup' value='{$idgrup}'>
                    <input type='hidden' name='username' value='{$row['username']}'>
                    <input type='hidden' name='type' value='dosen'>
                    <button class='button'>Hapus</button>
                </form>
            </td>
        </tr>";
    }
}
?>
</table>

<h3>Tambah Dosen ke Group</h3>
<input type="text" id="searchDosen" class="search-box"
       placeholder="Cari Username / Nama / NPK">

<table id="tabelDosen">
<tr>
    <th>Username</th>
    <th>Nama</th>
    <th>NPK</th>
    <th>Foto</th>
    <th>Aksi</th>
</tr>

<?php
if ($dosen_search->num_rows == 0) {
    echo "<tr><td colspan='5' class='empty'>Tidak ada data</td></tr>";
} else {
    while ($d = $dosen_search->fetch_assoc()) {
        echo "
        <tr>
            <td data-label='Username'>{$d['username']}</td>
            <td data-label='Nama'>{$d['nama']}</td>
            <td data-label='NPK'>{$d['npk']}</td>
            <td data-label='Foto'>
                <img src='../image_dosen/{$d['npk']}.{$d['foto_extension']}'>
            </td>
            <td data-label='Aksi'>
                <form action='dosen_insert_member_proses.php' method='post'>
                    <input type='hidden' name='idgrup' value='{$idgrup}'>
                    <input type='hidden' name='username' value='{$d['username']}'>
                    <input type='hidden' name='type' value='dosen'>
                    <button class='button'>Tambah</button>
                </form>
            </td>
        </tr>";
    }
}
?>
</table>

<script>
$("#searchDosen").on("keyup", function () {
    let value = $(this).val().toLowerCase();
    $("#tabelDosen tr").filter(function (i) {
        if (i === 0) return true;
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
});
</script>

</body>
</html>
