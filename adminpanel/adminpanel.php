<?php require_once ("./vender/connect.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form action="./vender/sendform.php" method="post">
        <label>Предмет</label>
        <input required type="text" name="object" placeholder="Предмет">
        <button type="submit">Отправить</button>
    </form>
    <form action="./vender/sendform.php" method="post">
        <label for="object_id">Предмет</label>
        <select name="object_id" id="object_id" required>
            <option value="0" disabled selected>Выберете предмет</option>
            <?php
            $res = $connect->query("SELECT * FROM object");
            while ($row = $res->fetch_assoc()) {
                ?>
                <option value="<?= $row['id'] ?>">
                    <?= $row['name'] ?>
                </option>

            <?php } ?>
        </select>
        <label for="them">Тема</label>
        <input required type="text" name="them" id="them" placeholder="Тема лекции">
        <button type="submit">Отправить</button>
    </form>
    <form action="./vender/sendform.php" method="POST" enctype="multipart/form-data">
        <label for="name">Название</label>
        <input required type="text" name="name" id="name" placeholder="Название лекции">
        <label for="them_id">Тема</label>
        <select required name="them_id" id="them_id">
            <option value="0" disabled selected>Выберете тему</option>
            <?php
            $res = $connect->query("SELECT * FROM them");
            while ($row = $res->fetch_assoc()) {
                ?>
                <option value="<?= $row['id'] ?>">
                    <?= $row['name'] ?>
                </option>

            <?php } ?>
        </select>
        <label>Лекция</label>
        <textarea name="text"></textarea>
        <input type="file" name="lecture">
        <button type="submit">Отправить</button>
    </form>

    <table>
        <th></th>
    </table>

</body>

</html>