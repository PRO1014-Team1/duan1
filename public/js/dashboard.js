window.addEventListener("load", function () {
  const sale_canvas = document.getElementById("sale-chart");
  const ctx = sale_canvas.getContext("2d");
  const sale_data = {
    labels: [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "May",
      "Jun",
      "Jul",
      "Aug",
      "Sep",
      "Oct",
      "Nov",
      "Dec",
    ],
    datasets: [
      {
        label: "Sales",
        backgroundColor: "rgb(255, 99, 132)",
        fill: true,
        data: [
          { x: 0, y: 0 },
          { x: 1, y: 1 },
          { x: 2, y: 5 },
          { x: 3, y: 10 },
          { x: 4, y: 50 },
          { x: 5, y: 100 },
          { x: 6, y: 500 },
          { x: 7, y: 1000 },
          { x: 8, y: 1000 },
          { x: 9, y: 5000 },
          { x: 10, y: 1000 },
          { x: 11, y: 1000 },
        ],
        backgroundColor: "rgba(255, 99, 132, 0.2)",
        barThickness: "flex",
        barPercentage: 0.5,
      },
    ],
  };
  const sale_config = {
    type: "line",
    data: sale_data,
    options: {
      responsive: true,
      elements: {
        line: {
          tension: 0.5,
        },
      },
      plugins: {
        tooltip: {
          callbacks: {
            label: function (context) {
              let label = context.dataset.label || "";
              if (label) {
                label += ": ";
              }
              if (context.parsed.y !== null) {
                // shorten number and add triệu or nghìn
                num = context.parsed.y;
                if (num >= 1000000) {
                  num = (num / 1000000).toFixed(1) + " triệu";
                } else if (num >= 1000) {
                  num = (num / 1000).toFixed(1) + " nghìn";
                }
                label += num + " đồng";
              }
              return label;
            },
          },
        },
      },
      title: {
        display: true,
        text: "Sales Chart",
      },
      tooltips: {
        mode: "index",
        intersect: false,
      },
      hover: {
        mode: "nearest",
        intersect: true,
      },
      scales: {
        y: {
          title: {
            display: true,
            text: "Triệu đồng",
          },
          ticks: {
            callback: function (value, index, ticks) {
              return value + "₫";
            },
          },
        },
        x: {
          title: {
            display: true,
            text: "Tháng",
          },
        },
      },
    },
  };
  const sale_chart = new Chart(ctx, sale_config);

  const variant = document.getElementById("variant-chart");
  const ctx2 = variant.getContext("2d");
  const variant_data = {
    labels: ["Bìa mềm", "Bìa cứng", "Ebook", "Audiobook"],
    datasets: [
      {
        label: "Số sản phẩm đã bán",
        data: [20, 50, 100, 550],
        backgroundColor: _.map(Array(4), rand_hsl),
        fill: false,
      },
    ],
  };
  const variant_config = {
    type: "pie",
    data: variant_data,
    options: {
      responsive: true,
      plugins: {
        tooltips: {
          mode: "index",
          intersect: false,
        },
        hover: {
          mode: "nearest",
          intersect: true,
        },
      },
    },
    plugins: [
      {
        beforeDraw: function (chart) {
          const datasetMeta = chart.getDatasetMeta(0);
          const innerRadius = datasetMeta.controller.innerRadius;
          const outerRadius = datasetMeta.controller.outerRadius;
          const heightOfItem = outerRadius - innerRadius;
          const countOfData = chart.getDatasetMeta(0).data.length;
          const additionalRadius = Math.floor(heightOfItem / countOfData);
          const weightsMap = datasetMeta.data
            .map((v) => v.circumference)
            .sort((a, b) => a - b)
            .reduce((a, c, ci) => {
              a.set(c, ci + 1);
              return a;
            }, new Map());

          datasetMeta.data.forEach((dataItem) => {
            const weight = weightsMap.get(dataItem.circumference);
            dataItem.outerRadius = innerRadius + additionalRadius * weight;
          });
        },
      },
    ],
  };
  const variant_chart = new Chart(ctx2, variant_config);

  const product = document.getElementById("product-chart");
  const ctx3 = product.getContext("2d");

  const product_data = {
    labels: ["Sách A", "Sách B", "Sách C", "Sách D"],
    datasets: [
      {
        label: "Số sản phẩm đã bán",
        data: [20, 50, 100, 550],
        backgroundColor: _.map(Array(4), soft_rand_hsl),
        fill: false,
      },
    ],
  };
  const product_config = {
    type: "bar",
    data: product_data,
    options: {
      responsive: true,
      indexAxis: "y",
      // Elements options apply to all of the options unless overridden in a dataset
      // In this case, we are setting the border of each horizontal bar to be 2px wide
      elements: {
        bar: {
          borderWidth: 2,
        },
      },
      plugins: {
        tooltips: {
          mode: "index",
          intersect: false,
        },
        hover: {
          mode: "nearest",
          intersect: true,
        },
      },
    },
  };
  const product_chart = new Chart(ctx3, product_config);


  //helper functions
  function hsl_generator(h, s, l) {
    return "hsl(" + h + "," + s + "%," + l + "%)";
  }

  function rand_hsl() {
    return hsl_generator(
      Math.ceil(_.random(360)),
      _.random(100),
      _.random(50, 100)
    );
  }

  //function soft color rand_hsl
  function soft_rand_hsl() {
    return hsl_generator(
      Math.ceil(_.random(360)),
      _.random(50),
      _.random(70, 100)
    );
  }
});
