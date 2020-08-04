const PageState = function () {
  let currentState = new viewState(this);

  this.init = function () {
    this.change(new viewState());
  };
  this.change = function (state) {
    currentState = state;
  };
};
const DOMAIN = "http://localhost/kobison_pharmacy/public_html";

const http = new ProcessHttp();
//View Product State
const viewState = function (page) {
  document.querySelector("#product_content").innerHTML = `
    <div class="card mb-3">
          <div class="card-header bg-primary" style="color:#fff;">
            <h6><i class="fas fa-table"></i>
            List Of Products</div>
          </h6><div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="product_list" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Prod.</th>
                    <th>Category</th>
                    <th>Unt Prc.</th>
                    <th>In Stock</th>
                    <th>Measurement Unit</th>
                    <th>Reorder Level</th>
                    <th>Batch No.</th>
                    <th>Expiry</th>
                    <th>Sell Prc</th>
                    <th>Status</th>
                    <th>Date Entered</th>
                    <th>Date Updated</th>
                  </tr>
                </thead>
                 <tbody>
                 <!-- <tr>
                    <td>Paracetamol</td>
                    <td>Tablet</td>
                    <td>Ghc10.00</td>
                    <td>10</td>
                    <td>B00112</td>
                    <td>01-12-2020</td>
                    <td>Ghc15.00</td>
                    <td><a href="#" class="btn btn-sm btn-success">Active</a></td>
                  </tr>
                  <tr>
                    <td>Pineoplex</td>
                    <td>Syrup</td>
                    <td>Ghc5.00</td>
                    <td>15</td>
                    <td>C00141</td>
                    <td>01-09-2020</td>
                    <td>Ghc8.00</td>
                    <td><a href="#" class="btn btn-sm btn-secondary">Expired</a></td>
                </tr>    -->
                </tbody>
              </table>
            </div>
          </div>
          <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
        </div><!-- End Card for view products -->
    `;
};
const addState = function (page) {
  document.querySelector("#product_content").innerHTML = `
    <div class="card-mb-3">
        <div class="card-header bg-primary" style="color:#fff;">
        <h6><i class="fa fa-plus">&nbsp;</i>Add Stock
        </h6></div>
        <div class="card-body">
        <form id="add_product_form" onsubmit="return false">
        <div class="table-responsive">
        <table class="table table-bordered" id="add_product_table" width="100%" cellspacing="0">
        <thead>
        <tr>
        <th>Prod.</th>
        <th>Category</th>
        <th>Barcode</th>
        <th>Unt.Prc</th>
        <th>Qty</th>
        <th>Measurement Unt.</th>
        <th>Reorder Qty</th>
        <th>Batch No</th>
        <th>Expiry</th>
        <th>Sell Prc</th>
        <th></th>
        </tr>
        </thead>
        
        <tbody>
        <tr>
        <td>
        <input type="text" name="product_name" id="product_name" required="required" class="form-control form-control-sm"></td>
        <td>
        <select name="product_category" id="product_category" class="form-control form-control-sm selectpicker" data-live-search="true" placeholder="office" required="required">
               <!--<option value="">Select Catagory</option>
                <option value="1">Syrup</option>
                <option value="2">Tablet</option>
                <option value="2">Condom</option>-->
              </select>
        </td>
        <td><input type="text" name="product_barcode" id="product_barcode" class="form-control form-control-sm"> </td>
        <td><input type="text" name="unit_prc" id="unit_prc" required="required" class="form-control form-control-sm"></td>
        <td><input type="number" name="product_qty" id="product_qty" required="required" class="form-control form-control-sm"></td>
        <td>
        <select name="product_measurement_unit" id="product_measurement_unit" class="form-control form-control-sm  placeholder="office">
               <option value="">Select Measurement Unit</option>
                <option value="Bags">Bags</option>
                <option value="Barrels">Barrels</option>
                <option value="Blister Packs">Blister Packs</option>
                <option value="Bottles">Bottles</option>
                <option value="Boxes">Boxes</option>
                <option value="Misc">Misc</option>
                <option value="Cans">Cans</option>
                <option value="Cartons">Cartons</option>
                <option value="Pieces">Pieces</option>
                <option value="Sacks">Sacks</option>
                <option value="Sachets">Sachets</option>
                <option value="Stripes">Stripes</option>
                <option value="Tubes">Tubes</option>
                <option value="Vials">Vials</option>                
              </select>
        </td>
        <td><input type="number" name="product_reorder_qty" id="product_reorder_qty" class="form-control form-control-sm"></td>
        <td><input type="text" name="batch_no" id="batch_no" class="form-control form-control-sm"></td>
        <td><input type="text" name="product_expiry" id="product_expiry"></td>
        <td><input type="text" name="selling_prc" id="selling_prc" required="required" class="form-control form-control-sm"></td>
        <td><input type="submit" class="btn btn-sm btn-primary"></td>
        </tr>
        </tbody>
        </table>
        </div><!--End table responsive div-->       
        </form>
        <div id="add_product_form_output">
        <div class="table-responsive">
        <table class="table table-bordered" id="add_product_table_output" width="100%" cellspacing="0">
        <tfoot>
        <tr>
        <th>Prod.</th>
        <th>Category</th>
        <th>Barcode</th>
        <th>Unt.Prc</th>
        <th>Qty</th>
        <th>Measurement Unt.</th>
        <th>Reorder Qty</th>
        <th>Batch No</th>
        <th>Expiry</th>
        <th>Sell Prc</th>
        <th></th>
        </tr>
        </tfoot>
        <tbody>
        <tr>
        <!--
        <td>Champion</td>
        <td>Condom</td>
        <td>GHC 12</td>
        <td>25</td>
        <td>B21211</td>
        <td>2019/01/01</td>
        <td>GHC 13</td>
        <td><a href="#" class="delete"><i class="fa fa-trash"></i></a></td>
        </tr>
        -->
        </tbody>
       
        </table>
        
        </div><!--End table responsive-->
        <br/>
        <button id="addProducts" class="btn btn-block btn-success">Add Products</button>
        


        </div>
        
        </div>
    `;
};

