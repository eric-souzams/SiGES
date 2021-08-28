<?php

loadModel('Login');

session_start();

$exception = null;

if(count($_POST) > 0) {
    $login = new Login([
        'email' => $_POST['email'],
        'password' => $_POST['password']
    ]);

    try{
        $user = $login->checkLogin();
        $_SESSION['USER'] = $user;
        header('location: day_records.php');
    } catch(AppException $e) {
        $exception = $e;
    }
}

loadView('login', $_POST + ['exception' => $exception]);