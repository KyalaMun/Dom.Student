<?php

header("Content-Type: text/html; charset=UTF-8");

// Забираем данные из формы

if (isset($_POST["name"])) {
    $name = $_POST["name"];
}
if (isset($_POST["address"])) {
    $address = $_POST["address"];
}
if (isset($_POST["email"])) {
    $email = $_POST["email"];
}
if (isset($_POST["phone"])) {
    $phone = $_POST["phone"];
}
if (isset($_POST["problem_text"])) {
    $text = $_POST["problem_text"];
}

echo "$name, $address, $email, $phone, $text</br>";

// Коннектим БД и палим данные :) (уже нет)

// $link = mysqli_connect('host', 'user', 'password', "db");

if ($link === false) {
    die("Ошибка: " . mysqli_connect_error());
}
echo "Подключение успешно установлено";

// Дай мне силы
// Give me strong?
// strength...

// Проверяем по номеру телефона, есть ли у нас этот клиент
$query_proverka = "SELECT Count(*) AS count FROM `Client` WHERE `Client`.`phone` LIKE $phone";

$result_client = mysqli_query($link, $query_proverka);
$client_count = mysqli_fetch_array($result_client)["count"];

echo "</br> $client_count клиентов из 1";

// Загрузим список сотрудников, чтобы выбрать сотрудника для заявки.
// Динамическая типизация, что ты со мной творишь?
$query_sotrudniki = "SELECT `worker_id` FROM `Worker`";
$workers = [];
$i = 0;
if ($result_worker = mysqli_query($link, $query_sotrudniki)) {
    foreach ($result_worker as $row) {
        $workers = $workers + array($i => $row["worker_id"]);
        $i++;
    }
}
unset($i);

// id случайного работника. Бедняжка ):
$random_worker_id = $workers[rand(0, count($workers) - 1)];

if ($client_count == 0) {
    echo "</br>Новый";
    // Если в первый раз заходит на сайт
    $query_create = "INSERT INTO `Client`(`name`, `phone`, `address`, `email`) VALUES ('$name', '$phone', '$address', '$email')";
    if(!mysqli_query($link, $query_create)){
        $error = mysqli_error($link);
        echo "</br>$error"; 
    }
    
} else {
    echo "</br>Существующий";
    $query_update = "UPDATE `Client` SET `name`='$name', `address`='$address', `email`='$email' WHERE `phone` LIKE '$phone'";
    if(!mysqli_query($link, $query_update)){
        $error = mysqli_error($link);
        echo "</br>$error"; 
    }
}

// Создаем заявку

// Получаем ид клиента
$result_client_id = mysqli_query($link, "SELECT `client_id` FROM `Client` WHERE `phone` LIKE '$phone'");
$client_id = mysqli_fetch_array($result_client_id)["client_id"];

$date = date('Y-m-d');

echo "<br>Клиент номер: $client_id";
$query_create_task = "INSERT INTO `Task`(`client_id`, `worker_id`, `problem_text`, `date`, `is_closed`) VALUES('$client_id', '$random_worker_id', '$text', '$date', '0')";
if(!mysqli_query($link, $query_create_task)){
    $error = mysqli_error($link);
    echo "</br>$error"; 
}

// Перенаправляем...
header('Location: ../index.php');

mysqli_close($link);
?>