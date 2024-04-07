<?php
session_start();
unset($_SESSION['message']);
require_once 'connect.php';

$login = $_POST['login'];
$password = $_POST['password'];
$check_user = mysqli_query($connect, "SELECT `id`,`name`,`login`,`password_hash`,`password` FROM `user` WHERE `login` = '$login'");

if (mysqli_num_rows($check_user) > 0) {
    $user = $check_user->fetch_assoc();
    if (password_verify($user['password'], $user["password_hash"])) {
        header('Location: ../adminpanel.php');
    } else {
        echo 'Ошибка авторизации';
    }
} else {
    echo 'Ошибка авторизации';
}

