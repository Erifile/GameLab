 <?php
$gametitle = $_POST['title'];
$description = $_POST['description'];
$genre = $_POST['genre'];

$gamelink = $_POST['gamelink'];
$imagelink = $_POST['imagelink'];

require_once '../database/dbconnect.php';
$stmt = $conn->query("SELECT id FROM genres WHERE genretitle = '$genre'");
//Извлекаем конкретное значение ID
$idGenre = $stmt->fetchColumn();
$conn -> exec("INSERT INTO games (title, description, genre, gamelink, imagelink) VALUES ('$gametitle', '$description', '$idGenre', '$gamelink', '$imagelink')");

header("Location:../adminPanel.php");
echo "Игра добавлена: ".$gametitle;
exit();