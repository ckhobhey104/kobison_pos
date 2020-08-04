<!DOCTYPE html>
<?php
include_once("./db/constants.php");
if (!isset($_SESSION["user_id"])) {
	header("location:".DOMAIN."/index.php");
}
?>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>KobisonPOS - Products</title>

  <!-- Custom fonts for this template-->
  <link href="../files/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="../files/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <link rel="stylesheet" href="../files/vendor/datepicker/css/gijgo.min.css">

  <!-- Custom styles for this template-->
  <link href="../files/css/sb-admin.css" rel="stylesheet">

     <!-- Bootstrap Select css -->
     <link href="../files/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css"> 
     <link rel="stylesheet" href="css/style.css" type="text/css">

</head>

<body id="page-top">
<div class="overlay">
        <div class="cssload-thecube">
            <div class="cssload-cube cssload-c1"></div>
            <div class="cssload-cube cssload-c2"></div>
            <div class="cssload-cube cssload-c4"></div>
            <div class="cssload-cube cssload-c3"></div>
        </div>

    </div>

    <!-- Navbar -->
    <?php include_once("./templates/navbar.php"); ?>

  <div id="wrapper">

    <!-- Sidebar -->
    <?php include_once("templates/sidebar.php"); ?>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="users_dashboard.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Update Products</li>
        </ol>

        <!-- Page Content -->
        <h4>Update Product Information</h4>
        <hr>
        <p>Click to <a href="#" id="add_product">Add Product</a>
        
        <!-- DataTables Example -->
        <div id="update_product_content">
        <!-- List of products here -->
        <div class="card-mb-3">
        <div class="card-header bg-info" style="color:#fff;">
        <h6><i class="fa fa-edit">&nbsp;</i>Update Stock
        </h6></div>
        <div class="card-body">
        <form id="update_product_form" onsubmit="return false">
        <div class="table-responsive">
        <table class="table table-bordered" id="add_product_table" width="100%" cellspacing="0">
        <thead>
        <tr>
        <th>Select</th>
        <th>Name</th>
        <th>Category</th>
        <th>Barcode</th>
        <th>Unt.Prc</th>
        <th>Qty</th>
        <th>Measurement Unit</th>
        <th>Reorder Quantity</th>
        <th>Batch</th>
        <th>Expiry</th>
        <th>Sell Prc</th>
        <th>Status</th>
        <th></th>
        </tr>
        </thead>
        
        <tbody>
        <tr>
        <td>
        <select id="update_select_id" class="form-control form-control-sm" data-live-search="true" placeholder="office" required="required">
               <!--<option value="">Select Catagory</option>
                <option value="1">Syrup</option>
                <option value="2">Tablet</option>
                <option value="2">Condom</option>-->
              </select>
              <input type="hidden" id="update_product_id" required="required">
        </td>
        <td><input type="text"  id="update_product_name" required="required" class="form-control form-control-sm"></td>
        <td>
        <select id="update_category_id" class="form-control form-control-sm" placeholder="office" required="required">
               <!--<option value="">Select Catagory</option>
                <option value="1">Syrup</option>
                <option value="2">Tablet</option>
                <option value="2">Condom</option>-->
              </select>
        </td>
        <td><input type="text" id="update_product_barcode" class="form-control form-control-sm"></td>
        <td><input type="text" id="update_unit_prc" required="required" class="form-control form-control-sm"></td>
      <td><input type="number" id="update_product_qty" required="required" class="form-control form-control-sm"></td>
      <td>
      <select name="update_product_measurement_unit" id="update_product_measurement_unit" class="form-control form-control-sm  placeholder="office">
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
        <td><input type="number" name="update_product_reorder_qty" id="update_product_reorder_qty" required="required" class="form-control form-control-sm"></td>
        <td><input type="text" id="update_batch_no" class="form-control form-control-sm"></td>
        <td><input type="text" id="update_expiry" ></td>
        <td><input type="text" id="update_selling_prc" required="required" class="form-control form-control-sm"></td>
        <td>
        <select id="update_product_status" class="form-control form-control-sm"  required="required">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
                <option value="Expired">Expired</option>
              </select>
        </td>
        <td><input type="submit" class="btn btn-sm btn-primary" style="color:#fff"></td>
        </tr>
        </tbody>
        </table>
        </div><!--End table responsive div-->       
        </form>
        <div id="update_product_form_output">
        <div class="table-responsive">
        <table class="table table-bordered" id="update_product_table_output" width="100%" cellspacing="0">
        <tfoot>
        <tr>
        <th>Select</th>
        <th>Name</th>
        <th>Category</th>
        <th>Barcode</th>
        <th>Unt.Prc</th>
        <th>Qty</th>
        <th>Measurement Unit</th>
        <th>Reorder Quantity</th>
        <th>Batch</th>
        <th>Expiry</th>
        <th>Sell Prc</th>
        <th>Status</th>
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
        <button id="updateProducts" class="btn btn-block btn-secondary"><h6>Update Products</h6></button>
        


        </div>
        
        </div>
        </div>
        

      </div><!--End Container-->
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <?php include_once("./templates/logout_modal.php"); ?>

  

  <!-- Bootstrap core JavaScript-->
  <script src="../files/vendor/jquery/jquery.min.js"></script>
  <script src="../files/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../files/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../files/vendor/datatables/jquery.dataTables.js"></script>
  <script src="../files/vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../files/js/sb-admin.min.js"></script>

   <!-- Demo scripts for this page-->
   <script src="../files/js/demo/datatables-demo.js"></script>

   

     <!-- Bootstrap Select Plug in -->
     <script src="../files/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>

     <script>
     $(document).ready(function(){
      $("#update_expiry").datepicker({
    uiLibrary: "bootstrap4",
    format: "yyyy-mm-dd",
    size: "small"
  });
    //LOGOUT
    $('#logout').on('click',function(e){
    e.preventDefault();
    $('.overlay').show();
    $.ajax({
      url:'./includes/process.php',
      method:'POST',
      data:{userlogout:1},
      success: function(data){
        if(data == 'LOGOUT'){
          $('overlay').hide();
          window.location.href='logout.php';
        }
      }
    })
  })
     })
     
     </script>


<!-- Gigjo Datepicker -->
<script src="../files/vendor/datepicker/js/gijgo.min.js"></script>

 <!-- Sweet Alert -->
 <script src="../files/vendor/sweetalert/sweetalert.min.js"></script>

  <!-- Script for user_dashboard ie. VanillaJs and Prototype -->
  <script src="js/processhttp.js"></script>
  <script src="js/updateProductInfo.js"></script>
  <script src="js/showTables.js"></script>



</body>

</html>