// Instantiate Page
const page = new PageState();

//init first page
page.init();

// UI vars
const viewProduct = document.getElementById("view_product"),
  addProduct = document.getElementById("add_product");

// View Products
viewProduct.addEventListener("click", (e) => {
  page.change(new viewState());

  //Functionalities Here

  // Load Datatable
  $("#product_list").DataTable({
    ajax: { url: DOMAIN + "/includes/process.php?getProducts=1", dataSrc: "" },
    columns: [
      { data: "product_name" },
      { data: "category_name" },
      { data: "unit_price" },
      { data: "product_quantity" },
      { data: "product_measurement_unit" },
      { data: "product_reorder_quantity" },
      { data: "product_batch" },
      { data: "expiry_date" },
      { data: "selling_price" },
      { data: "product_status" },
      { data: "date_entered" },
      { data: "date_updated" },
    ],
  });

  e.preventDefault();
});

//Add Prouducts
addProduct.addEventListener("click", (e) => {
  page.change(new addState());
  getItemsFromLocalStorage("add_product_table_output");

  addProductStock(
    "add_product_form",
    "add_product_table_output",
    "product_name",
    "product_category",
    "product_barcode",
    "unit_prc",
    "product_qty",
    "product_measurement_unit",
    "product_reorder_qty",
    "batch_no",
    "product_expiry",
    "selling_prc"
  );

  // removeProducts
  removeProductParent("add_product_form_output");

  // Add Product
  addProducts("addProducts");
  // Show Category
  showCategories("product_category");
  //Select Picker
  $(".selectpicker").selectpicker("refresh");
  //Datepicker
  $("#product_expiry").datepicker({
    uiLibrary: "bootstrap4",
    format: "dd-mm-yyyy",
    size: "small",
  });
  e.preventDefault;
});

//LOAD ITEMS IN LOCAL STORAGE
function getItemsFromLocalStorage(output) {
  let products;
  if (localStorage.getItem("products") === null) {
    products = [];
  } else {
    products = JSON.parse(localStorage.getItem("products"));
  }
  products.forEach(function (product) {
    // Create table row
    const table = document.getElementById(output);
    // Create new table Row
    const row = document.createElement("tr");
    row.innerHTML = `
  <td>${product["product_name"]}</td>
  <td>${product["product_category"]}</td>
  <td>${product["product_barcode"]}</td>
  <td>GHC ${product["unit_price"]}</td>
  <td>${product["product_quantity"]}</td>
  <td>${product["product_measurement_unit"]}</td>
  <td>${product["product_reorder_quantity"]}</td>
  <td>${product["product_batch"]}</td>
  <td>${product["product_expiry"]}</td>
  <td>GHC ${product["selling_price"]}</td>
  <td><p class="text-danger delete"><i class="fa fa-trash"></i></p></td>
  `;
    table.appendChild(row);
  });
  // console.log(table);
}

