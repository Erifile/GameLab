const form = document.querySelector("#cityForm");
const cityInput = document.querySelector("#cityInput");
const status = document.querySelector("#status");
const history = document.querySelector("#history");
const forbiddenLetters = new Set(["ь", "ы", "ъ", "й"]);
const submitBtn = document.querySelector("#submitBtn");
const usedCities = new Set(); // коллекция (только уникальные зн.)
const startBtn = document.querySelector("#start");
let cities = [];
let citiesNormalized;


// 3 функции: loadCities(), main(), init()

// ЗАГРУЗКА СПИСКА ГОРОДОВ 
async function loadCities() {
  try {
    console.log("Загрузка..")
    const response = await fetch('cities/cities.json'); // путь относительно ВЕБ-СТРАНИЦЫ, а не этого файла
    let cities = await response.json();
    citiesNormalized = cities.map(city => {  // приведение всех строк с названиями городов в загруженном json-массиве к нижнему регистру.
      return city.trim().toLowerCase();
    });
    console.log("Список городов загружен.");
  } catch (error) {
    console.log('Ошибка загрузки списка городов:', error);
  }
};

init(); // ПУСК ЛОГИКИ ИГРЫ ПОСЛЕ ПОДГРУЗКИ СПИСКА ГОРОДОВ



async function init() {
  await loadCities(); // Ждем города
  if (citiesNormalized) main(); // Когда города есть, запускаем логику
}



// ЛОГИКА ИГРЫ
function main()
{
let i = 0;

let lastLetter = null;
const timerEl = document.querySelector("#timer");
let timeLeft = 10;
let timerInterval;

cityInput.disabled = true;
submitBtn.disabled = true;

 // Таймер //
function timer() 
{
  timerInterval = setInterval(() =>
    {
      timeLeft--;
      timerEl.textContent = `Время на ход: ${timeLeft}`;
       if (timeLeft == 0) {
        clearInterval(timerInterval);
        status.style.color = "black";
        status.textContent = "Игра окончена";
        form.reset();
        cityInput.disabled = true;
        submitBtn.disabled = true;
        startBtn.disabled = false;
      };
    }, 1000);
}

// Кнопка запуска игры //
startBtn.addEventListener("click", () => 
{
status.textContent = "Ходит игрок 1";
history.replaceChildren("История ответов:");
usedCities.clear();
lastLetter = null;
cityInput.disabled = false;
submitBtn.disabled = false;
startBtn.disabled = true;
timeLeft = 11;
timer();
})


// Отправка ответа и его условные проверки //
form.addEventListener("submit", (event) => 
  { 

    event.preventDefault(); // отменяет обычное поведение браузера для этого события (в данном случае - отмена перезагрузки после отправки формы)
    const city = cityInput.value; // значение, введённое пользователем
    const cityNormalize = city.trim().toLowerCase();
    
    if (cityNormalize === "") {
      status.textContent = "Ошибка. Введите город";
      status.style.color = "red";
      form.reset();
      return; // чтобы снова вернуться к проверке формы
    }

    if (!citiesNormalized.includes(cityNormalize)) {
      status.textContent = "Ошибка. Город не существует";
      status.style.color = "red";
      form.reset();
      return; // чтобы снова вернуться к проверке формы
    }

    if (usedCities.has(cityNormalize))
    {
      status.textContent = "Ошибка. Город уже был назван";
      status.style.color = "red";
      form.reset();
      return;
    }
        
    // Проверка на последнюю букву (сработает только с 2 хода и дальше. т.к. изначально null)
    if (lastLetter !== cityNormalize[0] && lastLetter !== null) // lastLetter
      {
          status.textContent = `Ошибка. Введите город, начинающийся на букву "${lastLetter}"`;
          status.style.color = "red";
          form.reset();
          return;
      }
    // Создание/изменение последней буквы, если она запретная
    for(let i = cityNormalize.length - 1; i >= 0; i--)
          {
            if (!forbiddenLetters.has(cityNormalize[i]))
              {
                lastLetter = cityNormalize[i];
                break;
              }
          }
      console.log(lastLetter);
   

    form.reset(); // очистка формы
    usedCities.add(cityNormalize); // добавление города в список использованных
    const li = document.createElement("li");
    history.appendChild(li);
    li.textContent = city;
    
  // Перезапуск таймера
  clearInterval(timerInterval);
  timeLeft = 11;
  timer();

    // Проверка на чётность (ход игрока)
    i++;
    if(i % 2 > 0)
      {
        status.style.color = "black";
        status.textContent = "Ходит игрок 2";
      }
    else
      {
        status.style.color = "black";
        status.textContent = "Ходит игрок 1";
      }
    
      })
    }
    

