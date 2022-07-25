window.addEventListener("load", () => {
  let con = document.querySelector("#nav-toggle");
  let currentURL = window.location.pathname;
  let sidebarCards = document.querySelectorAll(".sidebar__card");

  // đổi icon khi click vào menu icon
  con.addEventListener("click", (event) => {
    let sidebar = document.querySelector(".admin-sidebar");
    let nav = document.querySelector(".nav");
    let icon = event.target.labels[0].children[0].childNodes;

    sidebar.classList.add("sidebar-animate");
    nav.classList.add("nav-animate");

    icon.forEach((node) => {
      if (node.nodeType == 1) {
        for (var i = 0, l = node.classList.length; i < l; ++i) {
          let target;
          if ((target = node.classList[i].match(/.*-r/))) {
            node.classList.replace(target[0], target[0].replace("-r", ""));
            break;
          } else if ((target = node.classList[i].match(/arrow.*/))) {
            node.classList.replace(
              target[0],
              target[0].replace(/(arrow.*)/, "$1-r")
            );
            break;
          }
        }
      }
    });
  });

  (function highlight() {
    sidebarCards.forEach((card) => {
      let id = card.id;

      if (id === currentURL.replace("/", "")) {
        card.setAttribute("data-active", true);
      } else {
        card.setAttribute("data-active", false);
      }
    });
  })();
});
