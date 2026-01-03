<?php
session_start();
require_once '../class/thread.php';
require_once '../class/group.php';
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
<html>
<head>
<title>Chat Thread</title>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>

<style>
body{
    font-family: Arial, sans-serif;
    background:#eef1f5;
    margin:0;
    padding:20px;
}

.container{
    max-width:700px;
    margin:auto;
    background:white;
    padding:20px;
    border-radius:6px;
}

a{
    text-decoration:none;
    color:#3498db;
    font-weight:bold;
}

h3{
    margin-bottom:5px;
}

.status{
    margin-bottom:15px;
}

.chat-box{ 
    min-height: 60vh;
    max-height: 70vh;  
    display:flex;
    flex-direction:column;
    overflow-y:auto;
    background:#f9f9f9;
    border:1px solid #ddd;
    padding:10px;
    margin-bottom:10px;
}

.chat{
    max-width:75%;
    padding:8px 12px;
    margin-bottom:10px;
    font-size:14px;
    border-radius:8px;
}

.chat-mine{
    background:#dcf8c6;
}

.chat-other{
    background:#ffffff; 
}

.name{
    font-weight:bold;
    font-size:13px;
    margin-bottom:2px;
    color:#2c3e50;
}

.time{
    font-size:11px;
    color:#888;
    text-align:right;
    margin-top:4px;
}

textarea{
    width:100%;
    height:70px;
    padding:8px;
    border:1px solid #ccc;
    margin-bottom:8px;
}

button{
    padding:10px 16px;
    background:#3498db;
    color:white;
    border:none;
    width:100%;
}

button:hover{
    background:#2980b9;
}

.closed{
    color:red;
    font-weight:bold;
    margin-bottom:10px;
}


@media (max-width: 500px){

    body{
        padding:10px;
    }

    .container{
        padding:15px;
        margin:20px auto;
        width: 95%;
        height: auto;
    }

    h3{
        font-size:18px;
    }

    .chat-box{
        height:55px; 
    }

    .chat{
        max-width:100%;
        font-size:13px;
    }

    textarea{
        height:60px;
        font-size:14px;
    }

    button{
        font-size:14px;
    }
}
</style>

</head>

<body>

<?php if ($cekGrup) { ?>
    <a href="dosen_kelola_group.php" class="kembali">← Kembali</a>
<?php }
else { 
    ?>
    <a href="dosen_group_diikuti.php" class="kembali">← Kembali</a>
<?php } 
?>

<div class="container">
    <form>
        <a href="dosen_thread.php?idgrup=<?= $idgrup ?>" class="kembali">← Kembali ke Thread</a>
    </form>

    <h3>Thread oleh <?= $thread['username_pembuat'] ?></h3>
    <p class="status">Status: <b><?= $thread['status'] ?></b></p>

    <?php
    if ($thread['status'] === 'Close') {
        echo '<p class="closed">Thread sudah ditutup</p>';
    }
    ?>

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
            let bubbleClass = (c.username_pembuat === myUsername) ? "chat-mine" : "chat-other";

            $("#chatBox").append(
                "<div class='chat "+bubbleClass+"'>" +
                    "<div class='name'>"+c.nama_penulis+"</div>" +
                    "<div>"+c.isi+"</div>" +
                    "<div class='time'>"+c.tanggal_pembuatan+"</div>" +
                "</div>"
            );
        });


    }, "json");
}

loadChat();
setInterval(loadChat, 2000);

$("#btnKirim").click(function(){
    var pesan = $("#pesan").val();
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
