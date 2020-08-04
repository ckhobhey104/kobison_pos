const PageState = function () {
  let currentState = new dailySalesState(this);
  this.init = function () {
    this.change(new dailySalesState());
  };
  this.change = function (state) {
    currentState = state;
  };
};
const DOMAIN = "http://localhost/kobison_pharmacy/public_html";

const http = new ProcessHttp();

const dailySalesState = function (page) {
  document.querySelector("#sales_report_content").innerHTML = `
    <!-- Report content here -->
    <br/>  
    <form id="stock_sales_report_form" onsubmit="return false">
        <div class="row">
            <div class=" col-md-3">
                <input type="text" id="orderDateFrom" placeholder="From" required/>
            </div>
            <div class=" col-md-3">
                <input type="text" id="orderDateTo" placeholder="To"  required/>
            </div>
            <div class="col-md-2">
                    <button type="submit" class="btn btn-block btn-info">Go</button>
            </div>
    </div>
    </form> 
<br/>
    <div class="card mb-3">
    
    <div class="card-header bg-warning" style="color:#efefef;">
    <h6><i class="fas fa-chart-bar"></i>Daily Stock Sales Report</h6>
    </div>
    <div class="card-body">

<div class="table-responsive">
          <table class="table table-bordered" id="daily_sales_report_table" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Product</th>
                <th>Qty Sold</th>
                <th>Total Amt</th>
                <th>Margin</th>
                
                <!-- <th>Action</th> -->
              </tr>
            </thead>
             <tbody id="daily_sales_tbody">
               <!-- <tr>
                <td>1</td>
                <td>Tablet</td>
                <td>Small Tablets</td>
                <td>
                  <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-edit">&nbsp;</i>Edit</a>
                  <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-times">&nbsp;</i>Delete</a>
                </td>
              </tr> -->
    
            </tbody>
          </table>
        </div>
    
    </div>
    </div>            
    <br />  
    `;
};

const monthlyChartState = function (page) {
  document.querySelector("#sales_report_content").innerHTML = `
  <div class="card mb-3">
          <div class="card-header bg-bluish" style="color:#eee;">
            <h6><i class="fas fa-chart-area"></i>
            Monthly Sales Margin</h6></div>
          <div class="card-body">
            <canvas id="monthly_margin_chart" width="100%" height="30"></canvas>
          </div>
          </div>
    
    `;
};

// Initialize
const page = new PageState();

page.init();

// UI VARS
const viewDailySales = document.getElementById("view_daily_sales_report");
const viewCharts = document.getElementById("view_charts");

// DAILY SALES REPORT
viewDailySales.addEventListener("click", (e) => {
  page.change(new dailySalesState());

  // SALES REPORTS DATE PICKER
  $("#orderDateFrom").datepicker({
    uiLibrary: "bootstrap4",
    format: "yyyy-mm-dd",
  });
  $("#orderDateTo").datepicker({
    uiLibrary: "bootstrap4",
    format: "yyyy-mm-dd",
  });

  submitDailySalesReportForm(
    "stock_sales_report_form",
    "daily_sales_report_table",
    "orderDateFrom",
    "orderDateTo"
  );
  showCardData(
    "stock_sales_report_form",
    "orderDateFrom",
    "orderDateTo",
    "sales_card",
    "cost_of_sales_card",
    "sales_margin_card"
  );

  e.preventDefault();
});

// VIEW CHART
viewCharts.addEventListener("click", (e) => {
  page.change(new monthlyChartState());

  // Show Area Chart
  showMonthlyMarginGraph("monthly_margin_chart");
  e.preventDefault();
});

// SUBMIT DAILY SALES REPORT FORM
function submitDailySalesReportForm(form, datatable, fromDate, endDate) {
  let thisForm = document.getElementById(form);
  let thisFromDate = document.getElementById(fromDate);
  let thisEndDate = document.getElementById(endDate);
  let thisDatatable = document.getElementById(datatable);
  thisForm.addEventListener("submit", function () {
    $(thisDatatable).DataTable({
      ajax: {
        url:
          DOMAIN +
          "/includes/process.php?getDailySalesReport&fromDate=" +
          thisFromDate.value +
          "&endDate=" +
          thisEndDate.value,
        dataSrc: "",
      },
      columns: [
        { data: "product_name" },
        { data: "sale_quantity" },
        { data: "sale_amount" },
        { data: "sales_margin" },
      ],
      bDestroy: true,
    }); //End DataTable
  });
}
function showCardData(
  form,
  fromDate,
  endDate,
  salesCard,
  costCard,
  marginCard
) {
  let thisForm = document.getElementById(form);
  let thisFromDate = document.getElementById(fromDate);
  let thisEndDate = document.getElementById(endDate);
  let thisSalesCard = document.getElementById(salesCard);
  let thisCostCard = document.getElementById(costCard);
  let thisMarginCard = document.getElementById(marginCard);
  thisForm.addEventListener("submit", function () {
    http.get(
      DOMAIN +
        "/includes/process.php?getDailySalesSummaryByDate&fromDate=" +
        thisFromDate.value +
        "&endDate=" +
        thisEndDate.value,
      function (err, get) {
        if (err) {
          console.log(err);
        } else {
          result = JSON.parse(get);
          console.log(result);
          thisSalesCard.textContent = " GHC " + result[0]["sales"];
          thisCostCard.textContent = " GHC " + result[0]["cost_of_sales"];
          thisMarginCard.textContent = " GHC " + result[0]["sales_margin"];
        }
      }
    );
  });
}

// AREA CHART
function showMonthlyMarginGraph(id) {
  // const thisHttp = new ProcessHttp();
  http.get(DOMAIN + "/includes/process.php?getMonthlyMargin=1", (err, get) => {
    if (err) {
      console.log(err);
    } else {
      let data = JSON.parse(get);
      let month = [],
        margin = [];
      for (let i in data) {
        month.push(data[i].month);
        margin.push(parseFloat(data[i].sales_margin).toFixed(2));
      }
      // DRAW LINE CHART
      let ctx3 = document.getElementById(id);
      var myLineChart = new Chart(ctx3, {
        type: "line",
        data: {
          labels: month,
          datasets: [
            {
              label: "Sales Margin",
              lineTension: 0.3,
              backgroundColor: "rgba(116, 216, 2, 0.3)",
              borderColor: "rgba(2,117,216,1)",
              pointRadius: 5,
              pointBackgroundColor: "rgba(2,117,216,1)",
              pointBorderColor: "rgba(255,255,255,0.8)",
              pointHoverRadius: 5,
              pointHoverBackgroundColor: "rgba(2,117,216,1)",
              pointHitRadius: 50,
              pointBorderWidth: 2,
              data: margin,
            },
          ],
        },
        options: {
          scales: {
            xAxes: [
              {
                time: {
                  unit: "date",
                },
                gridLines: {
                  display: false,
                },
                ticks: {
                  maxTicksLimit: 7,
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
                  color: "rgba(0, 0, 0, .125)",
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
  });
}
