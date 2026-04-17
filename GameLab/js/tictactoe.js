const status = document.querySelector("#status");
const boxes = document.querySelectorAll(".box");
const restartBtn = document.querySelector("#restartGame");
const score = document.querySelector("#score");

let currentBox = "X";
let isActive = true;
let countX = 0;
let countO = 0;

winCombs = 
[
    [0, 1, 2],
    [3, 4, 5],
    [6, 7, 8],
    [0, 3, 6],
    [1, 4, 7],
    [2, 5, 8],
    [0, 4, 8],
    [2, 4, 6]
]

boxes.forEach((box, index) => {
       box.addEventListener('click', () => {
          if (box.textContent !== "") return;
          if (isActive == false) return;
        box.textContent = currentBox;
        
        let isDraw = true;
        if( currentBox === 'X'){
            currentBox = '0';
            box.classList.add("x");
        }  else {
            currentBox = 'X'
            box.classList.add("o");
        }

        boxes.forEach(elem =>{
          if (elem.textContent == "")
            {
              isDraw = false;
            }
        })
        if (isDraw){
            status.textContent = "Ничья";
            return;
        }

        status.textContent = 'Ходит: ' + currentBox;
        for (let comb of winCombs)
            {
                const cell1 = boxes[comb[0]].textContent;
                const cell2 = boxes[comb[1]].textContent;
                const cell3 = boxes[comb[2]].textContent;
                if (cell1 !== "" && cell1 === cell2 && cell1 === cell3) // Условие победы
                    {
                        status.textContent = `Победил ${cell1}`;
                        if (cell1 == "X")           // не cell1.textcontent, a cell1. xd
                          {
                            countX = countX + 1;
                          }
                        if (cell1 == "0")
                          {
                            countO = countO + 1;
                          }
                          score.textContent = `Счёт: X - ${countX} O - ${countO}`;
                           isActive = false;
                        break;
                    }
            }
    })
})


restartBtn.addEventListener('click',() =>
{
  boxes.forEach((box, index) =>
    {
      box.textContent = "";
      box.classList.remove("o");
      box.classList.remove("x");
      status.textContent = "Ходит: X";
      currentBox = 'X';
      isActive = true;
    })
})