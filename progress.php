<?php
session_start();

$key = ini_get('session.upload_progress.prefix').'myForm';
if (!empty($_SESSION[$key]) && $_SESSION[$key]['done'] != 1) {
    $current = $_SESSION[$key]['bytes_processed'];
    $total = $_SESSION[$key]['content_length'];
    echo $_SESSION[$key]['done'];
}
else {
    if ($name = $_SESSION['file_name']) {
        unset($_SESSION['file_name']);
        echo $name;
    }
}