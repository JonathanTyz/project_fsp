<?php
session_start();
require_once '../class/group.php';
require_once '../css/theme_session.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $idgrup = (int)$_GET['id'];
} elseif (isset($_POST['idgrup'])) {
    $idgrup = (int)$_POST['idgrup'];
} else {
    header("Location: dosen_home.php");
    exit();
}

$group = new group();
$detail = $group->getDetailGroup($idgrup);
$result_mahasiswa = $group->getGroupMembersMahasiswa($idgrup);
$mahasiswa_search = $group->getMahasiswaNotInGroup($idgrup, $_SESSION['user']['username']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Member Mahasiswa Group</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/theme.css">

<style>
body { font-family: 'Times New Roman', serif; margin: 0; }
h2,h3 { text-align: center; }
h2 { margin-top: 30px; font-size: 36px; }
h3 { margin-top: 40px; font-size: 28px; }

.center { text-align: center; margin-top: 15px; }

/* BUTTON mengikuti theme */
.button {
    padding: 10px 18px;
    font-weight: bold;
    border: none;
    border-radius: 6px;
    margin: 5px;
    cursor: pointer;
}

/* Info group */
.informasiGrup {
    padding: 25px 30px;
    width: 450px;
    max-width: 95%;
    margin: 30px auto;
    border: 4px solid;
}

/* Tabel */
table {
    width: 90%;
    margin: 20px auto;
    border-collapse: collapse;
    text-align: center;
    border: 4px solid;
}
th, td {
    border: 1px solid;
    padding: 10px;
}
img { max-width: 100px; border-radius: 6px; }

.search-box {
    width: 300px;
    padding: 6px;
    margin: 10px auto 20px;
    display: block;
}

.empty { text-align: center; font-style: italic; }

@media (max-width: 768px) {
    table, thead, tbody, tr, th, td { display: block; width: 95%; }
    thead { display: none; }
    tr { border: 3px solid; margin-bottom: 15px; padding: 15px; }
    td { border: none; padding: 6px 0; display: flex; }
    td::before { content: attr(data-label); font-weight: bold; flex-basis: 40%; }
    .button { width: 90%; display: block; margin: 10px auto; }
}
</style>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>
<body class="<?= $themeClass ?>">

<h2>Member Mahasiswa Group</h2>

<div class="center">
    <form action="dosen_home.php" method="post">
        <button class="button">Kembali ke Home</button>
    </form>
    <form action="dosen_kelola_group.php" method="post">
        <button class="button">Kembali ke Daftar Group</button>
    </form>
</div>

<div class="informasiGrup">
<table>
<tr><th colspan="2">Informasi Group</th></tr>
<tr><td>Nama</td><td><?= htmlspecialchars($detail['nama']); ?></td></tr>
<tr><td>Deskripsi</td><td><?= htmlspecialchars($detail['deskripsi']); ?></td></tr>
<tr><td>Pembuat</td><td><?= htmlspecialchars($detail['username_pembuat']); ?></td></tr>
<tr><td>Tanggal</td><td><?= $detail['tanggal_pembentukan']; ?></td></tr>
<tr><td>Jenis</td><td><?= $detail['jenis']; ?></td></tr>
</table>
</div>

<h3>Daftar Member Mahasiswa</h3>
<table>
<tr>
<th>Username</th>
<th>Nama</th>
<th>NRP</th>
<th>Gender</th>
<th>Angkatan</th>
<th>Foto</th>
<th>Aksi</th>
</tr>

<?php
if ($result_mahasiswa->num_rows == 0) {
    echo "<tr><td colspan='7' class='empty'>Tidak ada mahasiswa</td></tr>";
} else {
    while ($row = $result_mahasiswa->fetch_assoc()) {
        echo "<tr>
            <td data-label='Username'>{$row['username']}</td>
            <td data-label='Nama'>{$row['nama']}</td>
            <td data-label='NRP'>{$row['nrp']}</td>
            <td data-label='Gender'>{$row['gender']}</td>
            <td data-label='Angkatan'>{$row['angkatan']}</td>
            <td><img src='../image_mahasiswa/{$row['nrp']}.{$row['foto_extention']}'></td>
            <td>
                <form action='dosen_delete_member_proses.php' method='post'>
                    <input type='hidden' name='idgrup' value='{$idgrup}'>
                    <input type='hidden' name='username' value='{$row['username']}'>
                    <input type='hidden' name='type' value='mahasiswa'>
                    <button class='button'>Hapus</button>
                </form>
            </td>
        </tr>";
    }
}
?>
</table>

<h3>Tambah Mahasiswa ke Group</h3>
<input type="text" id="searchMahasiswa" class="search-box" placeholder="Cari Username / Nama / NRP">

<table id="tabelMahasiswa">
<tr>
<th>Username</th>
<th>Nama</th>
<th>NRP</th>
<th>Foto</th>
<th>Aksi</th>
</tr>

<?php
if ($mahasiswa_search->num_rows == 0) {
    echo "<tr><td colspan='5' class='empty'>Tidak ada data mahasiswa</td></tr>";
} else {
    while ($m = $mahasiswa_search->fetch_assoc()) {
        echo "<tr>
            <td data-label='Username'>{$m['username']}</td>
            <td data-label='Nama'>{$m['nama']}</td>
            <td data-label='NRP'>{$m['nrp']}</td>
            <td><img src='../image_mahasiswa/{$m['nrp']}.{$m['foto_extention']}'></td>
            <td>
                <form action='dosen_insert_member_proses.php' method='post'>
                    <input type='hidden' name='idgrup' value='{$idgrup}'>
                    <input type='hidden' name='username' value='{$m['username']}'>
                    <input type='hidden' name='type' value='mahasiswa'>
                    <button class='button'>Tambah</button>
                </form>
            </td>
        </tr>";
    }
}
?>
</table>

<script>
$("#searchMahasiswa").on("keyup", function () {
    let value = $(this).val().toLowerCase();
    $("#tabelMahasiswa tr").filter(function (i) {
        if (i === 0) return true;
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
});
</script>

</body>
</html>
