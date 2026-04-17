<?php
$title = $_POST["title"]; // название жанра

require_once '../database/dbconnect.php';

$conn -> exec("INSERT INTO genres (genretitle) values ('$title')");

header("Location:../adminPanel.php");
echo "Жанр добавлен: ".$title; // пишется только на addGenre
exit();
?>