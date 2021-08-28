<?php

function requireValidSession() {
    if(!isset($_SESSION['USER'])) {
        header('location: login.php');
        exit();
    }

    $user = $_SESSION['USER'];
}