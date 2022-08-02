window.addEventListener("load", function () {
  pdfjsLib.GlobalWorkerOptions.workerSrc =
    "https://cdn.jsdelivr.net/npm/pdfjs-dist@2.14.305/build/pdf.worker.js";
  var loadingTask = pdfjsLib.getDocument("/db/book/Voynich-Manuscript.pdf");
  let doc = "/db/book/test.pdf";
  let pageMode = 1;
  let cursorIndex = Math.floor(currentPageIndex / pageMode);
  let pdfInstance = null;
  let totalPagesCount = 0;

  loadingTask.promise.then(
    function (pdf) {
      console.log("PDF loaded");
      pdfInstance = pdf;
      totalPagesCount = pdf.numPages;
      initPager();
      render();
    },
    function (reason) {
      // PDF loading error
      console.error(reason);
    }
  );

  function initPager() {
    const pager = document.querySelector("#pager");
    pager.addEventListener("click", onPagerButtonsClick);
    return () => {
      pager.removeEventListener("click", onPagerButtonsClick);
    };
  }
  function onPagerButtonsClick(event) {
    let counter = document.querySelector(".counter");
    const action = event.target.getAttribute("data-pager");
    if (action === "prev") {
      if (currentPageIndex === 0) {
        return;
      }
      currentPageIndex -= pageMode;
      if (currentPageIndex < 0) {
        currentPageIndex = 0;
      }
      render();
    }
    if (action === "next") {
      if (currentPageIndex === totalPagesCount - 1) {
        return;
      }
      currentPageIndex += pageMode;
      if (currentPageIndex > totalPagesCount - 1) {
        currentPageIndex = totalPagesCount - 1;
      }
      render();
    }
    counter.innerHTML = currentPageIndex;
  }

  function render() {
    pdfInstance.getPage(currentPageIndex).then(function (page) {
      // console.log("Page loaded");
      var scale = 1;
      var viewport = page.getViewport({ scale: scale });

      // Prepare canvas using PDF page dimensions
      var canvas = document.getElementById("viewport");
      var context = canvas.getContext("2d");
      canvas.height = viewport.height;
      canvas.width = viewport.width;

      // Render PDF page into canvas context
      var renderContext = {
        canvasContext: context,
        viewport: viewport,
      };
      var renderTask = page.render(renderContext);
    });
  }

  let bookmark_btn = document.getElementById("bookmark");
  bookmark_btn.addEventListener("click", function () {
    
    let bookmark_list = document.getElementById("current-page");
    
    bookmark_list.value = currentPageIndex;
  });
});
