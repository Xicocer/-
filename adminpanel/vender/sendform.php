<?php
require_once 'connect.php';

function convertRUcharacters($str)
{
    $from = array('а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я');
    $to = array('a', 'b', 'v', 'g', 'd', 'e', 'e', 'zh', 'z', 'i', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'kh', 'cz', 'ch', 'sh', 'shh', '', 'y', '', 'e', 'yu', 'ya', 'A', 'B', 'V', 'G', 'D', 'E', 'E', 'ZH', 'Z', 'I', 'I', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'KH', 'CZ', 'CH', 'SH', 'SHH', '', 'Y', '', 'E', 'YU', 'YA');
    return str_replace($from, $to, $str);
}

if (isset($_FILES) && isset($_POST['text'])) {
    if ($_FILES['lecture']['error'] != 4) {
        var_dump($_FILES);
        $name = $_POST['name'];
        $them_id = $_POST['them_id'];
        $them_name = $connect->query("SELECT * FROM them Where id = " . $_POST['them_id'])->fetch_assoc()['name'];
        $path = "./thems/" . convertRUcharacters($them_name) . "/" . date("U") . $_FILES['lecture']['name'];
        if (move_uploaded_file($_FILES['lecture']['tmp_name'], "./../" . $path))
            mysqli_query($connect, "INSERT INTO `lecture` (`id`, `name`,`text`, `id_them`, `file`) VALUES (NULL,'$name', '$path', '$them_id','1')");
    } else {
        $name = $_POST['name'];
        $lecture = $_POST['text'];
        $them_id = $_POST['them_id'];
        mysqli_query($connect, "INSERT INTO `lecture` (`id`, `name`,`text`, `id_them`) VALUES (NULL,'$name', '$lecture', '$them_id')");
    }

}
if (isset($_POST['object'])) {
    $object = $_POST['object'];
    mysqli_query($connect, "INSERT INTO `object` (`id`, `name`) VALUES (NULL, '$object')");

}
if (isset($_POST['them'])) {
    $them = $_POST['them'];
    $object_id = $_POST['object_id'];
    if (!dir("./../thems/" . convertRUcharacters($them))) {
        mkdir("./../thems/" . convertRUcharacters($them));
    }
    mysqli_query($connect, "INSERT INTO `them` (`id`, `name`, `id_object`) VALUES (NULL, '$them', '$object_id')");

}




header('Location: ./../adminpanel.php');