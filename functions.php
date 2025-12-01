<?php
require_once __DIR__ . '/config.php';

function is_admin_logged_in() {
    return !empty($_SESSION['user_id']);
}

function require_admin() {
    if (!is_admin_logged_in()) {
        header('Location: /admin/login.php');
        exit;
    }
}   
