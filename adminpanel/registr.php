<?php
session_start()
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form action="./vender/signup.php" method="post">
        <label for="">Ваше имя</label>
        <input type="text" name="full_name" placeholder="Введите имя">
        <label for="">Логин</label>
        <input type="text" name="login" placeholder="Введите логин">
        <label for="">Пароль</label>
        <input type="password" name="password" placeholder="Введите пароль">
        <label for="">Поддтверждение пароля</label>
        <input type="password" name="password_confirm" placeholder="Повторите пароль">
        <button type="submit">Завершить регистрацию</button>
        <p>У вас уже есть аккаунт? <a href="login.php">Авторизируйтесь</a></p>
        <?php
        if (isset($_SESSION["message"])){
            echo '<p id="msg">';
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            echo '</p>';
        }
         ?>
    </form>
</body>

</html>