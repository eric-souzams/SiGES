<?php

session_start();
requireValidSession(true);

$exception = null;
$userData = [];

if (count($_POST) === 0 && isset($_GET['update'])) {
    $mUser = new User();
    $userData = $mUser->find($_GET['update']);
    $userData['password'] = null;
} elseif (count($_POST) > 0) {
    try {
        $loadUser = new User();
        $loadUser->loadData($_POST);

        print_r($loadUser->getValues());
        //exit();
        
        if ($loadUser->getValue('id')) {
            $loadUser->update();
            addSuccessMessage('Usuário alterado com sucesso!');
            header('location: users.php');
            exit();
        } else {
            unset($_POST['id']);
            $loadUser = new User();
            $loadUser->loadData($_POST);
            $loadUser->insert();
            addSuccessMessage('Usuário cadastrado com sucesso!');
        }
        $_POST = [];
    } catch (Exception $e) {
        $exception = $e;
    } finally {
        $userData = $_POST;
    }
}

loadTemplateView('save_user', $userData + [
    'exception' => $exception
]);
