



// Фильтр по жанрам и Лайки через JS



//const filterGenre = document.querySelector("#filterGenre");
//const games = document.querySelectorAll(".gameCard"); // выбираем всю карточку игры, а не только ссылку. чтобы скрывался весь доч. блок и оставшиеся подстаривлась под grid-функцию
//const likes = document.querySelectorAll(".favourite");

//games.forEach(game => 
//  {
//    console.log(game.getAttribute("data-genre"));

  //
    // можно получить ВСЕ атрибуты через game.dataset. если нужный конкретный - data.
  //название
//  })

//filterGenre.addEventListener("change", ()=> 
//  {
//    
//    let selectedGenre = filterGenre.value // жанр, выбранный пользователем
//
//    games.forEach(game => 
//      {
//
//        if(game.getAttribute("data-genre") == selectedGenre || selectedGenre == "all") // сравнение выбора пользователя с названием жанра в атрибуте data (data-genre. -genre это название)
 //         {
 //           game.style.display = "block";
 //         }
 //         else
 //         {
 //           game.style.display = "none";
 //         }
 //     })
 // })

  likes.forEach(btn =>
    {
      btn.addEventListener("click", (e) => 
        {
          e.preventDefault();
          if (btn.getAttribute("data-like") == 'false'){
              btn.dataset.like = 'true'; // менять можно только с помощью dataset.
              btn.textContent = "❤︎⁠";
            }
            else
              {
                btn.dataset.like = 'false';
                btn.textContent = "♡⁠";
              }
        })

    });

