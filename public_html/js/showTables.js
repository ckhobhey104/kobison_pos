$(document).ready(function () {
  const DOMAIN = "http://localhost/kobison_pharmacy/public_html";
  const http = new ProcessHttp();

  // SHOW USER PROFILE
  $("#users_profile").DataTable({
    ajax: {
      url: DOMAIN + "/includes/process.php?getUsersProfile=1",
      dataSrc: "",
    },
    columns: [
      { data: "fullname" },
      { data: "user_email" },
      { data: "user_type" },
      { data: "user_status" },
      { data: "register_date" },
      { data: "last_login" },
      {
        data: null,
        render: function (data, type, row) {
          // Combine the first and last names into a single table field
          return (
            '<a href="#" data-toggle="modal" data-target="#editUsersProfileModal" edit_details="' +
            data.user_id +
            "," +
            data.fullname +
            "," +
            data.user_email +
            "," +
            data.user_name +
            "," +
            data.user_type +
            "," +
            data.user_status +
            '" class="btn btn-sm edit_user_profile btn-primary" style="font-size:10px;">Edit Profile</a>'
          );
        },
      },
      {
        data: null,
        render: function (data, type, row) {
          // Combine the first and last names into a single table field
          return (
            '<a href="#" data-toggle="modal" data-target="#changeUserPasswordModal" change_details="' +
            data.user_id +
            "," +
            data.fullname +
            '" class="btn btn-sm change_user_pass btn-warning" style="font-size:11px;">Change Password</a>'
          );
        },
      },
    ],
  });

  $("#stock_categories").DataTable({
    ajax: {
      url: DOMAIN + "/includes/process.php?getCategories=1",
      dataSrc: "",
    },

    columns: [
      { data: "category_name" },
      { data: "category_status" },
      {
        data: null,
        render: function (data, type, row) {
          // Combine the first and last names into a single table field
          return (
            '<a href="#" data-toggle="modal" data-target="#editStockCategoryModal" edit_id="' +
            data.category_id +
            '" class="btn btn-sm edit_category btn-secondary">Edit</a> <a href="#" delete_id="' +
            data.category_id +
            '" class="btn btn-sm delete_category btn-danger">Delete</a>'
          );
        },
      },
    ],
  });
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
  loadProducts();
  function loadProducts() {
    $.ajax({
      url: DOMAIN + "/includes/process.php?fetchProducts=1",
      success: function (data) {
        let result = JSON.parse(data);

        let newOptions = [];
        result.forEach(function (data) {
          newOptions.push(
            '<option value="' +
              data["product_id"] +
              "," +
              data["product_name"] +
              "," +
              data["selling_price"] +
              "," +
              data["product_quantity"] +
              '">' +
              data["product_name"] +
              "</option>"
          );
        });
        var choose = '<option value="">Select Product</option>';
        $(".selectpicker").html(choose + newOptions);
        $(".selectpicker").selectpicker("refresh");
      },
    });
  }

  loadUpdateProducts();
  function loadUpdateProducts() {
    $.ajax({
      url: DOMAIN + "/includes/process.php?getProducts=1",
      success: function (data) {
        let result = JSON.parse(data);

        let newOptions = [];
        result.forEach(function (data) {
          newOptions.push(
            '<option value="' +
              data["product_id"] +
              "," +
              data["product_name"] +
              "," +
              data["category_id"] +
              "," +
              data["unit_price"] +
              "," +
              data["product_quantity"] +
              "," +
              data["product_batch"] +
              "," +
              data["expiry_date"] +
              "," +
              data["selling_price"] +
              "," +
              data["product_status"] +
              "," +
              data["product_barcode"] +
              "," +
              data["product_measurement_unit"] +
              "," +
              data["product_reorder_quantity"] +
              '">' +
              data["product_name"] +
              "</option>"
          );
        });
        var choose = '<option value="">Select Product</option>';
        $("#update_select_id").html(choose + newOptions);
        $("#update_select_id").selectpicker("refresh");
      },
    });
  }

  loadUpdateCategories();
  function loadUpdateCategories() {
    $.ajax({
      url: DOMAIN + "/includes/process.php?fetchJsonCategories=1",
      success: function (data) {
        let result = JSON.parse(data);

        let newOptions = [];
        result.forEach(function (data) {
          newOptions.push(
            '<option value="' +
              data["category_id"] +
              '">' +
              data["category_name"] +
              "</option>"
          );
        });
        var choose = '<option value="">Select Product</option>';
        $("#update_category_id").html(choose + newOptions);
        // $("#update_category_id").selectpicker("refresh");
      },
    });
  }
  // VIEW SALES TOTAL
  $("#view_sales_total").DataTable({
    ajax: {
      url: DOMAIN + "/includes/process.php?viewSalesTotal=1",
      dataSrc: "",
    },

    columns: [
      { data: "invoice_date" },
      {
        data: null,
        render: function (data, type, row) {
          return "GHC " + parseFloat(data.sub_total).toFixed(2);
        },
      },
      {
        data: null,
        render: function (data, type, row) {
          return "GHC " + parseFloat(data.discount).toFixed(2);
        },
      },
      {
        data: null,
        render: function (data, type, row) {
          return "GHC " + parseFloat(data.net_total).toFixed(2);
        },
      },
      {
        data: null,
        render: function (data, type, row) {
          return "GHC " + parseFloat(data.amount_paid).toFixed(2);
        },
      },
      {
        data: null,
        render: function (data, type, row) {
          return "GHC " + parseFloat(data.change_amount).toFixed(2);
        },
      },
      { data: "payment_type" },
      { data: "seller" },
      {
        data: null,
        render: function (data, type, row) {
          // Combine the first and last names into a single table field
          return (
            '<a href="#" data-toggle="modal" data-target="#viewSalesTotalModal" view_id="' +
            data.invoice_id +
            '" class="btn btn-sm view_sales_record btn-primary">Details</a>'
          );
        },
      },
      {
        data: null,
        render: function (data, type, row) {
          // Combine the first and last names into a single table field
          return (
            '<a href="#" delete_id="' +
            data.invoice_id +
            '" class="btn btn-sm delete_sale_record btn-danger">Delete</a>'
          );
        },
      },
    ],
  });
  // ACTIVITY LOGS
  $("#activity_logs_table").DataTable({
    ajax: {
      url: DOMAIN + "/includes/process.php?viewActivityLog=1",
      dataSrc: "",
    },

    columns: [
      { data: "log_date" },
      { data: "log_description" },
      { data: "log_status" },
    ],
  });

  // VIEW NOTIFICATION
  $("#view_notification_table").DataTable({
    ajax: {
      url: DOMAIN + "/includes/process.php?viewNotification=1",
      dataSrc: "",
    },

    columns: [
      { data: "notification_date" },
      { data: "notification_description" },
      { data: "notification_for" },
      { data: "notification_status" },
    ],
  });

  // SALES REPORTS
  $("#orderDateFrom").datepicker({
    uiLibrary: "bootstrap4",
    format: "yyyy-mm-dd",
  });
  $("#orderDateTo").datepicker({
    uiLibrary: "bootstrap4",
    format: "yyyy-mm-dd",
  });

  $("#stock_sales_report_form").on("submit", function () {
    dailySalesReport();
    salesSummary();
  });
  function dailySalesReport() {
    let thisFromDate = $("#orderDateFrom").val();
    let thisEndDate = $("#orderDateTo").val();
    $("#daily_sales_report_table").DataTable({
      ajax: {
        url:
          DOMAIN +
          "/includes/process.php?getDailySalesReport&fromDate=" +
          thisFromDate +
          "&endDate=" +
          thisEndDate,
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
  }
  function salesSummary() {
    let thisFromDate = $("#orderDateFrom").val();
    let thisEndDate = $("#orderDateTo").val();
    $.ajax({
      url:
        DOMAIN +
        "/includes/process.php?getDailySalesSummaryByDate&fromDate=" +
        thisFromDate +
        "&endDate=" +
        thisEndDate,
      dataType: "json",
      success: function (data) {
        console.log(data);
        $("#sales_card").text("GHC " + data[0]["sales"]);
        $("#cost_of_sales_card").text(" GHC " + data[0]["cost_of_sales"]);
        $("#sales_margin_card").text(" GHC " + data[0]["sales_margin"]);
      },
    });
  }

  // VIEW PURCHASE TOTAL
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
});
