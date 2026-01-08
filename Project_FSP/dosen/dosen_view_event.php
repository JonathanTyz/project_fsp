<?php
session_start();
require_once '../class/group.php';
require_once '../class/event.php';
require_once '../css/theme_session.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$group_id = isset($_POST['idgrup'])
    ? (int)$_POST['idgrup']
    : (isset($_GET['idgrup']) ? (int)$_GET['idgrup'] : null);

if (!$group_id) {
    header("Location: dosen_group_diikuti.php");
    exit();
}

$group = new Group();
$group_detail = $group->getDetailGroup($group_id);
if (!$group_detail) {
    header("Location: dosen_group_diikuti.php");
    exit();
}

$event = new Event();
$group_events = $event->getEventsGroup($group_id);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Group & Event</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/theme.css">

<style>
body {
    font-family: "Segoe UI", Tahoma, sans-serif;
    margin: 0;
    background-color: #f3f4f6;
}

h2, h3 {
    text-align: center;
    color: #1f2937;
}

h2 {
    margin-top: 30px;
    font-size: 34px;
}

h3 {
    margin-top: 40px;
    font-size: 26px;
}

/* ===== BUTTON ===== */
.btn-group {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin: 25px 0;
    flex-wrap: wrap;
}

.button {
    padding: 12px 22px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 15px;
    color: #fff;
    background-color: #2563eb;
    cursor: pointer;
    transition: 0.2s;
}

.button:hover {
    background-color: #1e40af;
    transform: translateY(-1px);
}

/* ===== CARD ===== */
.card {
    border-radius: 12px;
    padding: 25px;
    width: 500px;
    max-width: 95%;
    margin: 30px auto;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

/* ===== TABLE ===== */
.table-wrap {
    width: 95%;
    max-width: 1100px;
    margin: 30px auto;
}

table {
    width: 100%;
    background: #ffffff;
    border-radius: 10px;
    border-collapse: collapse;
    overflow: hidden;
    box-shadow: 0 6px 18px rgba(0,0,0,0.05);
}

th, td {
    padding: 12px 14px;
    border-bottom: 1px solid #e5e7eb;
    text-align: center;
}

th {
    background-color: #f1f5f9;
    font-weight: 700;
    color: #1f2937;
}

tr:last-child td {
    border-bottom: none;
}


/* ===== IMAGE ===== */
img {
    max-width: 180px;
    border-radius: 8px;
}

/* =====================
           DARK MODE
        ===================== */
        body.dark {
            background-color: #121212;
            color: #f1f1f1;
        }

        body.dark h2,
        body.dark h3 {
            color: #ffffff;
        }

        body.dark .informasiGrup {
            background-color: #1e1e1e;
        }

        body.dark table {
            background-color: #1e1e1e;
        }

        body.dark th {
            background-color: #2a2a2a;
            color: #ffffff;
        }

        body.dark td {
            border-color: #444;
            color: #eeeeee;
        }

        body.dark .button {
            background-color: #3a3a3a;
        }

        body.dark .button:hover {
            background-color: #555;
        }

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    table, thead, tbody, tr, th, td {
        display: block;
        width: 100%;
    }

    thead { display: none; }

    tr {
        margin-bottom: 18px;
        padding: 15px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    td {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding: 8px 0;
        border: none;
        text-align: left;
    }

    td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #374151;
        margin-bottom: 4px;
    }

    img {
        max-width: 100%;
        margin-top: 8px;
    }

    .btn-group {
        flex-direction: column;
        align-items: center;
    }

    .button {
        width: 90%;
    }
}
</style>
</head>

<body class="<?= $themeClass ?>">

<h2>Detail Group</h2>

<div class="btn-group">
    <form action="dosen_home.php" method="post">
        <button class="button" type="submit">Home</button>
    </form>
    <form action="dosen_group_diikuti.php" method="post">
        <button class="button" type="submit">Daftar Group</button>
    </form>
</div>

<div class="card">
    <table>
        <tr>
            <th colspan="2">Informasi Group</th>
        </tr>
        <tr>
            <td>Nama</td>
            <td><?= htmlspecialchars($group_detail['nama']) ?></td>
        </tr>
        <tr>
            <td>Deskripsi</td>
            <td><?= htmlspecialchars($group_detail['deskripsi']) ?></td>
        </tr>
        <tr>
            <td>Pembuat</td>
            <td><?= htmlspecialchars($group_detail['username_pembuat']) ?></td>
        </tr>
        <tr>
            <td>Tanggal Dibentuk</td>
            <td><?= htmlspecialchars($group_detail['tanggal_pembentukan']) ?></td>
        </tr>
        <tr>
            <td>Jenis</td>
            <td><?= htmlspecialchars($group_detail['jenis']) ?></td>
        </tr>
    </table>
</div>

<h3>Daftar Event</h3>

<div class="table-wrap">
<table>
    <tr>
        <th>Judul</th>
        <th>Tanggal</th>
        <th>Keterangan</th>
        <th>Jenis</th>
        <th>Poster</th>
    </tr>

    <?php if (empty($group_events)) : ?>
        <tr>
            <td colspan="5">Belum ada event</td>
        </tr>
    <?php else: ?>
        <?php foreach ($group_events as $events) : ?>
            <tr>
                <td data-label="Judul"><?= htmlspecialchars($events['judul']) ?></td>
                <td data-label="Tanggal"><?= htmlspecialchars($events['tanggal']) ?></td>
                <td data-label="Keterangan"><?= htmlspecialchars($events['keterangan']) ?></td>
                <td data-label="Jenis"><?= htmlspecialchars($events['jenis']) ?></td>
                <td data-label="Poster">
                    <?php
                    if (!empty($events['poster_extension']) &&
                        file_exists("../image_events/".$events['idevent'].".".$events['poster_extension'])) {
                        echo '<img src="../image_events/'.$events['idevent'].'.'.$events['poster_extension'].'" alt="Poster Event">';
                    } else {
                        echo "No poster";
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
</div>

</body>
</html>
