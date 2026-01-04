<?php
session_start();
require_once '../class/thread.php';
require_once '../class/group.php';
require_once '../css/theme_session.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$idthread = (int)$_POST['idthread'];
$idgrup   = (int)$_POST['idgrup'];

$threadObj = new Thread();
$thread = $threadObj->getThread($idthread);

$grup = new Group();
$username = $_SESSION['user']['username'];
$cekGrup = $grup->checkOwnGroup($username, $idgrup);

if (!$thread) die("Thread tidak ditemukan");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Chat Thread</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="../css/theme.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>

<style>
body{
    font-family: Arial, sans-serif;
    margin:0;
    padding:20px;
    background-color: #f4f6f8;
}

.container{
    max-width:700px;
    margin:auto;
    padding:20px;
    border-radius:8px;
    background:white;
    border:1px solid #ccc;
}

.kembali{
    display:inline-block;
    margin-bottom:10px;
    font-weight:bold;
    text-decoration:none;
    color:#1E40AF;
}

.kembali:hover{
    text-decoration:underline;
}

h3{ margin-bottom:5px; color:#2c3e50; }

.status{ margin-bottom:15px; }

.chat-box{ 
    min-height: 60vh;
    max-height: 70vh;  
    display:flex;
    flex-direction:column;
    overflow-y:auto;
    border:1px solid #ccc;
    padding:10px;
    margin-bottom:10px;
    border-radius:6px;
    background-color: #f9fafb;
}

.chat{
    max-width:75%;
    padding:8px 12px;
    margin-bottom:10px;
    font-size:14px;
    border-radius:8px;
}

.chat-mine{
    align-self:flex-end;
    background-color: #1E40AF;
    color:white;
}

.chat-other{
    align-self:flex-start;
    background-color: #e5e7eb;
    color:#111;
}

.name{
    font-weight:bold;
    font-size:13px;
    margin-bottom:2px;
}

.time{
    font-size:11px;
    text-align:right;
    margin-top:4px;
    color:#555;
}

textarea{
    width:100%;
    height:70px;
    padding:8px;
    margin-bottom:8px;
    border-radius:6px;
    border:1px solid #ccc;
    resize:none;
}

button{
    padding:10px 16px;
    border:none;
    width:100%;
    font-weight:bold;
    border-radius:6px;
    color:white;
    background-color:#1E40AF;
    cursor:pointer;
    transition: background-color 0.2s;
}

button:hover{
    background-color:#1E3A8A;
}

.closed{
    font-weight:bold;
    margin-bottom:10px;
    color:red;
}

@media (max-width: 500px){
    body{ padding:10px; }
    .container{ padding:15px; }
    .chat{ max-width:100%; font-size:13px; }
    textarea{ height:60px; }
}
</style>
</head>

<body class="<?= $themeClass ?>">

<?php if ($cekGrup) { ?>
    <a href="dosen_kelola_group.php" class="kembali">← Kembali</a>
<?php } else { ?>
    <a href="dosen_group_diikuti.php" class="kembali">← Kembali</a>
<?php } ?>

<div class="container">

    <a href="dosen_thread.php?idgrup=<?= $idgrup ?>" class="kembali">
        ← Kembali ke Thread
    </a>

    <h3>Thread oleh <?= htmlspecialchars($thread['username_pembuat']) ?></h3>
    <p class="status">Status: <b><?= $thread['status'] ?></b></p>

    <?php if ($thread['status'] === 'Close') { ?>
        <p class="closed">Thread sudah ditutup</p>
    <?php } ?>

    <div class="chat-box" id="chatBox"></div>

    <?php if ($thread['status'] === 'Open') { ?>
        <textarea id="pesan" placeholder="Tulis pesan..."></textarea>
        <button id="btnKirim">Kirim</button>
    <?php } ?>

</div>

<script>
const myUsername = "<?= $_SESSION['user']['username'] ?>";

function loadChat(){
    $.get("dosen_ajax_get_chat.php", { idthread: <?= $idthread ?> }, function(data){
        $("#chatBox").html("");
        data.forEach(function(c){
            let bubbleClass = (c.username_pembuat === myUsername)
                ? "chat chat-mine"
                : "chat chat-other";

            $("#chatBox").append(
                "<div class='"+bubbleClass+"'>" +
                    "<div class='name'>"+c.nama_penulis+"</div>" +
                    "<div>"+c.isi+"</div>" +
                    "<div class='time'>"+c.tanggal_pembuatan+"</div>" +
                "</div>"
            );
        });
        $("#chatBox").scrollTop($("#chatBox")[0].scrollHeight);
    }, "json");
}

loadChat();
setInterval(loadChat, 2000);

$("#btnKirim").click(function(){
    const pesan = $("#pesan").val();
    if(pesan === "") return;

    $.post("dosen_send_chat.php", {
        idthread: <?= $idthread ?>,
        idgrup: <?= $idgrup ?>,
        pesan: pesan
    }, function(){
        $("#pesan").val("");
        loadChat();
    });
});
</script>

</body>
</html>
