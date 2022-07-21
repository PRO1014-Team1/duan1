// get all inputs with the class 'error' using query selector

window.onload = function () {
  var errorInputs = document.querySelectorAll("input.error");

  errorInputs.forEach(function (input) {
    input.addEventListener("focus", function () {
      input.classList.remove("error");
      input.placeholder = "";
    });
  });
};
