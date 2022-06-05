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
    if (isset($_GET["selected_task_id"])) {
        $selected_task_id = $_GET["selected_task_id"];
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
    <title>Студенты алкаши придумали новый проект</title>
</head>

<body>
    <?php
    $query_list = "SELECT `Task`.`task_id`, `Client`.`name`, `Client`.`address`, `Client`.`phone`, `Client`.`email`, `Task`.`date`, `Task`.`is_closed` FROM `Task`, `Client`, `Worker` WHERE `Task`.`client_id`= `Client`.`client_id` AND `Task`.`worker_id` = `Worker`.`worker_id` AND `Worker`.`login` LIKE '$login'";
    $result_list = mysqli_query($link, $query_list);
    $list = $result_list;
    ?>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
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
                                    <th class="th-sm" style="width: 15%;" scope="col">Адрес</th>
                                    <th class="th-sm" scope="col">Номер</th>
                                    <th class="th-sm" scope="col">Email</th>
                                    <th class="th-sm" scope="col">Дата</th>
                                    <th class="th-sm" scope="col">Статус</th>
                                    <th class="th-sm" scope="col"></th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($list as $row) { ?>
                                    <tr>


                                        <th scope="row"><?php $task_id = $row["task_id"];
                                                        echo $task_id; ?></th>
                                        <td><?php echo $row["name"]; ?></td>
                                        <td><?php echo $row["address"]; ?></td>
                                        <td><?php echo $row["phone"]; ?></td>
                                        <td><?php echo $row["email"]; ?></td>
                                        <td><?php echo $row["date"]; ?></td>
                                        <td><?php $is_clsd = $row["is_closed"];
                                            if ($is_clsd == 1) {
                                                echo "Закрыто";
                                            } else {
                                                echo "Открыто";
                                            } ?></td>
                                        <td><?php echo "<a class='btn btn-outline-primary' href='main.php?selected_task_id=$task_id'>Перейти</a>" ?></td>
                                    </tr>

                                <?php } ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="col">
                    <form action="">
                        <div class="row">

                            <?php if (isset($selected_task_id)) { ?>
                                <?php
                                $query_task = "SELECT `Task`.`task_id`, `Client`.`name`, `Client`.`address`, `Task`.`problem_text`, `Client`.`phone`, `Client`.`email`, `Task`.`date`, `Task`.`is_closed` FROM `Task`, `Client`, `Worker` WHERE `Task`.`client_id`= `Client`.`client_id` AND `Task`.`worker_id` = `Worker`.`worker_id` AND `Task`.`task_id` = '$selected_task_id'";
                                $result_task = mysqli_query($link, $query_task);
                                $row = mysqli_fetch_array($result_task);
                                ?>
                                <h4>Заявление</h4>
                                <div class="col-lg-6">
                                    <p>ФИО</p>
                                    <input type="text" placeholder="<?php echo $row["name"]; ?>" readonly="true" placeholder="ФИО" class="form-control mb-3">
                                </div>
                                <div class="col-lg-6">
                                    <p>Адрес</p>
                                    <input type="text" placeholder="<?php echo $row["address"]; ?>" readonly="true" placeholder="Адрес" class="form-control mb-3">
                                </div>
                                <div class="col-lg-6">
                                    <p>Электронная почта</p>
                                    <input type="email" placeholder="<?php echo $row["email"]; ?>" readonly="true" placeholder="Email" class="form-control mb-3">
                                </div>
                                <div class="col-lg-6">
                                    <p>Номер телефона</p>
                                    <input type="number" placeholder="<?php echo $row["phone"]; ?>" readonly="true" placeholder="Номер" class="form-control mb-3">
                                </div>
                                <div class="col-lg-6">
                                    <p>Дата</p>
                                    <input type="text" placeholder="<?php echo $row["date"]; ?>" readonly="true" placeholder="Дата" class="form-control mb-3">
                                </div>
                                <div class="col-lg-6">
                                    <p>Закрыт</p>
                                    <input type="text" readonly="true" class="form-control mb-3" readonly="true" placeholder=<?php $is_clsd_task = $row["is_closed"];
                                                                                                                                if ($is_clsd_task == 1) {
                                                                                                                                    echo "Закрыто";
                                                                                                                                } else {
                                                                                                                                    echo "Открыто";
                                                                                                                                } ?>>
                                </div>
                                <div class="col-12">
                                    <p>Текст обращения</p>
                                    <textarea readonly="true" placeholder="<?php echo $row["problem_text"] ?>" class="form-control mt-3" cols="30" rows="10"></textarea>
                                    <a href="main.php?selected_task_id=<?php $status = $row['is_closed']; echo $row["task_id"];
                                                                        echo "&status=$status"?>" class="btn btn-<?php if($status == 1){ echo "success";}
                                                                        else { echo "danger";} ?> mt-3">
                                        <?php if($status == 1){ echo "Открыть";}
                                        else { echo "Закрыть";} ?>
                                    </a>
                                    <a href="main.php" class="btn btn-secondary mt-3">Закрыть</a>
                                    <?php
                                    if(isset($_GET["status"])){$status = $_GET["status"];}

                                    if($status = 0){$new_status = 1;}
                                    else {$new_status = 0;}

                                    $query_switch_status = "UPDATE `Task` SET `is_closed` = '$new_status' WHERE `task_id` = '$selected_task_id'";

                                    if(!mysqli_query($link, $query_switch_status)){
                                        $error = mysqli_error($link);
                                        echo "</br>$error"; 
                                    }
                                    ?>
                                </div>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
    </section>
    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>

</html>