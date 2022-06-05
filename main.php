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

    if ($count == 0) {
        echo '<script>';
        echo 'window.location.replace("login.php");';
        echo '</script>';
    }

    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <script src="js/main.js"></script>
    <title>Студенты алкаши придумали новый проект</title>
</head>


<body>
    <header>
        <nav class="navbar fixed-top navbar-expand-lg navbar-light">
            <div class="container">
                <a href="" class="navbar-brand">Dom.Student</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarContent">
                   <ul class="navbar-nav mе-auto mb-2 top-menu">
                        <li class="nav-item">
                            <a href="#" class="nav-link">Список заявлений</a>
                        </li>
                    </ul> 
                    <div class="navbar-nav ms-auto mb-2 mb-lg-0 ">
                        <button href="" class="btn btn-outline-danger dropdown-item" onclick="exit();">Выйти</button>
                    </div>

                </div>
            </div>
        </nav>
    </header>
    <section class="content">
        <div class="container">
            <div class="row mt-5">
                <div class="col">
                    <h4>Список заявлений</h4>
                    <div class="datatable">
                        <table class="table table-hover table-sm " style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="th-sm" scope="col">№</th>
                                    <th class="th-sm" scope="col">ФИО</th>
                                    <th class="th-sm" scope="col">Адрес</th>
                                    <th class="th-sm" scope="col">Email</th>
                                    <th class="th-sm" scope="col">Номер</th>
                                    <th class="th-sm" scope="col">Комментарий</th>
                                    <th class="th-sm" scope="col">Принять</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Фамилия И.О</td>
                                    <td>Адрес</td>
                                    <td>Email</td>
                                    <td>Номер</td>
                                    <td>Комментарий</td>
                                    <td><a href="">Принять</a></td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="col">
                    <form action="">
                        <div class="row">
                            <h4>Заявление</h4>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="text" placeholder="ФИО" name="" class="form-control mb-3">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="text" placeholder="Адрес" name="" class="form-control mb-3">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="email" placeholder="Email" name="" class="form-control mb-3">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="number" placeholder="Номер" name="" class="form-control mb-3">
                                </div>
                            </div>
                            <div class="col-12">
                                <textarea name="" placeholder="Комментарий" class="form-control mt-3" cols="30" rows="10"></textarea>
                                <button class="btn btn-success mt-3">Завершить</button>
                                <button class="btn btn-danger mt-3">Удалить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>

</html>