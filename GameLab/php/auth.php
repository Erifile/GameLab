<?php
// Решения уязвимостей,  таких как:
// 1) переход по адрс строке без ввода данных. (защита этого файла)
// 2) убирание метода required у инпутов
// 3) нерабочий js скрипт у пользователя
// 4) убирание лишних пробелов, введённых васей
// 5) sql-инъекции
// 6) хранение паролей в БД в открытом виде. Хеширование

// данные из формы перенаправляются в виде ассоциативного массива $_POST. не индекс у каждого эл-а, а имя name в форме явл. порядковым значением - поэтому ассоциативный
// у метода empty() если вписать обычный 0 - будет считаться за пустоту. поэтому $_POST['login']!=''

// if (isset($_POST['login']) && $_POST['login']!='' && isset($_POST['login']) && $_POST['login']!='' && isset($_POST['login']) && $_POST['login']!='' && isset($_POST['fio']) && $_POST['fio']!='')



// 1)
 if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        http_response_code(405);
        exit();
    }

require_once '../database/dbconnect.php'; // подключение БД

session_start(); // хранилище данных сессии.. хранится пока не закроется вкладка..?


$inputs = 
[
    'login',
    'password'
];


foreach ($inputs as $input) 
{
    if (!isset($_POST[$input]) || $_POST[$input]=='')
        {
            $_SESSION['message'] = 'Ошибка. Есть пустые поля формы.';
            header("Location:../authPage.php?stat=error"); // перенаправление обратно на форму регистрации.  stat - GET параметр. отобразится в адрс. строке. статус ошибки.
            exit();
        }
}


 // 4)
$login = trim($_POST['login']);
$password = $_POST['password'];
$email = trim($_POST['email']);

// 6) 
$checkUser = $conn -> prepare("select * from users where login = :login or email = :email");
$checkUser -> execute
    (
    [
        ':login' => $login,
        ':email' => $login // т.к. в инпуте можно или email или логин.
    ]);
$checkUser = $checkUser -> fetch(PDO::FETCH_ASSOC); // если селект не найдет ничего, то массив $checkUser выдаст emptyset

if (!$checkUser || !password_verify($password, $checkUser['password'])) // если массив пустой ИЛИ не прошла верификация захешированного пароля по 2-му аргументу.
{
    $_SESSION['message'] = 'Ошибка. Неверный логин или пароль';
    echo $_SESSION['message'];
    header("Location:../authPage.php?stat=error"); // перенаправление обратно на форму регистрации.  stat - GET параметр. отобразится в адрс. строке. статус ошибки.
    exit(); // принудительное завершение скрипта. (NE SOVSEM kak return)
};

// при session_start() создаётся 2 сессионных файла - 1 на сервер и 1 на пк пользователя. 
session_regenerate_id(true); // обновление айди сессии пользователя?.. для предотвращения перехватаа трафика

$_SESSION['user'] = [ // хранение данных юзера в сессионном массиве user внутри супермассива $_SESSION (перекидывание из массива $checkUser) КРОМЕ пароля.
    'userId' => $checkUser['id'],
    'userLogin' => $checkUser['login'],
    'userEmail' => $checkUser['email'],
    'userRole' => $checkUser['role']
];



//$_SESSION['user']['userLogin'] // получение значения из массива user

if($_SESSION['user']['userRole'] == 'user')
    {
        $homePage = '../main.php'; // создание главн. страницы в зависимости от роли пользователя
    }
if($_SESSION['user']['userRole'] == 'admin')
    {
        $homePage = '../adminPanel.php';
    }

    $_SESSION['message'] = 'Авторизация успешна!';
    header("Location:".$homePage);
    exit();

?>