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
  
  };
  
  