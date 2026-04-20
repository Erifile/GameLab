let searchGame = document.querySelector("#searchGame");
let gameItems = document.querySelectorAll(".gameCard"); // выбираем всю карточку игры, а не только ссылку. чтобы скрывался весь доч. блок и оставшиеся подстаривлась под grid-функцию
let titles = document.querySelectorAll(".gameTitle");

// На каждый ввод символа в инпут будет происходить поиск по названию в h3.

searchGame.addEventListener('input', () => {
    const searchText = searchGame.value;
    gameItems.forEach(game =>
    {
      let searchGameNormalize = searchGame.value.trim().toLowerCase();
      let title = game.querySelector('h3').textContent;
      titleNormalize = title.trim().toLowerCase();

      if (titleNormalize.includes(searchGameNormalize))
        {
        game.style.display = "block";
        }
      else
      {
        game.style.display = "none";
      }
    })
    
})