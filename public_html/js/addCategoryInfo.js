const DOMAIN = "http://localhost/kobison_pharmacy/public_html";

const http = new ProcessHttp();

const stockCategoryForm = document.getElementById("addStockCategoryForm");
const categoryTable = document.querySelector("#stock_categories_tbody");
const editCategoryForm = document.querySelector("#editStockCategoryForm");

if (stockCategoryForm !== null) {
  stockCategoryForm.addEventListener("submit", addCategory);
}
if (categoryTable) {
  categoryTable.addEventListener("click", categoryTableUpdateDelete);
}
if (editStockCategoryForm) {
  editCategoryForm.addEventListener("submit", updateCategory);
}

//Add Category Function
function addCategory() {
  const category = document.getElementById("stock_category").value;
  const data = {
    category: category,
  };
  http.post(DOMAIN + "/includes/process.php", data, function (err, post) {
    if (err) {
      console.log(err);
    } else {
      window.location.href = DOMAIN + "/stockCategory.php?msg=" + post;
    }
  });
}
//Get Single Category
function categoryTableUpdateDelete(e) {
  const categoryId = document.getElementById("edit_category_id");
  const categoryName = document.getElementById("edit_category_name");
  const categoryStatus = document.getElementById("edit_select_category_status");
  if (e.target.classList.contains("edit_category")) {
    let data = { eid: e.target.getAttribute("edit_id") };
    http.post(
      DOMAIN + "/includes/process.php?getSingleCategory=1",
      data,
      function (err, post) {
        if (err) {
          console.log(err);
        } else {
          const result = JSON.parse(post);
          result.forEach(function (row) {
            categoryId.value = row.category_id;
            categoryName.value = row.category_name;
            categoryStatus.value = row.category_status;
          });
        }
      }
    );
  } else if (e.target.classList.contains("delete_category")) {
    let data = { did: e.target.getAttribute("delete_id") };
    swal({
      title: "Are you sure",
      text: "You won't be able to revert this",
      icon: "warning",
      buttons: {
        cancel: true,
        confirm: "Yes Delete It",
      },
    }).then((isConfirm) => {
      if (isConfirm) {
        http.delete(
          DOMAIN + "/includes/process.php?deleteCategory=" + data.did,
          function (err, post) {
            if (err) {
              console.log(err);
            } else {
              window.location.href = DOMAIN + "/stockCategory.php?msg=" + post;
            }
          }
        );
      }
    });
  }
}
//Update Stock Category
function updateCategory() {
  const categoryId = document.getElementById("edit_category_id");
  const categoryName = document.getElementById("edit_category_name");
  const categoryStatus = document.getElementById("edit_select_category_status");
  data = {
    editCategoryId: categoryId.value,
    editCategoryName: categoryName.value,
    editCategoryStatus: categoryStatus.value,
  };
  http.post(DOMAIN + "/includes/process.php", data, function (err, post) {
    if (err) {
      console.log(err);
    } else {
      window.location.href = DOMAIN + "/stockCategory.php?msg=" + post;
    }
  });
}
