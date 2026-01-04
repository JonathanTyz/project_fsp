<?php
session_start();

/* toggle theme */
if (!isset($_SESSION['theme']) || $_SESSION['theme'] === 'light') {
    $_SESSION['theme'] = 'dark';
} else {
    $_SESSION['theme'] = 'light';
}

/* kembali ke halaman sebelumnya */
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
