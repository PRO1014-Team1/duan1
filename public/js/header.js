window.addEventListener("load", (event) => {
  let btns = document.querySelectorAll(".nav__btn");
  let dropdowns = document.querySelectorAll(".nav__dropdown");
  
  
  btns.forEach((btn) => {
    btn.addEventListener("click", (event) => {
      let parent = event.target.parentNode;
      let dropdown = parent.children[1];
      console.log(dropdown)
      dropdowns.forEach((dd) => !dd.classList.contains("hidden") && (dd.id != dropdown.id) ? dd.classList.add("hidden") : null);
      dropdown.classList.toggle("hidden");
    });
  });
});