// Function to Category options

function showCategories(element) {
  http.get(DOMAIN + "/includes/process.php?fetchCategories", function (
    err,
    post
  ) {
    if (err) {
      console.log(err);
    } else {
      document.getElementById(element).innerHTML = post;
    }
  });
}

//SUBMIT THE TABLE
function addProductStock(
  form,
  output,
  prod,
  cat,
  bcode,
  uPrice,
  qty,
  measurement,
  rLevel,
  batch,
  expiry,
  sPrice
) {
  const addForm = document.getElementById(form);
  addForm.addEventListener("submit", function () {
    const table = document.getElementById(output),
      product = document.getElementById(prod).value,
      category = document.getElementById(cat).value,
      barcode = document.getElementById(bcode).value,
      unitPrice = document.getElementById(uPrice).value,
      quantity = document.getElementById(qty).value,
      measurementUnit = document.getElementById(measurement).value,
      reorderQty = document.getElementById(rLevel).value,
      batchNo = document.getElementById(batch).value,
      expiryDate = document.getElementById(expiry).value,
      sellingPrice = document.getElementById(sPrice).value;

    // Create new table Row
    const row = document.createElement("tr");
    row.innerHTML = `
  <td>${product}</td>
  <td>${category}</td>
  <td>${barcode}</td>
  <td>GHC ${unitPrice}</td>
  <td>${quantity}</td>
  <td>${measurementUnit}</td>
  <td>${reorderQty}</td>
  <td>${batchNo}</td>
  <td>${expiryDate}</td>
  <td>GHC ${sellingPrice}</td>
  <td><p class="text-danger delete"><i class="fa fa-trash"></i></p></td>
  `;
    table.appendChild(row);

    //SET LOCAL STORAGE DATA
    const productData = {
      product_name: product,
      product_category: category,
      product_barcode: barcode,
      unit_price: unitPrice,
      product_quantity: quantity,
      product_measurement_unit: measurementUnit,
      product_reorder_quantity: reorderQty,
      product_batch: batchNo,
      product_expiry: expiryDate,
      selling_price: sellingPrice,
    };
    storeProductInLocalStorage(productData);
  });
}
//Store Products to local Storage
function storeProductInLocalStorage(product) {
  let products;
  if (localStorage.getItem("products") === null) {
    products = [];
  } else {
    products = JSON.parse(localStorage.getItem("products"));
  }
  products.push(product);
  localStorage.setItem("products", JSON.stringify(products));
}

function removeProductParent(output) {
  const tableData = document.getElementById(output);
  tableData.addEventListener("click", function (e) {
    if (e.target.classList.contains("fa-trash")) {
      e.target.parentElement.parentElement.parentElement.remove();
      removeProductFromLocalStorage(
        e.target.parentElement.parentElement.parentElement.firstElementChild
      );
    }
  });
}

function removeProductFromLocalStorage(productItem) {
  let products;
  if (localStorage.getItem("products") === null) {
    products = [];
  } else {
    products = JSON.parse(localStorage.getItem("products"));
  }
  products.forEach(function (product, index) {
    if (productItem.textContent == product["product_name"]) {
      products.splice(index, 1);
    }
  });
  localStorage.setItem("products", JSON.stringify(products));
}
//CLICK ADD PRODUCTS BUTTON
function addProducts(button) {
  const addBtn = document.getElementById(button);
  addBtn.addEventListener("click", function () {
    let products;
    if (localStorage.getItem("products") === null) {
      products = [];
    } else {
      products = JSON.parse(localStorage.getItem("products"));
      document.querySelector(".overlay").style.display = "block";
      http.post(
        DOMAIN + "/includes/process.php?addProductsItem=1",
        products,
        function (err, post) {
          if (err) {
            document.querySelector(".overlay").style.display = "none";
            console.log(err);
          } else {
            document.querySelector(".overlay").style.display = "none";
            swal("Success", post, "success");
            localStorage.clear();
          }
        }
      );
    }
  });
}
