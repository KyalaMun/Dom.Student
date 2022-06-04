

<?php 

header("Content-Type: text/html; charset=UTF-8");

// Забираем данные из формы
$name = htmlentities($_POST['name']);
$address = htmlentities($_POST['address']);
$email = htmlentities($_POST['email']);
$phone = htmlentities($_POST['phone']);
$text = htmlentities($_POST['text']);


echo "$name, $address, $email, $phone, $text";

// Проверяем на null
// if(isset($name) | isset($address) | isset($email) | isset($phone) | isset($text))
// {
//     echo '<script>';
//     echo 'alert("Как вы это сделали?")';
//     echo '</script>';
//     echo '<script>';
//     echo 'window.location.replace("../index.html")';
//     echo '</script>';
// }

// Коннектим БД и палим данные :)
$link = mysqli_connect('//new-bokino.ru:49158', 'Volyna', 'duyv73pj');
if ( !$link ) die("Error");


$link = mysqli_connect("localhost", "root", "mypassword");
if ($link === false) {
  die("Ошибка: " . mysqli_connect_error());
} 
echo "Подключение успешно установлено";
mysqli_close($link);


// Проверяем по номеру телефона, есть ли у нас этот клиент
$queryProverka = "SELECT * FROM `user` WHERE `user`.`phone` LIKE $phone";



/*echo '<head>
<meta http-equiv="refresh" content="1;URL=../index.html" />
</head>';

*/


?>
