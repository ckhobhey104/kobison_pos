<nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="users_dashboard.php">
      <i class="fas fa-shopping-cart">&nbsp;</i>
      <!-- <img src="./images/menu.png" width="40" height="30" class="d-inline-block align-top" alt="gra-logo"> -->
          <span>&nbsp;</span><span id="nav_title"><?php echo $_SESSION["business_name"];?></span><span>&nbsp;&nbsp;</span>
        </a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell fa-fw"></i>
          <?php
          if($_SESSION['user_type']=='Admin'){
          ?>
          <span id="notification_nav" class="badge badge-danger"></span>

          <?php
          }
          ?>
        </a>
        <!-- <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown"> -->
          <!-- <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div> -->
      </li>
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-envelope fa-fw"></i>
          <?php
          if($_SESSION['user_type']=='Admin'){
          ?>
          <span id="activity_count" class="badge badge-danger"></span>
          <?php
          }
          ?>
        </a>
        <?php
          if($_SESSION['user_type']=='Admin'){
          ?>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
          <a class="dropdown-item" href="view_notification.php">View Messages</a>
          <!-- <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a> -->
        </div>
        <?php
          }
          ?>
      </li>
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>

        
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
        <?php
          if($_SESSION['user_type']=='Admin'){
          ?>
          <a class="dropdown-item" href="user_settings.php">User Settings</a>
          
         
          <a class="dropdown-item" href="activity_logs.php">Activity Log</a>

          <?php
          }
          ?>

          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>

  </nav>

  