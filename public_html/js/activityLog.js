const DOMAIN = "http://localhost/kobison_pharmacy/public_html";
const http = new ProcessHttp();

loadEventListeners();
function loadEventListeners() {
  document.body.addEventListener("mouseover", updateLogs);
}

function updateLogs() {
  http.get(DOMAIN + "/includes/process.php?updateLogs=1", function (err, post) {
    if (err) {
      console.log(err);
    } else {
    }
  });
}
