<?php

$errors = [];

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
} elseif (isset($exception)) {
    $message = [
        'type' => 'error',
        'message' => $exception->getMessage()
    ];

    if (get_class($exception) === 'ValidationException') {
        $errors = $exception->getErrors();
    }
}


$alertType = '';
if (isset($message) && $message['type'] === 'error') {
    $alertType = 'danger';
} else {
    $alertType = 'success';
}
?>

<?php if (isset($message)) : ?>
    <div class="alert alert-<?= $alertType ?> alert-dismissible fade show" role="alert">
        <?= $message['message'] ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>