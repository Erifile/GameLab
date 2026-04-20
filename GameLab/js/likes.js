const likes = document.querySelectorAll(".favourite");


likes.forEach(btn =>
    {
      btn.addEventListener("click", (e) => 
        {
          e.preventDefault();

          // привязываем id игры через атрибут data-id у кнопки (по идее можно и к popup, там тот же data-id)
        const gameId = btn.getAttribute('data-id');


   // Обработка лайка в реальном времени через какой то там ваш AJAX
        const formData = new FormData();
        formData.append('game_id', gameId); // game_id - просто ключ, чтобы обратиться к нему через php-обработчик.
            
        fetch('php/like_handler.php', { // в пути была проблема..??
        method: 'POST',
        body: formData
        })

        .then(response => response.text()) // превращает ответ like.handler (echo) в текст
        .then(data => { // ответ в виде текста
          if (data === "added")
            {
              btn.dataset.like = 'true';
              btn.textContent = "❤︎⁠";
            }
          if (data === "removed")
              {
                btn.dataset.like = 'false';
                btn.textContent = "♡⁠";
              }
          if (data === "auth_error")
            {
              alert("Чтобы добавить игру в избранное, необходимо авторизоваться.");
            }
          if (data === "db_error")
            {
              alert("Кто-то сломал подключение к базе данных.");
            }
        });
   //

    })});