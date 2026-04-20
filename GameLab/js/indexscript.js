const banners = document.querySelectorAll(".banner");
const nextBtn = document.querySelector("#nextBtn");
const prevBtn = document.querySelector("#prevBtn");
const circles = document.querySelectorAll(".circle");

let indexBanner = 0;
let indexCircle = 0;
let timerSlider;

banners[indexBanner].classList.add("active");

startSlider();
freezeSlider();
unfreezeSlider();










nextBtn.addEventListener("click", () =>
  { 
    nextSlide();
    })

prevBtn.addEventListener("click", () =>
  {
    prevSlide();
  })


circles.forEach((circle, i) => {   // аргуементы в СКОБКАХ

  circle.addEventListener("click", () =>
    {
    circles.forEach(circle => 
      {
        circle.classList.remove("circleActive"); // удаление active у всех индикаторов
      })
      indexCircle = i;
      circles[indexCircle].classList.add("circleActive");  // добавление active к нажатому в eventListener
      banners[indexBanner].classList.remove("active");
      indexBanner = indexCircle;                           // приравнивание баннера к нажатому индикатору.
      banners[indexBanner].classList.add("active");
      startSlider();
    })
})

function nextSlide()        // переклю. на следующий слайд (для кнопки)
{
  circles[indexBanner].classList.remove("circleActive");
    banners[indexBanner].classList.remove("active"); 
    indexBanner++;
    if (indexBanner > 2) indexBanner = 0;

    banners[indexBanner].classList.add("active");
    circles[indexBanner].classList.add("circleActive");
    startSlider();
}

function prevSlide()          // переклю. на предыдущий слайд (для кнопки)
{
  banners[indexBanner].classList.remove("active");
    circles[indexBanner].classList.remove("circleActive");
    indexBanner--;
    if (indexBanner < 0) indexBanner = 2;
    banners[indexBanner].classList.add("active");
    circles[indexBanner].classList.add("circleActive");
    startSlider();
}

function freezeSlider()
{
  banners.forEach((banner, i) =>
    {
      banner.addEventListener("mouseenter", () =>
        {
          clearInterval(timerSlider);
        })
    })
}

function unfreezeSlider(){
  banners.forEach((banner, i) =>
{
  banner.addEventListener("mouseleave", () =>
    {
      startSlider();
    })
  })
}

function startSlider()   // таймер 3с на автоматическое переключение слайдов
{
  clearInterval(timerSlider);  // обнуляет время при перелистывании 
  timerSlider = setInterval(() =>
  {
    nextSlide();
  }, 3000);
}

