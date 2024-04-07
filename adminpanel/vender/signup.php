<?php
session_start();
require_once 'connect.php';

$full_name = $_POST['full_name'];
$login = $_POST['login'];
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];

if ($password === $password_confirm) {
    $check = $connect->query("SELECT `login` FROM `user` WHERE `login` = '$login'");
    if ($check->num_rows) {
        $_SESSION['message'] = 'Логин существует';
    }
    mysqli_query($connect, "INSERT INTO `user` (`id`, `name`, `password`,`password_hash`, `login`) VALUES (NULL, '$full_name', '$password','" . password_hash($password, 0) . "', '$login')");

    $_SESSION['message'] = 'Регистрация прошла успешно';
    header('Location: ../login.php');
} else {
    $_SESSION['message'] = 'Пароли не совпадают';
    header('Location: ../registr.php');
}