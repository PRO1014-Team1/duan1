window.onload = function () {
  let isDetail = false;
  const ctx = document.getElementById("product_chart").getContext("2d");
  const ctx_2 = document.getElementById("popularity_chart").getContext("2d");
  let labels = _.map(data, "name");
  let category_count = _.map(data, "count");
  let category_view = _.map(categoryView, "view");
  let comment_count = _.map(_.merge(comment, categoryView), "comment_count");
  comment_count = Array.from(comment_count, (item) => item || "0");
  let pieColors = _.times(data.length, randomHSL);
  let pie_config = {
    type: "pie",
    data: {
      labels: labels,
      datasets: [
        {
          data: category_count,
          backgroundColor: pieColors,
          borderColor: pieColors,
          borderWidth: 1,
        },
      ],
    },
    options: {
      plugins: {
        responsive: true,
        legend: {
          display: true,
          position: "bottom",
          labels: {
            fontColor: "black",
          },
        },
        title: {
          display: true,
          text: "Thống kê danh mục sản phẩm",
          fontSize: 20,
          fontColor: "black",
        },
        tooltip: {
          enabled: true,
          callbacks: {
            footer: (ttItem) => {
              let sum = 0;
              let dataArr = ttItem[0].dataset.data;
              dataArr.map((data) => {
                sum += Number(data);
              });

              let percentage =
                ((ttItem[0].parsed * 100) / sum).toFixed(2) + "%";
              return `Chiếm: ${percentage}`;
            },
          },
        },
        datalabels: {
          formatter: (value, dnct1) => {
            let sum = 0;
            let dataArr = dnct1.chart.data.datasets[0].data;
            dataArr.map((data) => {
              sum += Number(data);
            });

            let percentage = ((value * 100) / sum).toFixed(2) + "%";
            return percentage;
          },
        },
      },
    },
  };
  let mixed_config = {
    type: "scatter",
    data: {
      datasets: [
        {
          type: "bar",
          label: "Số bình luận",
          data: comment_count,
          backgroundColor: randomHSL(),
        },
        {
          type: "line",
          label: "Số lượt xem",
          data: category_view,
          fill: false,
          backgroundColor: "transparent",
          borderColor: randomHSL(),
        },
      ],
      labels: labels,
    },
    options: {
      title: {
        display: true,
        text: "Tỉ lệ sản phẩm",
        fontSize: 20,
        fontColor: "black",
      },
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  };
  const pieChart = new Chart(ctx, pie_config);
  const mixedChart = new Chart(ctx_2, mixed_config);

  //doi du lieu
  let detail = document.querySelector(".detail");
  let product_detail = (product = _.dropRight(
    product,
    product.length - categoryView.length
  ));
  
  detail.addEventListener("click", function () {
    updateData(
      mixedChart,
      _.map(product_detail, "name"),
      _.map(product_detail, "view")
    );
  });
};

function randomHSL() {
  var h = Math.floor(_.random(0, 360));
  var s = Math.floor(_.random(20, 100));
  var l = 85;
  return "hsl(" + h + "," + s + "%," + l + "%)";
}

function updateData(chart, label, data, isDetail = true) {
  if (isDetail) {
    chart.data.labels = label;
    chart.data.datasets.data = data;
    chart.update();
  } else {
    chart.data.labels = labels;
    chart.data.datasets.data = category_view;
    chart.update();
  }
  isDetail = !isDetail;
}
