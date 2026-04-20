<?php 

session_start();

if (!isset($_SESSION['user'])) {
    echo "auth_error"; // Просто отправляем JS-у кодовое слово
    exit();
}


$gameId = $_POST['game_id']; // ключ из AJAX fetch функции
$userId = $_SESSION['user']['userId']; // id юзера из сессии

require_once '../database/dbconnect.php';

//$stmtLikes = "INSERT INTO favourites (user_id, game_id) VALUES ('$userId', '$gameId')";

//if ($conn->query($stmtLikes)) {
//    echo "success";
//} else {//
  //  echo "db_error";
//}

$checkSql = "SELECT * FROM favourites WHERE user_id = ? AND game_id = ?";
$stmt = $conn->prepare($checkSql);
$stmt->execute([$userId, $gameId]);
$like = $stmt->fetch();

if ($like) {
    // 2. Если лайк НАЙДЕН — УДАЛЯЕМ его (Анлайк)
    $deleteSql = "DELETE FROM favourites WHERE user_id = ? AND game_id = ?";
    $conn->prepare($deleteSql)->execute([$userId, $gameId]);
    echo "removed"; // Это слово поймает JS
} else {
    // 3. Если лайка НЕТ — ДОБАВЛЯЕМ (Лайк)
    $insertSql = "INSERT INTO favourites (user_id, game_id) VALUES (?, ?)";
    $conn->prepare($insertSql)->execute([$userId, $gameId]);
    echo "added";
}


?>