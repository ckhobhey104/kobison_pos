const DOMAIN = "http://localhost/kobison_pharmacy/public_html";
const http = new ProcessHttp();

const viewSalesTable = document.getElementById("view_sales_total");
if (viewSalesTable !== null) {
  viewSalesTable.addEventListener("click", viewDeleteSaleDetails);
}

function viewDeleteSaleDetails(e) {
  if (e.target.classList.contains("view_sales_record")) {
    let invoice_id = e.target.getAttribute("view_id");
    let data = { id: invoice_id };
    const tableBody = document.getElementById("view_product_orders");
    http.post(DOMAIN + "/includes/process.php?getSaleDetails", data, function (
      err,
      post
    ) {
      if (err) {
        console.log(err);
      } else {
        let result = JSON.parse(post);
        let tr = "";
        result.forEach(function (row) {
          tr += `<tr>
            <td>${row["order_date"]}</td>
             <td>${row["product_name"]}</td>
            <td>${row["order_quantity"]}</td>
             <td>${row["selling_price"]}</td>
           </tr> `;
        });
        tableBody.innerHTML = tr;
      }
    });
  } else if (e.target.classList.contains("delete_sale_record")) {
    let data = { did: e.target.getAttribute("delete_id") };
    swal({
      title: "Are you sure",
      text: "You won't be able to revert this",
      icon: "warning",
      buttons: {
        cancel: true,
        confirm: "Yes Remove",
      },
    }).then((isConfirm) => {
      if (isConfirm) {
        http.delete(
          DOMAIN + "/includes/process.php?removeSalesInfo=" + data.did,
          function (err, post) {
            if (err) {
              console.log(err);
            } else {
              window.location.href = DOMAIN + "/view_sales.php?msg=" + post;
            }
          }
        );
      }
    });
  }
}
