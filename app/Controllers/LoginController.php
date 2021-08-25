<?php

require_once('../Models/User.php');

$user = new User();

if (!isset($_POST['loginMethod'])) {
    header('location:/?error=fail_inject', 403);
    return false;
}

switch ($_POST['loginMethod']) {
    case 'login':
        validateFields();
        $result = checkLogin();

        if($result) {
            header('location:/day_records.php');
        }
        break;
}

function validateFields()
{
    $errors = [false, false];

    if (!$_POST['email']) {
        $errors[0] = true;
    }

    if (!$_POST['password']) {
        $errors[1] = true;
    }

    if ($errors[0] == true || $errors[1] == true) {
        header('location:/?email_validation=' . json_encode($errors[0]) . '&password_validation=' . json_encode($errors[1]));
        die();
    }
}

function checkLogin()
{
    $user = new User();
    $user = $user->findByEmail($_POST['email']);

    if (isset($user['end_date'])) {
        header('location: /?userNotActive=true');
    }

    if ($user) {
        if (password_verify($_POST['password'], $user['password'])) {
            return $user;
        }
    }

    header('location:/?email_validation=true&password_validation=true');
}
