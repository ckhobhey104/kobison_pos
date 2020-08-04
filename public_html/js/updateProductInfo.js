const DOMAIN = "http://localhost/kobison_pharmacy/public_html";
const http = new ProcessHttp();

loadEventListeners();
function loadEventListeners() {
  const select = document.getElementById("update_select_id");
  const updateForm = document.getElementById("update_product_form");
  const updateTableData = document.getElementById("update_product_form_output");
  const updateProd = document.getElementById("updateProducts");

  window.addEventListener("DOMContentLoaded", getUpdateItemsFromLocalStorage);
  select.addEventListener("change", getProductDetails);
  updateForm.addEventListener("submit", addUpdateProductStock);
  updateTableData.addEventListener("click", removeUpdateProductParent);
  updateProd.addEventListener("click", addUpdateProducts);
}

//LOAD ITEMS IN LOCAL STORAGE
function getUpdateItemsFromLocalStorage() {
  let updateProducts;
  if (localStorage.getItem("updateProducts") === null) {
    updateProducts = [];
  } else {
    updateProducts = JSON.parse(localStorage.getItem("updateProducts"));
  }
  updateProducts.forEach(function (product) {
    // Create table row
    const table = document.getElementById("update_product_table_output");
    // Create new table Row
    const row = document.createElement("tr");
    row.innerHTML = `
    <td>${product["edit_name"]}</td>
    <td>${product["pName"]}</td>
    <td>${product["cName"]}</td>
    <td>${product["product_barcode"]}</td>
    <td>GHC ${product["unit_price"]}</td>
    <td>${product["product_quantity"]}</td>
    <td>${product["product_measurement_unit"]}</td>
    <td>${product["product_reorder_quantity"]}</td>
    <td>${product["product_batch"]}</td>
    <td>${product["product_expiry"]}</td>
    <td>GHC ${product["selling_price"]}</td>
    <td>${product["product_status"]}</td>
    <td><p class="text-danger delete"><i class="fa fa-trash"></i></p></td>
    `;
    table.appendChild(row);
  });
  // console.log(table);
}

//Get Product Details
function getProductDetails(e) {
  let data = [];
  const product_id = document.getElementById("update_product_id");
  const product_name = document.getElementById("update_product_name");
  const category_id = document.getElementById("update_category_id");
  const product_barcode = document.getElementById("update_product_barcode");
  const unit_price = document.getElementById("update_unit_prc");
  const product_quantity = document.getElementById("update_product_qty");
  const product_measurement_unit = document.getElementById(
    "update_product_measurement_unit"
  );
  const product_reorder_quantity = document.getElementById(
    "update_product_reorder_qty"
  );
  const batch = document.getElementById("update_batch_no");
  const expiry = document.getElementById("update_expiry");
  const sellingPrc = document.getElementById("update_selling_prc");
  const status = document.getElementById("update_product_status");
  data = e.target.value.split(",");

  product_id.value = data[0];
  product_name.value = data[1];
  category_id.value = data[2];
  unit_price.value = data[3];
  product_quantity.value = data[4];
  batch.value = data[5];
  expiry.value = data[6];
  sellingPrc.value = data[7];
  status.value = data[8];
  product_barcode.value = data[9];
  product_measurement_unit.value = data[10];
  product_reorder_quantity.value = data[11];
  //   console.log(category_id.options[category_id.selectedIndex].text);
}

//SUBMIT THE TABLE
function addUpdateProductStock(e) {
  const table = document.getElementById("update_product_table_output"),
    select_id = document.getElementById("update_select_id"),
    select_name = select_id.options[select_id.selectedIndex].text,
    category_id = document.getElementById("update_category_id"),
    category_name = category_id.options[category_id.selectedIndex].text,
    barcode = document.getElementById("update_product_barcode").value,
    reorder_quantity = document.getElementById("update_product_reorder_qty")
      .value,
    measurement_unit = document.getElementById(
      "update_product_measurement_unit"
    ).value,
    product_id = document.getElementById("update_product_id").value,
    product_name = document.getElementById("update_product_name").value,
    unitPrice = document.getElementById("update_unit_prc").value,
    quantity = document.getElementById("update_product_qty").value,
    batchNo = document.getElementById("update_batch_no").value,
    expiryDate = document.getElementById("update_expiry").value,
    sellingPrice = document.getElementById("update_selling_prc").value,
    status = document.getElementById("update_product_status").value;

  // Create new table Row
  const row = document.createElement("tr");
  row.innerHTML = `
    <td>${select_name}</td>
    <td>${product_name}</td>
    <td>${category_name}</td>
    <td>${barcode}</td>
    <td>GHC ${unitPrice}</td>
    <td>${quantity}</td>
    <td>${measurement_unit}</td>
    <td>${reorder_quantity}</td>
    <td>${batchNo}</td>
    <td>${expiryDate}</td>
    <td>GHC ${sellingPrice}</td>
    <td>${status}</td>
    <td><p class="text-danger delete"><i class="fa fa-trash"></i></p></td>
    `;
  table.appendChild(row);

  //SET LOCAL STORAGE DATA
  const updateProductData = {
    edit_name: select_name,
    pid: product_id,
    pName: product_name,
    cName: category_name,
    product_category: category_id.value,
    product_barcode: barcode,
    unit_price: unitPrice,
    product_quantity: quantity,
    product_measurement_unit: measurement_unit,
    product_reorder_quantity: reorder_quantity,
    product_batch: batchNo,
    product_expiry: expiryDate,
    selling_price: sellingPrice,
    product_status: status,
  };
  storeUpdateProductInLocalStorage(updateProductData);
  console.log(updateProductData);
}
//Store Products to local Storage
function storeUpdateProductInLocalStorage(updateProduct) {
  let updateProducts;
  if (localStorage.getItem("updateProducts") === null) {
    updateProducts = [];
  } else {
    updateProducts = JSON.parse(localStorage.getItem("updateProducts"));
  }
  updateProducts.push(updateProduct);
  localStorage.setItem("updateProducts", JSON.stringify(updateProducts));
}

// Remove Products
function removeUpdateProductParent(e) {
  if (e.target.classList.contains("fa-trash")) {
    e.target.parentElement.parentElement.parentElement.remove();
    removeUpdateProductFromLocalStorage(
      e.target.parentElement.parentElement.parentElement.firstElementChild
    );
  }
}

function removeUpdateProductFromLocalStorage(updateProductItem) {
  let updateProducts;
  if (localStorage.getItem("updateProducts") === null) {
    updateProducts = [];
  } else {
    updateProducts = JSON.parse(localStorage.getItem("updateProducts"));
  }
  updateProducts.forEach(function (product, index) {
    if (updateProductItem.textContent == product["edit_name"]) {
      updateProducts.splice(index, 1);
    }
  });
  localStorage.setItem("updateProducts", JSON.stringify(updateProducts));
}

//Click Update Product Button
function addUpdateProducts() {
  let updateProducts;
  if (localStorage.getItem("updateProducts") === null) {
    updateProducts = [];
  } else {
    updateProducts = JSON.parse(localStorage.getItem("updateProducts"));
    if (updateProducts.length > 0) {
      http.put(
        DOMAIN + "/includes/process.php?addUpdateProductsItem=1",
        updateProducts,
        function (err, post) {
          if (err) {
            console.log(err);
          } else {
            swal("Success", post, "success");
            localStorage.clear();
          }
        }
      );
    }
  }
}
