<!DOCTYPE html>
<?php
include_once("./db/constants.php");
if (!isset($_SESSION["user_id"])) {
	header("location:".DOMAIN."/index.php");
} else if($_SESSION['user_type']=='Other'){
  header("location:".DOMAIN."/users_dashboard.php");
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
          <li class="breadcrumb-item active">Sales Report</li>
        </ol>

        <!-- Icon Cards -->
        <div class="row">
          <!-- <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-info o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-comments"></i>
                </div>
                <div class="mr-5"><p><h6><span id="notification_number"></span>New Messages!</h6></p></div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div> -->
          <div class="col-xl-4 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-money-bill-alt"></i>
                </div>
                <div class="mr-5">
                <p><h5>Total Sales:<span id="sales_card"></span></h5></p>
                </div>
              </div>
              <!-- <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a> -->
            </div>
          </div>
          <div class="col-xl-4 col-sm-6 mb-3">
            <div class="card text-white bg-redish o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-coins"></i>
                </div>
                <div class="mr-5">
                <p><h5>Cost Of Sales:<span id="cost_of_sales_card"></span></h5></p>
                </div>
              </div>
              <!-- <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a> -->
            </div>
          </div>
          <div class="col-xl-4 col-sm-6 mb-3">
            <div class="card text-white bg-yellowish o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-life-ring"></i>
                </div>
                <div class="mr-5">
                <p><h5> Sales Margin:<span id="sales_margin_card"></span></h5></p>
                </div>
              </div>
              <!-- <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a> -->
            </div>
          </div>
        </div><!-- End icon cards-->

        <!-- Page Content -->
        <!-- <h4>Reports</h4> -->
        <hr>
        <p><a href="#" class="btn-sm btn-info" id="view_daily_sales_report">Daily Sales</a>&nbsp;<a href="#" class="btn-sm btn-secondary" id="view_charts">View Chart</a></p>
        
        <!-- DataTables Example -->
        <div id="sales_report_content">
      
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

  <!-- Page level plugin JavaScript-->
  <script src="../files/vendor/chart.js/Chart.min.js"></script>
  <script src="../files/vendor/datatables/jquery.dataTables.js"></script>
  <script src="../files/vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../files/js/sb-admin.min.js"></script>

   <!-- Demo scripts for this page -->
   <!-- <script src="../files/js/demo/datatables-demo.js"></script> -->

   

     <!-- Bootstrap Select Plug in -->
     <script src="../files/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>

<script>
  $(document).ready(function(){
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
  <script src="js/salesReport.js"></script>
  <script src="js/showTables.js"></script>



</body>

</html>
