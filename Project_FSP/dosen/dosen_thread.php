<?php
session_start();
require_once '../class/thread.php';
require_once '../class/group.php';
require_once '../css/theme_session.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['user']['username'];
$idgrup   = (int)($_POST['idgrup'] ?? $_GET['idgrup']);

$threadObj = new Thread();
$threads   = $threadObj->getThreads($idgrup);

$grup = new Group();
$cekGrup = $grup->checkOwnGroup($username, $idgrup);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Thread Grup</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="../css/theme.css">

<style>
body{
    font-family:'Times New Roman', serif;
    margin:0;
    padding:20px;
}

/* ======================
   TITLE
====================== */
h2{
    text-align:center;
}

/* ======================
   TABLE LAYOUT
====================== */
table{
    width:90%;
    margin:20px auto;
    border-collapse:collapse;
}

th, td{
    padding:10px;
    text-align:center;
    border:1px solid;
}

/* ======================
   BUTTON BASE
====================== */
.button,
.button-disabled{
    padding:8px 15px;
    margin:4px;
    font-weight:bold;
    border-radius:6px;
    border:1px solid;
}

.button{
    cursor:pointer;
}

.button-disabled{
    cursor:not-allowed;
}

/* ======================
   LINK BACK
====================== */
.kembali{
    display:inline-block;
    padding:8px 14px;
    font-weight:bold;
    text-decoration:none;
    margin-bottom:10px;
}

/* ======================
   CENTER
====================== */
.center{
    text-align:center;
}

/* ======================
   LIGHT THEME
====================== */
body.light{
    background:#f4f6f8;
    color:#000;
}

body.light h2{
    color:#2c3e50;
}

body.light table{
    background:#ffffff;
}

body.light th{
    background:#e5e7eb;
}

body.light td{
    background:#ffffff;
}

body.light .button{
    background:#2c3e50;
    color:white;
    border-color:#2c3e50;
}

body.light .button:hover{
    background:#1f2d3a;
}

body.light .button-disabled{
    background:#9ca3af;
    color:#f3f4f6;
    border-color:#9ca3af;
}

body.light .kembali{
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

body.dark .button{
    background:#3a3a3a;
    color:white;
    border-color:#555;
}

body.dark .button:hover{
    background:#555;
}

body.dark .button-disabled{
    background:#555;
    color:#aaa;
    border-color:#555;
}

body.dark .kembali{
    color:#ddd;
}

/* ======================
   RESPONSIVE
====================== */
@media(max-width:500px){
    table, thead, tbody, tr, th, td{
        display:block;
        width:100%;
    }

    thead{ display:none; }

    tr{
        margin-bottom:15px;
        padding:10px;
        border-radius:8px;
    }

    body.light tr{
        background:#ffffff;
        border:1px solid #d1d5db;
    }

    body.dark tr{
        background:#2a2a2a;
        border:1px solid #444;
    }

    td{
        border:none;
        text-align:left;
    }

    td::before{
        content:attr(data-label);
        font-weight:bold;
        display:block;
        margin-bottom:4px;
    }

    .button,
    .button-disabled{
        width:100%;
        margin-top:6px;
    }
}

</style>
</head>

<body class="<?= $themeClass ?>">

<?php if ($cekGrup) { ?>
    <a href="dosen_kelola_group.php" class="kembali">← Kembali</a>
<?php } else { ?>
    <a href="dosen_group_diikuti.php" class="kembali">← Kembali</a>
<?php } ?>

<h2>Thread Grup</h2>

<div class="center">
    <form action="dosen_create_thread.php" method="post">
        <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
        <button class="button" type="submit">+ Buat Thread Baru</button>
    </form>
</div>

<table>
    <tr>
        <th>Pembuat</th>
        <th>Tanggal</th>
        <th>Status</th>
        <th colspan="3">Aksi</th>
    </tr>

<?php while ($row = $threads->fetch_assoc()):
    $isOwner = ($row['username_pembuat'] === $username);
?>
    <tr>
        <td data-label="Pembuat"><?= htmlspecialchars($row['username_pembuat']) ?></td>
        <td data-label="Tanggal"><?= $row['tanggal_pembuatan'] ?></td>
        <td data-label="Status"><?= $row['status'] ?></td>

        <!-- VIEW CHAT -->
        <td data-label="View Chat">
            <form action="dosen_view_chat.php" method="post">
                <input type="hidden" name="idthread" value="<?= $row['idthread'] ?>">
                <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
                <input type="hidden" name="username" value="<?= $username ?>">
                <button class="button" type="submit">View Chat</button>
            </form>
        </td>

        <!-- DELETE -->
        <td data-label="Delete">
        <?php if ($isOwner): ?>
            <form action="dosen_delete_thread.php" method="post">
                <input type="hidden" name="idthread" value="<?= $row['idthread'] ?>">
                <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
                <button class="button" type="submit">Delete</button>
            </form>
        <?php else: ?>
            <button class="button-disabled" disabled>Delete</button>
        <?php endif; ?>
        </td>

        <!-- EDIT -->
        <td data-label="Edit">
        <?php if ($isOwner): ?>
            <form action="dosen_edit_thread.php" method="post">
                <input type="hidden" name="idthread" value="<?= $row['idthread'] ?>">
                <input type="hidden" name="idgrup" value="<?= $idgrup ?>">
                <input type="hidden" name="status" value="<?= $row['status'] ?>">
                <button class="button" type="submit">Edit</button>
            </form>
        <?php else: ?>
            <button class="button-disabled" disabled>Edit</button>
        <?php endif; ?>
        </td>
    </tr>
<?php endwhile; ?>
</table>

</body>
</html>
