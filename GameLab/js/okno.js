  const showLinks = document.querySelectorAll('.showPopup');
  const popups = document.querySelector('.popup');
  const overlay = document.querySelector('.overlay');
  const closeButtons = document.querySelectorAll('.closeBtn');

// открываются 3 popup сразу получается


  showLinks.forEach(link => {


    link.onclick = function(e) 
    {
    e.preventDefault();

    let linkId = this.getAttribute('data-id');
    let targetPopup = document.getElementById("popup-id-" + linkId);
    targetPopup.classList.add("active"); // добавл. класса active к открытому попапу
    targetPopup.style.display = 'block';
    overlay.style.display = 'block';
    };
  });

  closeButtons.forEach(btn => {
    btn.onclick = function() 
    {
    let btnId = this.getAttribute('data-id');
    let targetPopup = document.getElementById("popup-id-" + btnId);
    targetPopup.classList.remove("active"); // удал. класса active 
    targetPopup.style.display = 'none';
  
      overlay.style.display = 'none';
    };
  });

  // Закрытие при клике на фон (находится попап по классу active, и затем убирается класс)

    overlay.onclick = function() 
    {
    
    if (overlay.style.display == 'block')
    {
    let targetPopup = document.querySelector(".active");
    targetPopup.classList.remove("active");
    targetPopup.style.display = 'none';
    overlay.style.display = 'none';
    }
    };
 // });