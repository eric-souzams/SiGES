<?php

require_once(dirname(__FILE__, 2) . '/src/config/config.php');
require_once(dirname(__FILE__, 2) . '/src/models/User.php');

$payload = [
    'name' => 'Lucas Pinto',
    'email' => 'lucas.pinto@gmail.com'
];

$user = new User();

$result = $user->findAll();

foreach($result as $user) {
    print_r($user);
    echo '<br>';
    echo '<br>';
}