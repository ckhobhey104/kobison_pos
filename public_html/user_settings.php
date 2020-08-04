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

  <title>KobisonPOS - User Settings</title>

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
      <h5 style="color:#fff;"><div class="card-header bg-bluish"><i class="fa fa-cog">&nbsp;</i>User Settings</div></h5>
      <div class="card-body">
        <form id="user_settings_form" onsubmit="return false">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-12">
                <div class="form-label-group">
                  <input type="text" id="business_name" class="form-control" placeholder="Name Of Business" required="required" autofocus="autofocus">
                  <label for="business_name">Name Of Business</label>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            
            <div class="form-group">
                <label >Notify Expiry Within</label>
              <select id="expiry_time" class="form-control"  required="required">
               <option value="No Expiry">No Expiry</option>
                <option value="On Expiry Date">On Expiry Date</option>
               <option value="1 Week Before Expiry">1 Week Before Expiry</option>
               <option value="2 Weeks Before Expiry">2 Weeks Before Expiry</option>
               <option value="1 Month Before Expiry">1 Month Before Expiry</option>
               <option value="3 Months Before Expiry">3 Months Before Expiry</option> 
              </select>
              
            </div>
          </div>
          <!-- <div class="form-group">
            <div class="form-row">
              <div class="col-md-12">
                <div class="form-label-group">
                  <input type="text" id="stock_level" class="form-control" placeholder="Stock Level" required="required">
                  <label for="stock_level">At what quantity should you be notified?</label>
                </div>
              </div>
            </div>
          </div> -->

          <!-- <div class="form-group">
            <div class="form-label-group">
              <select name="office" id="office" class="form-control selectpicker" data-live-search="true" placeholder="office" required="required">
                <option value="">Select Office</option>
                <option value="1">Weija STO</option>
                <option value="2">Kasoa STO</option>

              </select>
            </div>
          </div> -->

          <input type="submit" value = "Set" class="btn btn-secondary btn-block">
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="users_dashboard.php">Go Back</a>
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
    <script src="js/userSettings.js"></script>


</body>

</html>
