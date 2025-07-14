<?php

session_start();

$loginError = '';
$loggedInUser = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $loginError = 'Username and password are required';
        return;
    }

    $file = 'data.json';

    if (!file_exists($file)) {
        $loginError = 'No registered users';
        return;
    }

    $jsonContent = file_get_contents($file);
    $users = json_decode($jsonContent, true);

    foreach ($users as $user) {
        if ($user['username'] === $username && password_verify($password, $user['password'])) {
            $loggedInUser = $user;
            $_SESSION['user'] = $username;
            break;
        }
    }

    if (!$loggedInUser) {
        $loginError = 'Invalid username or password';
    }
}
