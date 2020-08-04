// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily =
  '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#292b2c";

const thisDOMAIN = "http://localhost/kobison_pharmacy/public_html";

if (document.getElementById("monthlySalesChart") !== null) {
  getMonthlySalesReport();
}
if (document.getElementById("dailySalesMarginChart") !== null) {
  getDailyMarginReport();
}

function getMonthlySalesReport() {
  const thisHttp = new ProcessHttp();
  thisHttp.get(
    thisDOMAIN + "/includes/process.php?getInitialMonthlySalesReport=1",
    function (err, post) {
      if (err) {
        console.log(err);
      } else {
        let data = JSON.parse(post);
        let month = [];
        let sales = [];
        for (let i in data) {
          month.push(data[i].month);
          sales.push(parseFloat(data[i].total_sales).toFixed(2));
        }
        // DRAW BAR CHART
        let ctx1 = document.getElementById("monthlySalesChart");
        let myLineChart = new Chart(ctx1, {
          type: "bar",
          data: {
            labels: month,
            datasets: [
              {
                label: "Revenue",
                backgroundColor: "rgba(2,117,216,1)",
                borderColor: "rgba(2,117,216,1)",
                data: sales,
              },
            ],
          },
          options: {
            scales: {
              xAxes: [
                {
                  time: {
                    unit: "month",
                  },
                  gridLines: {
                    display: false,
                  },
                  ticks: {
                    maxTicksLimit: 6,
                  },
                },
              ],
              yAxes: [
                {
                  ticks: {
                    min: 0,
                    max: 15000,
                    maxTicksLimit: 5,
                  },
                  gridLines: {
                    display: true,
                  },
                },
              ],
            },
            legend: {
              display: false,
            },
          },
        });
      }
    }
  );
}

function getDailyMarginReport() {
  const thisHttp = new ProcessHttp();
  thisHttp.get(
    thisDOMAIN + "/includes/process.php?getInitialDailyMarginReport=1",
    function (err, get) {
      if (err) {
        console.log(err);
      } else {
        let data = JSON.parse(get);
        let cost = data[0].cost;
        let revenue = data[0].revenue;
        // DRAW PIE CHART
        let ctx2 = document.getElementById("dailySalesMarginChart");
        let myPieChart = new Chart(ctx2, {
          type: "pie",
          data: {
            labels: ["Cost Of Sale For the Day", "Total Revenue For the Day"],
            datasets: [
              {
                data: [cost, revenue],
                backgroundColor: ["#007bff", "#28a745"],
              },
            ],
          },
        });
      }
    }
  );
}
