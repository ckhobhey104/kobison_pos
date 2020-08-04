const DOMAIN = "http://localhost/kobison_pharmacy/public_html";
const http = new ProcessHttp();
loadEventListeners();
function loadEventListeners() {
  window.addEventListener("DOMContentLoaded", getCountMargin);
}
function getCountMargin() {
  const notificationNumber = document.getElementById("notification_number");
  const countActivty = document.getElementById("activity_count");
  const notificationNav = document.getElementById("notification_nav");
  const revenueCard = document.getElementById("revenue_card");
  const costCard = document.getElementById("cost_card");
  const marginCard = document.getElementById("margin_card");
  const inventoryCard = document.getElementById("inventory_card");
  const discountCard = document.getElementById("discount_card");
  http.get(DOMAIN + "/includes/process.php?getMargin", function (err, get) {
    if (err) {
      console.log(err);
    } else {
      let data = JSON.parse(get);
      revenueCard.textContent =
        " GHC " +
        parseFloat(data[0]["revenue"])
          .toFixed(2)
          .toString()
          .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      costCard.textContent = " GHC " + data[0]["cost"];
      marginCard.textContent =
        " GHC " +
        parseFloat(data[0]["revenue"] - data[0]["cost"])
          .toFixed(2)
          .toString()
          .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      notificationNumber.textContent = data[0]["notification"] + "  ";
      notificationNav.textContent = data[0]["notification"];
      countActivty.textContent = data[0]["log_data"];
      inventoryCard.textContent =
        " GHC " +
        parseFloat(data[0]["total_inventory"])
          .toFixed(2)
          .toString()
          .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      discountCard.textContent =
        " GHC " +
        parseFloat(data[0]["total_discount"])
          .toFixed(2)
          .toString()
          .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
  });
}
