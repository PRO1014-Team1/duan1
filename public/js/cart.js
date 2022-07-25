window.onload = function () {
  let quantities = document.querySelectorAll(".quantity");
  let total = document.querySelector(".summary__display__total");

  //tính tổng các sản phẩm
  get_total = () => {
    let summary_subtotal = document.querySelectorAll("#item_subtotal");
    let subtotal = [...summary_subtotal].map(
      (e) => +e.innerHTML.replace("Tổng: ", "")
    );
    return _.sum(subtotal);
  };
  total.innerHTML = get_total() + "đ";

  function clamp(num, min, max) {
    return Math.min(Math.max(num, min), max);
  }

  quantities.innerHTML += quantities.forEach((element) => {
    let spinner = element;
    spinner.innerHTML += `<div class="quantity-nav">
        <span class="quantity-button quantity-up">&#xf106;</span>
        <span class="quantity-button quantity-down">&#xf107;</span>
      </div>`;

    let price_each =
      element.parentElement.parentElement.querySelector("#item_price");
    let subtotal =
      element.parentElement.parentElement.querySelector("#item_subtotal");
    let input = spinner.querySelector("input");
    let btnUp = spinner.querySelector(".quantity-up");
    let btnDown = spinner.querySelector(".quantity-down");

    let min = parseInt(input.getAttribute("min"));
    let max = parseInt(input.getAttribute("max"));
    btnUp.addEventListener("click", function () {
      let oldValue = parseFloat(input.value);
      let newVal = clamp(++oldValue, min, max);

      input.value = newVal;
      input.setAttribute("value", newVal);
      subtotal.innerHTML = "Tổng: " + newVal * price_each.value;
      total.innerHTML = get_total() + "đ";
    });

    btnDown.addEventListener("click", function () {
      let oldValue = parseFloat(input.value);
      let newVal = clamp(--oldValue, min, max);

      input.value = newVal;
      input.setAttribute("value", newVal);
      subtotal.innerHTML = "Tổng: " + newVal * price_each.value;
      total.innerHTML = get_total() + "đ";
    });

    input.addEventListener("change", function (e) {
      let newVal = clamp(parseInt(e.target.value), min, max);
      input.setAttribute("value", (e.target.value = newVal));
      subtotal.innerHTML = "Tổng: " + newVal * price_each.value;
      total.innerHTML = get_total() + "đ";
    });
  });
};
