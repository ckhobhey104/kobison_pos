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

  <title>KobisonPOS - Sales</title>

  <!-- Custom fonts for this template-->
  <link href="../files/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="../files/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <link rel="stylesheet" href="../files/vendor/datepicker/css/gijgo.min.css">
  <link rel = "stylesheet" href="../files/vendor/bootstrap-toggle/css/bootstrap-toggle.min.css">

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
          <li class="breadcrumb-item active">New Order</li>
        </ol>

        <!-- Page Content -->
        <div class="float-right" id="check_barcode_div" style="color:#fff; font-size: 12px;">
        <input type="checkbox" id="check_barcode" data-toggle="toggle" data-size="small" data-width="150" data-onstyle="success" data-on="Barcode On" data-off="Barcode Off"  data-offstyle="danger">
        </div>
        <h4>New Order</h4>
        
        
        
        <hr>
        <!-- <p>Click to <a href="#" id="view_product">View product</a>/<a href="#" id="add_product">Add Product</a></p> -->
        
        <!-- DataTables Example -->
        <div id="order_content">
        <!-- Order Form Here -->
        <div class="card mb-3">
        <div class="card-header bg-info" style="color:#fff">
        <h6><i class="fas fa-table"></i>
        Make your order
        </h6></div>
        <div class="card-body">
        <form id="order_form" onsubmit="return false">

        <div id="select_products">
        <!-- <label for="select_id">Select Product</label> -->
        <select id="select_id" class="form-control form-control-sm selectpicker select_id" data-live-search="true">
        </select>
                
        </div>  
        <div class="table-responsive">
        <table class="table-bordered" id="orders_table" width="100%" cellspacing="0">
        <thead class="bg-secondary" >
        <tr>
        <th>Item Name</th>
        <th>Avail Qty</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Total</th>
        <th style="font-size:19px; text-align:center;"></th>
        </tr>        
        </thead>
        <tbody id="invoice_item">

        </tr>
        <br/>
        </tbody>        
        </table>
        </div>
        <br/><br/>
        <div class="form-group row">
				<label for="subtotal" class="col-sm-3 col-form-label" align="right">Sub Total</label>
				<div class="col-sm-6">
				<input type="text" readonly id="subtotal" class="form-control form-control-sm" required>
					</div>
					</div>
          <div class="form-group row">
						<label for="discount" class="col-sm-3 col-form-label" align="right">Discount</label>
						<div class="col-sm-6">
						<input type="text" name="discount" id="discount" class="form-control form-control-sm" required>
						  </div>	
						 </div>
						    	<div class="form-group row">
						    		<label for="net_total"  class="col-sm-3 col-form-label" align="right">Net Total</label>
						    		<div class="col-sm-6">
						    			<input type="text" readonly name="net_total" id="net_total" class="form-control form-control-sm" required>
						    		</div>	
						    	</div>
						    	<div class="form-group row">
						    		<label for="paid" class="col-sm-3 col-form-label" align="right">Paid</label>
						    		<div class="col-sm-6">
						    			<input type="text" name="paid" id="paid" class="form-control form-control-sm" required>
						    		</div>	
						    	</div>
						    	<div class="form-group row">
						    		<label for="change"  class="col-sm-3 col-form-label" align="right">Change</label>
						    		<div class="col-sm-6">
						    			<input type="text" readonly id="change" class="form-control form-control-sm" required>
						    		</div>	
						    	</div>
						    	<div class="form-group row">
						    		<label for="payment_method" class="col-sm-3 col-form-label" align="right">Payment Method</label>
						    		<div class="col-sm-6">
						    			<select id="payment_method" class="form-control form-control-sm" required>
						    				<option value="Cash">Cash</option>
						    				<option value="MoMo">Mobile Money</option>
						    				<option value="Cheque">Cheque</option>
						    			</select>
						    		</div>	
						    	</div>
						    	<center>
						    		<input type="submit" id="submit_order_btn" style="width:400px;" class="btn btn-info" value="Order">
						    	</center>         
        </form>       
        </div><!--End Card Body-->
        </div><!--End Card-->
        </div><!-- End Order content-->
        

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
    $('.selectpicker').selectpicker();
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
<script src="../files/vendor/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
<script src="../files/vendor/barcode-listener/jquery-barcodeListener.js"></script>

 <!-- Sweet Alert -->
 <script src="../files/vendor/sweetalert/sweetalert.min.js"></script>

  <!-- Script for user_dashboard ie. VanillaJs and Prototype -->
  <script src="js/processhttp.js"></script>
  <script src="js/orderProduct.js"></script>
  <script src="js/showTables.js"></script>



</body>

</html>
