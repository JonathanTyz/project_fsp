<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$themeClass = '';
if (isset($_SESSION['theme']) && $_SESSION['theme'] === 'dark') {
    $themeClass = 'dark';
}
