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

  <title>KobisonPOS - Edit Profiles</title>

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
      <?php
					if(isset($_GET["msg"]) && !empty($_GET["msg"])){
						?>
							<div class="alert alert-success alert-dismissible fade show">
							<?php echo $_GET["msg"];?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php
					}
					?>

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="users_dashboard.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">User Profiles</li>
        </ol>

        <!-- Page Content -->
        <h4>List of Profiles</h4>
        <hr>

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header bg-bluish" style="color:#fff;"><h6>
            <i class="fas fa-user"></i>
            User Profile</h6></div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="users_profile" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Status</th>
                    <th>Date Registered</th>
                    <th>Last Login</th>
                    <th></th>
                    <th></th>

                    <!-- <th>Action</th> -->
                  </tr>
                </thead>
                 <tbody id="users_profile_tbody">
                   <!-- <tr>
                    <td>1</td>
                    <td>Tablet</td>
                    <td>Small Tablets</td>
                    <td>
                      <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-edit">&nbsp;</i>Edit</a>
                      <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-times">&nbsp;</i>Delete</a>
                    </td>
                  </tr> -->
        
                </tbody>
              </table>
            </div>
          </div>
           <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
        </div>

      </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Edit User Profile Modal -->
  <?php include_once("./templates/editUserProfile.php"); ?>

  <!-- Change User Password Modal -->
  <?php include_once("./templates/changeUserPassword.php"); ?>

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

    <!-- Gigjo Datepicker -->
<script src="../files/vendor/datepicker/js/gijgo.min.js"></script>

   <!-- Sweet Alert -->
   <script src="../files/vendor/sweetalert/sweetalert.min.js"></script>

   <!-- Script for user_dashboard ie. VanillaJs and Prototype -->
  <script src="./js/processhttp.js"></script>
  <!-- <script src ="./js/showProductInfo.js"></script> -->
  <script src ="./js/login.js"></script>
  <script src = "./js/showTables.js"></script>
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


</body>

</html>
