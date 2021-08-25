<?php

if(isset($_GET['password_validation']) && $_GET['password_validation'] == 'true') {
    $message = [
        'type' => 'error',
        'message' => 'Usuario ou senha invalidos'
    ];
}

if(isset($_GET['email_validation']) && $_GET['email_validation'] == 'true') {
    $message = [
        'type' => 'error',
        'message' => 'Usuario ou senha invalidos'
    ];
}

if(isset($_GET['userNotActive']) && $_GET['userNotActive'] == 'true') {
    $message = [
        'type' => 'error',
        'message' => 'Este usuario foi desligado da empresa'
    ];
}

$alertType = '';
if(isset($message) && $message['type'] === 'error') {
    $alertType = 'danger';
} else {
    $alertType = 'success';
}
?>

<?php if(isset($message)): ?>
    <div class="alert alert-<?= $alertType ?>" role="alert">
        <?= $message['message'] ?>
    </div>
<?php endif ?>