<?php session_start(); 

    //if(!isset($_SESSION['user']))
    //    {
    //        $user = null;
    //    }
    //if(isset($_SESSION['user']))
    //    {
    //        $user = $_SESSION['user'];
     //   }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameLab</title>
    <link rel="stylesheet" href="css/main.css">
    <script src="js/indexscript.js" defer></script>
    <link href="https://fonts.googleapis.com/css?family=Handjet:100,200,300,regular,500,600,700,800,900" rel="stylesheet" />
</head>
<body>

    <div id="Wrap">
    <header>
        <div id="headerWrap">
            <div class="logo">
                <h2>GameLab / Главная</h2>
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
<!-- --> 
        <nav id="menu">
            <a href="catalog.php" class="menuBtn">Каталог игр</a>
            <a href="#advantagesTitle" class="menuBtn">Наши преимущества</a>
            <a href="" class="menuBtn">О проекте</a>
        </nav>
    </header>

    <div id="sliderWrap">
        <div class="slider" id="slider-content">
          <div class="banner banner1 active">
            <div class="banner-txt"> 
                <h3>Лучшие игры у нас!</h3>
                <p>Начните играть прямо сейчас</p>
                <a href="catalog.php">Выбор игры</a>
            </div>
          </div>
          <div class="banner banner2">
            <div class="banner-txt"> 
                <h3>Лучшие игры у нас!</h3>
                <p>Начните играть прямо сейчас</p>
                <a href="catalog.php">Выбор игры</a>
            </div>
          </div>
          <div class="banner banner3">
            <div class="banner-txt"> 
                <h3>Лучшие игры у нас!</h3>
                <p>Начните играть прямо сейчас</p>
                <a href="catalog.php">Выбор игры</a>
            </div>
          </div>
          <button id="prevBtn"><img src="media/strelka-vlevo.png" alt=""></button>
          <button id="nextBtn"><img src="media/strelka-vpravo.png" alt=""></button>
          <div id="indicators">
            <div class="circle circleActive"></div>
            <div class="circle"></div>
            <div class="circle"></div>
          </div>
        </div>
    </div>


    <main>
        <div>
            <h2 id="advantagesTitle">Почему GameLab?</h2>
        </div>

        <section id="advantagesWrap">
            <div class="advantageCard"><h2 class="advCardtxt">Низкие цены! <p>Описание описание описание</p> </h2> <img class="advCardimg" src="media/icons8-creative-commons-nc-50.png" alt=""></div>
            <div class="advantageCard"><h2 class="advCardtxt">Большой выбор игр! <p>Описание описание описание</p> </h2> <img class="advCardimg" src="media/icons8-поиск-в-списке-50.png" alt=""></div>
            <div class="advantageCard"><h2 class="advCardtxt">Быстрая покупка! <p>Описание описание описание</p> </h2> <img class="advCardimg" src="media/icons8-рабочее-время-50.png" alt=""></div>
        </section>

        <section id="trendGamesWrap">
            <h2 id="gamesTitle">Игры GameLab</h2>
            <div class="gamesCard1">
                <div class="gameName">
                <h3>Крестики-нолики</h3>
                </div>
                <div class="playBtn">
                    <a href="tictactoe.html">Играть</a>
                </div>
                
            </div>
            <div class="gamesCard2">
                <div class="gameName">
                <h3>Игра в города</h3>
                </div>
                <div class="playBtn">
                    <a href="goroda.html">Играть</a>
                </div>
            </div>
            <div class="gamesCard3">
                <div class="gameName">
                <h3>2D-Платформер</h3>
                </div>
                <div class="playBtn">
                    <a href="Platformer/game.html">Играть</a>
                </div>
            </div>
        </section>

        <section id="partners">
            <div></div>
            <div></div>
            <div></div>
        </section>
    </main>
    
    <footer>
        <div id="footerWrap">
          <div class="title">
            <p class="title">GameLab</p>
          </div>
          <div id="politikaConf">
                <a id="politikaConf" href="">Политика конфиденциальности</a>
            </div>
            <div id="year">
                <p>Год создания: 2077</p>
            </div>
        </div>
    </footer>
    </div>
</div>
</div>
</body>
</html>