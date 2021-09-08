<?php

function requireValidSession($requireAdmin = false) {
    $user = $_SESSION['USER'];

    if(!isset($_SESSION['USER'])) {
        header('location: login.php');
        exit();
    } elseif ($requireAdmin && !$user['is_admin']) {
        addErrorMessage('Acesso não permitido');
        header('location: day_records.php');
        exit();
    }
}