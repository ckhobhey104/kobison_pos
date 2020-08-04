const PageState = function () {
  let currentState = new inventoryCategoryDetailState(this);
  this.init = function () {
    this.change(new inventoryCategoryDetailState());
  };
  this.change = function (state) {
    currentState = state;
  };
};

const DOMAIN = "http://localhost/kobison_pharmacy/public_html";

const http = new ProcessHttp();

const inventoryCategoryDetailState = function (page) {
  document.querySelector("#inventory_details_content").innerHTML = `
        <div class="card-mb-3">
        <div class="card-header bg-success" style="color:#fff;">
        <h6><i class="fa fa-shopping-cart">&nbsp;</i>Inventory List By Category
        </h6></div>
        <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered" id="view_inventory_category_details_table" width="100%" cellspacing="0">
        <thead>
        <tr>
        <th>Category</th>
        <th>Quantity</th>
        <th>Measurement Unit</th>
        <th>Total Value (GHC)</th>
        </tr>
        </thead>
        
       
        </table>
        
        </div><!--End table responsive-->
        <br/>
        </div>
    `;
};

const purchaseByDateState = function (page) {
  document.querySelector("#inventory_details_content").innerHTML = `
  <br/>  
  <form id="purchase_by_date_form" onsubmit="return false">
      <div class="row">
          <div class=" col-md-3">
              <input type="text" id="purchaseDateFrom" placeholder="From" required/>
          </div>
          <div class=" col-md-3">
              <input type="text" id="purchaseDateTo" placeholder="To"  required/>
          </div>
          <div class="col-md-2">
                  <button type="submit" class="btn btn-block btn-info">Go</button>
          </div>
  </div>
  </form> 
<br/>
  <div class="card mb-3">
  
  <div class="card-header bg-warning" style="color:#efefef;">
  <h6><i class="fas fa-chart-bar"></i>Purchase By Date Report</h6>
  </div>
  <div class="card-body">

<div class="table-responsive">
        <table class="table table-bordered" id="purchase_by_date_table" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Product</th>
              <th>Category</th>
              <th>Quantity </th>
              <th>Measurement Unit</th>
              <th>Unit Price </th>
              <th>Total Amt</th>
              <th>First Purchase</th>
              <th>Recent Purchase</th>
              
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
const inventoryBarGraphState = function (page) {
  document.querySelector("#inventory_details_content").innerHTML = `
    <h1>Some Graph</h1>
    `;
};

// Initialize
const page = new PageState();

page.init();

// UI VARS
const viewInventoryCategoryDetails = document.getElementById(
  "view_inventory_category_details"
);
const viewPurchasesByDate = document.getElementById("view_purchases_by_date");
const viewInventoryBarGraph = document.getElementById(
  "view_inventory_bar_graph"
);

// INVENTORY CATEGORY REPORT
viewInventoryCategoryDetails.addEventListener("click", (e) => {
  page.change(new inventoryCategoryDetailState());

  // LOAD CATEGORY DETAIL TABLE

  $("#view_inventory_category_details_table").DataTable({
    ajax: {
      url: DOMAIN + "/includes/process.php?viewInventoryCategoryDetails=1",
      dataSrc: "",
    },

    columns: [
      { data: "product_category" },
      { data: "product_quantity" },
      { data: "measurement_unit" },
      {
        data: null,
        render: function (data, type, row) {
          return (
            "GHC " +
            parseFloat(data.purchase_total)
              .toFixed(2)
              .toString()
              .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
          );
        },
      },
    ],
  });
  e.preventDefault();
});

// PURCHASES BY DATE
viewPurchasesByDate.addEventListener("click", (e) => {
  page.change(new purchaseByDateState());

  // PURCHASE REPORT DATE PICKER
  $("#purchaseDateFrom").datepicker({
    uiLibrary: "bootstrap4",
    format: "yyyy-mm-dd",
  });
  $("#purchaseDateTo").datepicker({
    uiLibrary: "bootstrap4",
    format: "yyyy-mm-dd",
  });

  submitPurchaseByDateForm(
    "purchase_by_date_form",
    "purchase_by_date_table",
    "purchaseDateFrom",
    "purchaseDateTo"
  );
  e.preventDefault();
});

// INVENTORY BAR GRAPH
// viewInventoryBarGraph.addEventListener("click", (e) => {
//   page.change(new inventoryBarGraphState());

//   e.preventDefault();
// });

// SUBMIT PURCHASE BY DATE FORM
function submitPurchaseByDateForm(form, datatable, fromDate, endDate) {
  let thisForm = document.getElementById(form);
  let thisFromDate = document.getElementById(fromDate);
  let thisEndDate = document.getElementById(endDate);
  let thisDatatable = document.getElementById(datatable);
  thisForm.addEventListener("submit", function () {
    $(thisDatatable).DataTable({
      ajax: {
        url:
          DOMAIN +
          "/includes/process.php?getPurchaseByDateReport&fromDate=" +
          thisFromDate.value +
          "&endDate=" +
          thisEndDate.value,
        dataSrc: "",
      },
      columns: [
        { data: "product_name" },
        { data: "category_name" },
        { data: "product_quantity" },
        { data: "product_measurement_unit" },
        { data: "unit_price" },
        {
          data: null,
          render: function (data, type, row) {
            return (
              "GHC " +
              parseFloat(data.product_quantity * data.unit_price)
                .toFixed(2)
                .toString()
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            );
          },
        },
        { data: "date_entered" },
        { data: "date_updated" },
      ],
      bDestroy: true,
    }); //End DataTable
  });
}
