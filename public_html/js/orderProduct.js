const DOMAIN = "http://localhost/kobison_pharmacy/public_html";
const http = new ProcessHttp();

//REMOVE TR
const table = document.querySelector("#orders_table");
if (table) {
  table.addEventListener("click", removeRow);
  table.addEventListener("keyup", getTotalPrices);
}
const disc = document.getElementById("discount");
if (disc !== null) {
  disc.addEventListener("focusout", getDiscount);
}
const payment = document.getElementById("paid");
if (payment !== null) {
  payment.addEventListener("focusout", getPayment);
}
// //FORM SUBMIT
const form = document.getElementById("order_form");
if (form !== null) {
  form.addEventListener("submit", addOrder);
  form.addEventListener("change", getProductDetails);
}
const barcodeDivCheck = document.getElementById("check_barcode_div");
if (barcodeDivCheck !== null) {
  window.addEventListener("DOMContentLoaded", getBarcodeInfo);
  barcodeDivCheck.addEventListener("click", getBarcodeInfo);
}

// Remove Row
function removeRow(e) {
  if (e.target.classList.contains("fa-trash")) {
    e.target.parentElement.parentElement.parentElement.remove();
    calculateTotalPrices(0, 0);
  }
}
//GET PRODUCT DETAILS
function getProductDetails(e) {
  if (e.target.classList.contains("select_id")) {
    let details = e.target.value;
    let data = [];
    data = details.split(",");
    let tbody = document.getElementById("invoice_item");
    const tr = document.createElement("tr");
    tr.innerHTML = `
    <td>
    <input type="text" readonly value="${
      data[1]
    }" class="form-control form-control-sm product_name">
    <input type="hidden" value="${data[0]}" class="product_id">
        </td>

        <td>
        <input type="text" class="form-control form-control-sm total_qty" value="${
          data[3]
        }" readonly="true">
        </td>

        <td>
        <input type="text" value="" class="form-control form-control-sm product_qty" required="required">
        </td>
        <td>
        <input type="number" readonly value="${
          data[2]
        }" class="form-control form-control-sm product_price" required="required">
        </td>
        <!-- total td -->
        <td class="product_amt">${(parseFloat(data[2]) * 1).toFixed(2)}</td>
        <td style="text-align:center;">
        <p class="text-warning"><i class="fa fa-trash"></i></p>
        </td>
    `;
    tbody.appendChild(tr);
  }
  calculateTotalPrices(0, 0);
}

function getTotalPrices(e) {
  if (e.target.classList.contains("product_qty")) {
    let total =
        e.target.parentElement.parentElement.lastElementChild
          .previousElementSibling,
      quantity = parseInt(e.target.value),
      price = parseFloat(
        e.target.parentElement.parentElement.firstElementChild
          .nextElementSibling.nextElementSibling.nextElementSibling
          .firstElementChild.value
      ),
      tQuantity =
        e.target.parentElement.parentElement.firstElementChild
          .nextElementSibling.firstElementChild.value;
    if (quantity > tQuantity) {
      e.target.value = 0;
    }
    const grossTotal = parseFloat(quantity * price);
    total.textContent = grossTotal.toFixed(2);
    calculateTotalPrices(0, 0);
  }
}
function calculateTotalPrices(d, p) {
  let subtotal = 0;
  let net_total = 0;
  let discount = d;
  let paid_amount = p;
  let change = 0;
  let totalAmount = document.querySelectorAll(".product_amt");
  for (let i = 0; i < totalAmount.length; i++) {
    subtotal = subtotal + parseFloat(totalAmount[i].textContent);
  }
  subtotal = parseFloat(subtotal).toFixed(2);
  document.getElementById("subtotal").value = subtotal;
  // document.getElementById("discount").value = discount;
  net_total = parseFloat(subtotal - discount).toFixed(2);
  change = parseFloat(paid_amount - net_total).toFixed(2);
  document.getElementById("net_total").value = net_total;
  // document.getElementById('discount').value = discount;
  // document.getElementById("paid").value = paid_amount;
  document.getElementById("change").value = change;
}
function getDiscount() {
  let discount = document.getElementById("discount").value;
  calculateTotalPrices(discount, 0);
}
function getPayment() {
  let paid = document.getElementById("paid").value;
  let discount = document.getElementById("discount").value;
  calculateTotalPrices(discount, paid);
}

