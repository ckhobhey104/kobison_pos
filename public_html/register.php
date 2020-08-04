<!DOCTYPE html>
<?php
include_once("./db/constants.php");
if (!isset($_SESSION["user_id"])) {
	header("location:".DOMAIN."/index.php");
}else if($_SESSION['user_type']=='Other'){
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

  <title>KobisonPOS - Register</title>

  <!-- Custom fonts for this template-->
  <link href="../files/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">


 



  <!-- Custom styles for this template-->
  <link href="../files/css/sb-admin.css" rel="stylesheet">

   <!-- Bootstrap Select css -->
  <link href="../files/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css"> 
  <link rel="stylesheet" href="css/style.css" type="text/css">



</head>

<body class="bg-white">
<div class="overlay">
        <div class="cssload-thecube">
            <div class="cssload-cube cssload-c1"></div>
            <div class="cssload-cube cssload-c2"></div>
            <div class="cssload-cube cssload-c4"></div>
            <div class="cssload-cube cssload-c3"></div>
        </div>

    </div>




  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Register a User</div>
      <div class="card-body">
        <form id="register_user_form" onsubmit="return false">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-12">
                <div class="form-label-group">
                  <input type="text" id="fullName" name="fullName" class="form-control" placeholder="Full name" required="required" autofocus="autofocus">
                  <label for="fullName">Full Name</label>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required="required">
              <label for="email">Email address</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-12">
                <div class="form-label-group">
                  <input type="text" id="userName" name="userName" class="form-control" placeholder="Username" required="required" autofocus="autofocus">
                  <label for="userName">Username</label>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <div class="form-label-group">
                  <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required="required">
                  <label for="inputPassword">Password</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-label-group">
                  <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="Confirm password" required="required">
                  <label for="confirmPassword">Confirm password</label>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            
            <div class="form-label-group">
              <select id="usertype" class="form-control" placeholder="usertype" required="required">
                <option value="">Choose User Type</option>
                <option value="Admin">Admin</option>
                <option value="Other">Officer</option>
              </select>
              
            </div>
          </div>

          <!-- <div class="form-group">
            <div class="form-label-group">
              <select name="office" id="office" class="form-control selectpicker" data-live-search="true" placeholder="office" required="required">
                <option value="">Select Office</option>
                <option value="1">Weija STO</option>
                <option value="2">Kasoa STO</option>

              </select>
            </div>
          </div> -->

          <input type="submit" value = "Register" class="btn btn-primary btn-block">
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="users_dashboard.php">Go Back</a>
          <a class="d-block small mt-3" href="viewUserProfile.php">Users Profile</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../files/vendor/jquery/jquery.min.js"></script>
  <script src="../files/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../files/vendor/jquery-easing/jquery.easing.min.js"></script>

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
    <script src="js/processhttp.js"></script>
    <script src="js/login.js"></script>


</body>

</html>
