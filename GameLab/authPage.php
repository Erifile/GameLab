<?php session_start(); 

    if(isset($_SESSION['user']))
 {
    header('Location:main.php');
    exit();
 }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="css/authStyle.css">
</head>
<body>
    <?php if(isset($_SESSION['message'])){ ?>
    <p><?php echo $_SESSION['message']; ?></p>
    <?php unset($_SESSION['message']);
       } ?>
    <form action="php/auth.php" method="POST" id="form">
        <h2>Авторизация</h2>
        <label for="login">Логин / Email</label>
        <input type="text" required name="login" id="login" placeholder="Введите логин или Email">
        <label for="password">Пароль</label>
        <input type="password"  class="password" required name="password" id="password" placeholder="Введите пароль..">
        <p id="message"></p>
        <input type="submit" value="Войти">
        <a href="index.php">Нет аккаунта?</a>
    </form>
</body>
</html>