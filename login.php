<!doctype html>
<html lang="ru">

<head>
  <?php
  if (isset($_COOKIE["login"])) {
    $login = $_COOKIE["login"];
  }
  if (isset($_COOKIE["password"])) {
    $password = $_COOKIE["password"];
  }

  $config = include 'config.php';

  $host = $config["host"];
  $user = $config["user"];
  $passworddb = $config["password"];
  $db = $config["db"];

  $link = mysqli_connect($host, $user, $passworddb, $db);

  if ($link === false) {
    die("Ошибка: " . mysqli_connect_error());
  }

  $sql = "SELECT Count(*) as nums FROM `Worker` WHERE `login` LIKE '$login' AND `password` LIKE '$password'";
  if (!mysqli_query($link, $sql)) {
    $error = mysqli_error($link);
    echo "</br>$error";
  } else {
    $result = mysqli_query($link, $sql);
  }

  $count = mysqli_fetch_array($result)["nums"];

  if ($count == 1) {
    echo '<script>';
    echo 'window.location.replace("main.php");';
    echo '</script>';
  }
  ?>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <link rel="stylesheet" href="style/login.css">
  <title>Авторизация</title>
  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }
  </style>
</head>

<body class="text-center">
  <main class="form-signin w-100 m-auto">
    <form action="authorize.php" method="post">
      <h1 class="h3 mb-3 fw-normal">Авторизация</h1>

      <div class="form-floating">
        <input class="form-control" name="login" id="floatingInput" placeholder="Логин">
        <label for="floatingInput">Логин</label>
      </div>
      <div class="form-floating">
        <input type="password" name="pass" class="form-control" id="floatingPassword" placeholder="Пароль">
        <label for="floatingPassword">Пароль</label>
      </div>

      <div class="checkbox mb-3">
      </div>
      <button class="w-100 btn btn-lg btn-danger" type="submit">Войти</button>
    </form>
  </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</html>