// GET BARCODE INFO
function getBarcodeInfo() {
  $("#check_barcode").change(function () {
    // CHECK IF BARCODE IS CHECKED TRUE
    if ($("#check_barcode").prop("checked") === true) {
      $("body")
        .barcodeListener()
        .on("barcode.valid", function (e, code) {
          let requestCode = code;
          http.get(
            DOMAIN + "/includes/process.php?getBarcodeInfo=1&reqCode=" + code,
            function (err, get) {
              if (err) {
                console.log(err);
              } else {
                let data = JSON.parse(get);
                let tbody = document.getElementById("invoice_item");
                const tr = document.createElement("tr");
                tr.innerHTML = `
    <td>
    <input type="text" readonly value="${
      data[0]["product_name"]
    }" class="form-control form-control-sm product_name">
    <input type="hidden" value="${data[0]["product_id"]}" class="product_id">
        </td>

        <td>
        <input type="text" class="form-control form-control-sm total_qty" value="${
          data[0]["product_quantity"]
        }" readonly="true">
        </td>

        <td>
        <input type="text" value="" class="form-control form-control-sm product_qty" required="required">
        </td>
        <td>
        <input type="number" readonly value="${
          data[0]["selling_price"]
        }" class="form-control form-control-sm product_price" required="required">
        </td>
        <!-- total td -->
        <td class="product_amt">${(
          parseFloat(data[0]["selling_price"]) * 1
        ).toFixed(2)}</td>
        <td style="text-align:center;">
        <p class="text-warning"><i class="fa fa-trash"></i></p>
        </td>
    `;
                tbody.appendChild(tr);
              }
              calculateTotalPrices(0, 0);
            }
          );
        });
    }
    // else {
    //   alert("False");
    // }
  });
}

// Add Order
function addOrder(e) {
  let product_id = document.querySelectorAll(".product_id");
  let product_name = document.querySelectorAll(".product_name");
  let product_quantity = document.querySelectorAll(".product_qty");
  let total_quantity = document.querySelectorAll(".total_qty");
  let price = document.querySelectorAll(".product_price");
  let totalAmt = document.querySelectorAll(".product_amt");
  let subtotal = document.querySelector("#subtotal");
  let discount = document.querySelector("#discount");
  let amount_paid = document.querySelector("#paid");
  let net_total = document.querySelector("#net_total");
  let change = document.querySelector("#change");
  let payment_method = document.querySelector("#payment_method");
  let order = [];
  let totals = [];

  for (let i = 0; i < price.length; i++) {
    if (product_quantity[i].value == 0) {
      console.log("Error");
    } else {
      order.push({
        pid: product_id[i].value,
        pname: product_name[i].value,
        qty: product_quantity[i].value,
        price: price[i].value,
        tqty: total_quantity[i].value,
        tAmt: totalAmt[i].textContent,
      });
    }
  }
  totals.push({
    sub: subtotal.value,
    disc: discount.value,
    amt_pd: amount_paid.value,
    net_tot: net_total.value,
    change: change.value,
    pmt_mthd: payment_method.value,
  });
  // console.log(order);
  if (
    order === undefined ||
    order.length == 0 ||
    order.length !== price.length
  ) {
    swal("Error", "Cannot Complete Order", "error");
  } else {
    document.querySelector(".overlay").style.display = "block";
    http.post(
      DOMAIN + "/includes/process.php?makeSales=1",
      { order, totals },
      function (err, post) {
        if (err) {
          document.querySelector(".overlay").style.display = "none";
          console.log(err);
        } else {
          document.querySelector(".overlay").style.display = "none";
          document.querySelector("#invoice_item").innerHTML = "";
          swal({
            title: "Success",
            text: post,
            icon: "success",
            buttons: {
              cancel: true,
              confirm: "Print Receipt",
            },
          }).then((isConfirm) => {
            if (isConfirm) {
              let strOrder = JSON.stringify(order),
                strTotal = JSON.stringify(totals);
              window.location.href =
                DOMAIN +
                "/printer/escpos-php-development/example/interface/salesReceipt.php?product_data=" +
                strOrder +
                "&invoice_data=" +
                strTotal;
            }
          });
        }
      }
    );
  }
}
