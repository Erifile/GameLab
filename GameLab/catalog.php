<?php 

require_once 'database/dbconnect.php';

session_start();


         if(isset($_SESSION['user']))
            {
                $currentUserId = $_SESSION['user']['userId'];
                
                $stmtFavourites = "SELECT game_id FROM favourites WHERE user_id = $currentUserId";
                $stmtFavourites = $conn -> query($stmtFavourites);
                $favouritesArray = $stmtFavourites -> fetchAll(); // возвращает двумерный массив

                $favouriteGames = array_column($favouritesArray, 'game_id'); // возвращает только id
            }





$selectedGenre = $_GET['genre'] ?? 'all'; // берёт выбранную опцию у select с name (genre) и хранит value опции  если не установлен, ставится значение (value) all

//Выбор всех жанров из БД
$genres = $conn -> query("SELECT * FROM genres");
$genres = $genres -> fetchAll();
//Нет смысла в подг. запросе, т.к. нет ввода пользователя.
//$genresSql = "SELECT * FROM genres";     
//$genresStmt = $conn->prepare($genresSql);
//$genresStmt->execute();
//$genres = $conn -> query("SELECT * FROM genres");
//$genres = $genres -> fetchAll();


// Проверка на выбранный жанр
if ($selectedGenre !== 'all')
    {
        $gamesSql = "SELECT games.*, genres.genretitle 
        FROM games 
        JOIN genres ON games.genre = genres.id WHERE genres.genretitle = ?"; // 
       
       //Неподготовленный запрос
       // $genreId = $conn -> query("SELECT id FROM genres where genretitle = '$selectedGenre'");
        //$genreId = $genreId -> fetchAll();
       // $games = $conn -> query("SELECT * FROM games where genre = '$genreId'");
    }
else
    {
        $gamesSql = "SELECT games.*, genres.genretitle 
        FROM games 
        JOIN genres ON games.genre = genres.id";
    }

$stmt = $conn->prepare($gamesSql);

if ($selectedGenre !== 'all')
    {
        $stmt->execute([$selectedGenre]);
    }
else
    {
        $stmt->execute();
    }
$games = $stmt->fetchAll();

//Неподготовленный запрос
//$games = $conn -> query($sql)->fetchAll(); 
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог игр</title>
    <script src="js/searchGame.js" defer></script>
    <!--<script src="js/filter.js" defer></script> больше не нужен -->
    <script src="js/likes.js" defer></script>
    <script src="js/okno.js" defer></script>
    <link rel="stylesheet" href="css/catalog.css">
</head>
<body>




    <div class="overlay"></div> <!-- затемнение для всплывающих сообщений с играми -->

    <header>
        <div class="logo">
            <h2>GameLab / Каталог</h2>
        </div>
  
        <!-- Вывод логина зашедшего пользователя -->
            <div id="userSession">
                <?php if(!isset($_SESSION['user'])){ ?>
                    <p>Вы не вошли в аккаунт.</p>
                    <a href="index.php">Создать</a>
                 </div> <?php } ?> 

                <?php if(isset($_SESSION['user'])){ ?>
                    <p>Вы вошли как: <?php echo $_SESSION['user']['userLogin']; ?> </p>
                    <a href="php/logOut.php">Выйти</a>
                 </div> <?php } ?> 
            </div>

        <a href="main.php" class="indexlink">Главная</a>
    
    </header>


    <main class="catalog">
        <div class="searchFilters">
            <input type="text" id="searchGame" placeholder="Поиск по названию..">
            <!--value - просто данные, к которым можно ссылаться через data-название.-->
            <!--Фильтр по жанрам-->
            <form action="catalog.php" method="GET">
            <p>Поиск по жанру<select name="genre" id="filterGenre" onchange="this.form.submit()"></p>              
                <option value="all">Все игры</option>
                <?php foreach ($genres as $genre):?>

                <option value=<?php echo $genre['genretitle'];?> 
                    <?php if ($selectedGenre == $genre['genretitle']) echo 'selected'; ?>>
                    <?php echo $genre['genretitle'];?>
                </option>
                <!--value кириллицей (название жанр из БД) -->
                <?php endforeach;?>
            </select>
            </form>
      </div>
        <div class="games">
<!--Вывод карточек игр-->
        <?php foreach ($games as $game):?>
            <div class="gameCard">
                <div class="showPopup game-item" data-genre="logic" data-id="<?php echo $game['id']; ?>">             
                    <img class="game-img" src="<?php echo $game['imagelink'];?>" alt="">                                                              
                </div>
            </div>

<!-- Всплывающее окно для каждой игры-->
  <div class="popup" id="popup-id-<?php echo $game['id']; ?>">
    <div class="text">                                      
        <h3 class="gameTitle"><?php echo $game['title'];?></h3>                                    
        <p class="description"><?php echo $game['description'];?></p>  
        <p class="genre"><?php echo $game['genretitle'];?></p>
        <button class="playBtn">
            <a href="<?php echo $game['gamelink'];?>">Играть</a>
        </button>
        <button class="favourite" data-id="<?php echo $game['id'];?>" 
        data-like="<?php echo (isset($favouriteGames) && in_array($game['id'], $favouriteGames)) ? 'true' : 'false'; ?>"> <!-- проверка: установлен ли массив с лайкнутыми играми, и находится ли игра в списке если он есть -->
        <?php echo (isset($favouriteGames) && in_array($game['id'], $favouriteGames)) ? '❤︎' : '♡'; ?>
    </button>
        <button class="closeBtn" data-id="<?php echo $game['id'];?>">Закрыть</button>
  </div>
</div>

<?php endforeach; ?>              
</div>
</main>

</body>
</html>