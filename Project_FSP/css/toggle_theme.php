<?php
session_start();

if (!isset($_SESSION['theme']) || $_SESSION['theme'] === 'light') {
    $_SESSION['theme'] = 'dark';
} else {
    $_SESSION['theme'] = 'light';
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
