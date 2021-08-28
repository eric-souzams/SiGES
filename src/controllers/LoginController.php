<?php

loadModel('Login');
$exception = null;

if(count($_POST) > 0) {
    $login = new Login([
        'email' => $_POST['email'],
        'password' => $_POST['password']
    ]);

    try{
        $user = $login->checkLogin();
        echo 'Bem-vindo ' . $user['name'];
    } catch(AppException $e) {
        $exception = $e;
    }
}

loadView('login', $_POST + ['exception' => $exception]);