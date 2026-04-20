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

require_once '../database/dbconnect.php';  // подключение БД

session_start(); // хранилище данных сессии.. хранится пока не закроется вкладка..?


$inputs = 
[
    'login',  // явл просто строками для последующего их подставления в цикл foreach. 
    'password',
    'repPassword',
    'email'
];

// 2) ПРОВЕРКА НА ПУСТЫЕ ПОЛЯ В ФОРМЕ
foreach ($inputs as $input) 
{
    if (!isset($_POST[$input]) || $_POST[$input]=='')
        {
            $_SESSION['message'] = 'Ошибка. Есть пустые поля формы.';
            header("Location:../index.php?stat=error"); // перенаправление обратно на форму регистрации.  stat - GET параметр. отобразится в адрс. строке. статус ошибки.
            exit();
        }
}
// 3) ДОП. ПРОВЕРКА НА СОВПАДЕНИЕ ПАРОЛЕЙ
if ($_POST['password'] !== $_POST['repPassword'])
    {
        $_SESSION['message'] = 'Ошибка. Пароли не совпадают';
        header("Location:../index.php?stat=error"); 
        exit(); // принудительное завершение скрипта. (+- kak return. только не возвращает ничего и работает глобально, а не локально)
    }

// ПРОВЕРКА НА КОРРЕКТНОСТЬ EMAIL
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) // 1 arg - что проверяем, 2 arg - на что проверяем.
    {
        $_SESSION['message'] = 'Ошибка. Некорректный email';
        header("Location:../index.php?stat=error"); 
        exit();
    }

 // 4) УБИРАНИЕ ПРОБЕЛОВ У ВВЕДЁННЫХ ДАННЫХ
$login = trim($_POST['login']);
$password = trim($_POST['password']);
$email = trim($_POST['email']);   

// 5) ПРОВЕРКА, ЗАНЯТЫ ЛИ LOGIN/EMAIL
// prepare() отличается от обычного запроса в БД что сначала данные обрабатываются, а потом отправляются. избегание sql инъекций
$check = $conn->prepare("select 
exists (select 1 from users where login = :login) as login_err, exists (select 1 from users where email = :email) as email_err"); //подготавливаем: говорим sql что мы хотим выбрать
$check -> execute([':login' => $login, ':email' => $email]); // проверяем данные

$check = $check -> fetch(PDO::FETCH_ASSOC); // в ассоциативный массив

$errors = [];

if ($check['login_err'])
    {
        $errors[] = 'Логин занят';
    }
if ($check['email_err'])
    {
        $errors[] = 'Email занят';
    }
if(!empty($errors))
    {
        // implode объединяет эл-ы массива в строчку. 1 arg - разделитель эл-тов 2 arg - сам массив
        $_SESSION['message'] = implode('. ', $errors).'!';
        header("Location:../index.php?stat=error");
        exit();
    }


// 6) 
$newUser = $conn -> prepare("insert into users (login, password, email) values (:login, :password, :email)");
$newUser -> execute  // метод prepare() подготавливает запрос со срезами (:), а execute создаёт связь-присваивание (=>) между данными (ПОСУТИ на основе ассоциативного массива, который пишу внутри него я. как раз эти связи ключ-значение в нём боже алиса бл ), занесенными через prepare() и переменными, в которые мы заносили то, что ввёл пользователь в инпуты, и затем отправдяет в БД.
    (
    [
        ':login' => $login,
        ':password' => password_hash($password, PASSWORD_DEFAULT),
        ':email' => $email
    ]);
    $_SESSION['message'] = 'Реsгистрация успешна!';
    header("Location:../authPage.php?stat=ok");
    exit();

?>