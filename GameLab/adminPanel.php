

<?php

require_once 'database/dbconnect.php';

//массив $genres, в котором сначала был select запром названий жанров из бд, а потом 
// все значения преобразовались в строки с помощью fetchAll. 
  $genres = $conn->query("SELECT genretitle from genres");
  $genres = $genres -> fetchAll(); // собирает в себя все значения из genres, а не первые попавшиеся
  echo 'ЖАНРЫ:  ';
  var_dump($genres);

  $games = $conn->query("SELECT * from games");
  $games = $games -> fetchAll();
  echo 'ИГРЫ:  ';
  var_dump($games);
  ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Административная панель</title>
  <link rel="stylesheet" href="css/adminPanel.css">
</head>
<body>
  <a href="catalog.php">В каталог</a>
      <form action="php/addGame.php" method="POST">
        <h2>Добавить игру в БД</h2>
        <input type="text" name="title" placeholder="Название игры..">
        <textarea name="description" id="" placeholder="Описание игры.."></textarea>
        <select name="genre" id="">
          <?php 
          foreach($genres as $genre): ?>
            <option><?php echo $genre['genretitle']; ?></option>
          <?php endforeach; ?>
          </select>
        <input type="text" name="gamelink" placeholder="Ссылка на игру..">
        <input type="text" name="imagelink" placeholder="Ссылка на изображение..">
        <input type="submit" value="Добавить">
      </form>
      
      <form action="php/addGenre.php" method="POST">
        <h2>Добавить жанр в БД</h2>
        <input type="text" name="title" placeholder="Название жанра.." required>
        <input type="submit" value="Добавить">
      </form>
</body>
</html>