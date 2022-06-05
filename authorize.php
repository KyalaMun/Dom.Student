<?php
$config = include 'config.php';
header("Content-Type: text/html; charset=UTF-8");

// Забираем данные из формы

if (isset($_POST["login"])) {
    $login = $_POST["login"];
}
if (isset($_POST["pass"])) {
    $pass = $_POST["pass"];
}

$host = $config["host"];
$user = $config["user"];
$password = $config["password"];
$db = $config["db"];

$link = mysqli_connect($host, $user, $password, $db);
if ($link === false) {
    die("Ошибка: " . mysqli_connect_error());
}

$sql = "SELECT Count(*) as nums FROM `Worker` WHERE `login` LIKE '$login' AND `password` LIKE '$pass'";
if(!mysqli_query($link, $sql)){
  $error = mysqli_error($link);
  echo "</br>$error"; 
} else{
  $result = mysqli_query($link, $sql);
}

$count = mysqli_fetch_array($result)["nums"];

if($count == 1){
  setcookie("login", $login);
  setcookie("password", $pass);
} else{
    echo '<script>';
    echo 'alert("Неправильный логин или пароль");';
    echo '</script>';
}

echo '<script>';
echo 'window.location.replace("login.php");';
echo '</script>';

?>
