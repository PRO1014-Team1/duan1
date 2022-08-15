window.onload = function () {
  let quantities = document.querySelector(".quantity");
  let total = document.querySelector(".summary__display__total");

  //tính tổng các sản phẩm
  get_total = () => {
    let summary_subtotal = document.querySelectorAll("#item_subtotal");
    let subtotal = [...summary_subtotal].map(
      (e) => +e.innerHTML.replace("Tổng: ", "")
    );
    return _.sum(subtotal);
  };
  total.innerHTML = asvnd(get_total());

  function clamp(num, min, max) {
    return Math.min(Math.max(num, min), max);
  }

  function asvnd(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "đ";
  }

  //thêm điều khiển số lượng sản phẩm
  let spinner = quantities;
  spinner.innerHTML += `<div class="quantity-nav">
        <span class="quantity-button quantity-up">&#xf106;</span>
        <span class="quantity-button quantity-down">&#xf107;</span>
      </div>`;

  let input = spinner.querySelector("input");
  let btnUp = spinner.querySelector(".quantity-up");
  let btnDown = spinner.querySelector(".quantity-down");
  let min = parseInt(input.getAttribute("min"));
  let max = parseInt(input.getAttribute("max"));

  btnUp.addEventListener("click", function (event) {
    let oldValue = parseFloat(input.value);
    let newVal = clamp(++oldValue, min, max);
    let subtotal =
      event.target.parentElement.parentElement.parentElement.querySelector(
        "#item_subtotal"
      );
    let price =
      event.target.parentElement.parentElement.parentElement.querySelector(
        "#item_price"
      );

    input.value = newVal;
    input.setAttribute("value", newVal);
    subtotal.innerHTML = "Tổng: " + newVal * price.value;
    total.innerHTML = asvnd(get_total());
  });

  btnDown.addEventListener("click", function (event) {
    let parent = event.target.parentElement.parentElement.parentElement;
    let oldValue = parseFloat(input.value);
    let newVal = clamp(--oldValue, min, max);
    let subtotal = parent.querySelector("#item_subtotal");
    let price = parent.querySelector("#item_price");

    input.value = newVal;
    input.setAttribute("value", newVal);
    subtotal.innerHTML = "Tổng: " + newVal * price.value;
    total.innerHTML = asvnd(get_total());
  });

  input.addEventListener("change", function (e) {
    let parent = e.target.parentElement.parentElement;
    let subtotal = parent.querySelector("#item_subtotal");
    let price = parent.querySelector("#item_price");
    let newVal = clamp(parseInt(e.target.value), min, max);
    input.value = newVal;
    input.setAttribute("value", (e.target.value = newVal));
    subtotal.innerHTML = "Tổng: " + newVal * price.value;
    total.innerHTML = asvnd(get_total());
  });
};
