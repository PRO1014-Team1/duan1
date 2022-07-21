window.onload = function () {
    let deselectAll = document.querySelector(".deselect_all");
    let selectAll = document.querySelector(".select_all");
  
    deselectAll.addEventListener("click", function () {
      let checkboxes = document.querySelectorAll(".selected");
      for (let i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = false;
      }
    });
  
    selectAll.addEventListener("click", function () {
      let checkboxes = document.querySelectorAll(".selected");
      for (let i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = true;
      }
    });
    
    let btns = document.querySelectorAll(".table__options_btn");
    let dropdowns = document.querySelectorAll(".table__options_dropdown");
    
    
    btns.forEach((btn) => {
      btn.addEventListener("click", (event) => {
        let dropdown = event.target.nextElementSibling;
        dropdown.classList.toggle("hidden");
      });
    });
  
  };
  
  