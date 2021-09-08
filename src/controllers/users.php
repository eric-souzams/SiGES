<?php

session_start();
requireValidSession(true);

$exception = null;

if(isset($_GET['delete'])) {
    try {
        $mUser = new User();
        $mUser->deleteById($_GET['delete']);
        addSuccessMessage('Usuário excluido com sucesso!');
    } catch (Exception $e) {
        if(stripos($e->getMessage(), 'FOREIGN KEY')) {
            addErrorMessage('Não foi possível excluir o usuário com registros de ponto.');
        } else {
            $exception = $e;
        }
    }
}

$uModel = new User();

$users = $uModel->findAllUsers();

loadTemplateView('users', [
    'users' => $users,
    'exception' => $exception
]);