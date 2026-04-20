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
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/regStyle.css">
    <script src="js/regForm.js" defer></script>
</head>
<body>
    <?php if(isset($_SESSION['message'])){ ?>
    <p><?php $_SESSION['message']; ?></p>
    <?php unset($_SESSION['message']);
       }; ?>

    <form action="php/reg.php" method="POST" id="form">
        <h2>Регистрация</h2>
        <div class="inputs">
        <label for="login">Логин</label>
        <input type="text" required name="login" id="login" placeholder="Введите логин..">
        <label for="password">Пароль</label>
        <input type="password"  class="password" required name="password" id="password" placeholder="Создайте пароль..">
        <label for="repPassword" >Повторный пароль</label>
        <input type="password"  class="password" required name="repPassword" id="repPassword" placeholder="Введите пароль повторно..">
        <p id="message"></p>
        <label for="email">Почта</label>
        <input type="email" required name="email" id="email" placeholder="Введите почту..">
        <label for="accept">Согласен на обработку персональных данных</label>
        <input type="checkbox" required name="accept" id="accept">
        <input type="submit" value="Зарегистрироваться">
        <a href="authPage.php">Есть аккаунт?</a>
        </div>
    </form>
</body>
</html>