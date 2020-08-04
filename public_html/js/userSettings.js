const DOMAIN = "http://localhost/kobison_pharmacy/public_html";

const http = new ProcessHttp();

loadEventListeners();
function loadEventListeners() {
  const userSettingsForm = document.getElementById("user_settings_form");
  document.addEventListener("DOMContentLoaded", getUserSettings);
  userSettingsForm.addEventListener("submit", changeUserSettings);
}

function getUserSettings() {
  const business = document.getElementById("business_name"),
    expiration = document.getElementById("expiry_time"),
    stock_level = document.getElementById("stock_level");

  http.get(DOMAIN + "/includes/process.php?getUserSettingsInfo", function (
    err,
    get
  ) {
    if (err) {
      console.log(err);
    } else {
      data = JSON.parse(get);
      business.value = data[0]["business_name"];
      expiration.value = data[0]["expiry_notification"];
    }
  });
}
// CHANGE USER SETTINGS
// function changeUserSettings() {
//   http.put()
// }
