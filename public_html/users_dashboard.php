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

  <title>KobisonPOS - Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="../files/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="../files/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../files/css/sb-admin.css" rel="stylesheet">
  <!-- Custom CSS for this template -->
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
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">User</li>
        </ol>

         <!-- Icon Cards-->
         <?php 
         if($_SESSION['user_type']=='Admin'){
         ?>
         <div class="row">
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-comments"></i>
                </div>
                <div class="mr-5"><p><h6><span id="notification_number"></span>New Messages!</h6></p></div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="view_notification.php">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-money-bill-alt"></i>
                </div>
                <div class="mr-5">
                <p><h5>Total Revenue:<span id="revenue_card"></span></h5></p>
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
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-coins"></i>
                </div>
                <div class="mr-5">
                <p><h5>Cost Of Sales:<span id="cost_card"></span></h5></p>
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
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-info o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-life-ring"></i>
                </div>
                <div class="mr-5">
                <p><h5> Sales Margin:<span id="margin_card"></span></h5></p>
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
        </div>

        <div class="row">

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-bluish o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="mr-5">
                <p><h5>Total Inventory:<span id="inventory_card"></span></h5></p>
                </div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="inventory_details.php">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>

          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-yellowish o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fa fa-money-bill"></i>
                </div>
                <div class="mr-5">
                <p><h5>Discount Given:<span id="discount_card"></span></h5></p>
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

         

         
        
        </div>
        <?php
         }
        ?>



        <!-- Area Chart Example-->
        <!-- <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-chart-area"></i>
            Daily Sales</div>
          <div class="card-body">
            <canvas id="myAreaChart" width="100%" height="30"></canvas>
          </div> -->
          <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
        <br/>
          <div class="row">
          <!-- Pie Chart  -->
          <div class="col-lg-4">
            <div class="card mb-3">
              <div class="card-header bg-info" style="color:#fff;">
               <h6> <i class="fas fa-chart-pie"></i>
                Sales For The Day</h6></div>
              <div class="card-body">
                <canvas id="dailySalesMarginChart" width="100%" height="100"></canvas>
              </div> 
              <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
            </div>
         </div>
        <!-- Bar Chart -->
            <div class="col-lg-8">
            <div class="card mb-3">
              <div class="card-header bg-warning">
              <h6> <i class="fas fa-chart-bar"></i>
                Monthly Sales</h6></div>
              <div class="card-body">
                <canvas id="monthlySalesChart" width="100%" height="45"></canvas>
              </div>
              <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
            </div>
          </div> 
       </div>
        </div>
        

         

        <!-- DataTables Example -->

        

      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Kobison Technologies</span>
          </div>
        </div>
      </footer>

    </div>
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

  <!-- Page level plugin JavaScript-->
  <script src="../files/vendor/chart.js/Chart.min.js"></script>
  <script src="../files/vendor/datatables/jquery.dataTables.js"></script>
  <script src="../files/vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../files/js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <!-- <script src="../files/js/demo/datatables-demo.js"></script>
  <script src="../files/js/demo/chart-area-demo.js"></script>
  <script src="../files/js/demo/chart-pie-demo.js"></script>
  <script src="../files/js/demo/chart-bar-demo.js"></script> -->

  <!-- Script for user_dashboard ie. VanillaJs and Prototype -->
  <script src="js/processhttp.js"></script>
  <script src ="js/charts/chartMonthlySales.js"></script>
  <script src ="js/users_dashboard.js"></script>
<!-- LOG OUT SCRIPT -->
<script>
$(document).ready(function(){
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
</body>

</html>
