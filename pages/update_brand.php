<?php
session_start();
require_once '../php/connect.php';

$brand_id = $_GET['id'];
$db = connect();
$brands = $db -> prepare( "SELECT * FROM brand WHERE id = :id");
$brands -> bindParam(':id',$brand_id);
$brands->execute();
$brand = $brands->fetch(PDO::FETCH_ASSOC);

if (!$_SESSION['user']) {
    header('Location: ../pages/auth.php');
}
if ($_SESSION['user'] != 2) {
    header('Location: ../pages/lk.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Изменение данных</title>

    <link rel="icon" href="../img/Logo.jpg" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">

    <!--CSS-->
    <link href="https://fonts.googleapis.com/css2?family=Play&family=Quantico:ital@1&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
<header>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #000000;">
            <div class="container-fluid">
                <a class="navbar-brand" href="/index.php ">
                    <img src="../img/Logo.jpg" width="30" height="30" class="d-inline-block align-top" loading="lazy">
                    AutoBox</a>
                <nav class="nav">
                    <a class="nav-link" href="/pages/auto.php">Список автомобилей</a>
                    <a class="nav-link" href="/pages/owner.php">Список владельцев</a>
                    <a class="nav-link" href="/pages/journal.php">Журнал </a>
                    <a class="nav-link" href="/pages/team.php">Наша команда</a>
                </nav>
                <ul class="nav justify-content-end">
                    <?php
                    if (!isset($_SESSION['user'])) :
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/pages/auth.php">Вход</a>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="btn btn-light" onclick="window.location.href ='/pages/registration.php'">Регистрация</button>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <h6 class="hello-title">Привет, <?= $_SESSION['array']['login'] ?></h6>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="/pages/lk.php">Личный кабинет</a>
                        <li>
                        <li class="nav-item">
                            <button type="button" class="btn btn-light" onclick="window.location.href ='/php/logout.php'">Выход</button>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </div>
</header>
<div class="admin">
    <div class="container_reg">
        <form style="margin-top: 55px; background-color: rgba(0, 0, 0, 0.4); padding: 10px" class="register-form" name="register-form" id="register-form" action="../php/update_brand.php" method="post" enctype="multipart/form-data">
            <h2>Изменение марки</h2><br>
            <input type="hidden" name="id" value="<?= $brand['id'] ?>">
            <label style="color:white; text-align: left;" for="name_brand">Название марки * <span id="br"></span></label>
            <input type="text" class="form-control" name="name_brand" value="<?= $brand['name_brand'] ?>" id="br" onBlur="validationBrand()" placeholder="Введите название марки"><br>
            <label style="color:white; text-align: left;" for="country">Страна автомобиля * <span id="cn"></span></label>
            <input type="text" class="form-control" name="country" value="<?= $brand['country'] ?>" id="cn" onBlur="validationModel()" placeholder="Введите страну марки"><br>
            <button class="btn-reg" onclick="checkall()" type="submit">Обновить данные</button>
            <?php
            if ($_SESSION['message']) {
                echo '<p class="msg-err">' . $_SESSION['message'] . '</p>';
            }
            unset($_SESSION['message']);
            ?>
        </form>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- Popper.js first, then Bootstrap JS -->
<script>
    function validationBrand() {
        var x = document.forms["register-form"]["name_brand"].value;
        if (x.length < 3) {
            document.getElementById('br').innerHTML = '(мин. 3 символа)';
            return false;
        } else {
            document.getElementById('br').innerHTML = '';
            return true;
        }
    }
    function validationModel() {
        var x = document.forms["register-form"]["country"].value;
        if (x.length < 2) {
            document.getElementById('cn').innerHTML = '(мин. 2 символа)';
            return false;
        } else {
            document.getElementById('cn').innerHTML = '';
            return true;
        }
    }
    }
    function checkall(){
        if(validationBrand() && validationModel() && validationColor() ) return true;
        else return false;
    }
</script>
<script src=" https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous">
</script>
</body>

</html>

