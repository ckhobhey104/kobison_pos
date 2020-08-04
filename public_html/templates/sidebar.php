    <ul class="sidebar navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="users_dashboard.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <?php
      if($_SESSION['user_type']=='Admin'){
      ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-pills"></i>
          <span>Products</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Products Screen:</h6>
          <a class="dropdown-item" href="addProduct.php">Add/View Products</a>
          <a class="dropdown-item" href="updateProduct.php">Update Products</a>

          <!-- <a class="dropdown-item" href="register.php">Register</a> -->
          <!-- <a class="dropdown-item" href="forgot-password.html">Forgot Password</a> -->
          <div class="dropdown-divider"></div>
          <h6 class="dropdown-header">Other Pages:</h6>
          <a class="dropdown-item" href="stockCategory.php">Stock Category</a>
          <!-- <a class="dropdown-item" href="404.html">404 Page</a> -->
          <!-- <a class="dropdown-item" href="blank.php">Blank Page</a> -->
        </div>
      </li>
      <?php
          }
          ?>

      <!-- Order -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-shopping-cart"></i>
          <span>Transactions</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Sales Screen:</h6>
          <a class="dropdown-item" href="new_sale.php">New Sale</a>
          <?php
          if($_SESSION['user_type']=='Admin'){
          ?>
          <a class="dropdown-item" href="view_sales.php">View Sales</a>
          <?php
          }
          ?>

          <!-- <a class="dropdown-item" href="register.php">Register</a> -->
          <!-- <a class="dropdown-item" href="forgot-password.html">Forgot Password</a> -->
          <div class="dropdown-divider"></div>
          <!-- <h6 class="dropdown-header">Other Pages:</h6> -->
          <!-- <a class="dropdown-item" href="stockCategory.php">Stock Category</a> -->
          <!-- <a class="dropdown-item" href="404.html">404 Page</a> -->
          <!-- <a class="dropdown-item" href="blank.php">Blank Page</a> -->
        </div>
      </li>

      <!-- Reports -->
      <?php
      if($_SESSION['user_type']=='Admin'){
      ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-chart-bar"></i>
          <span>Reports</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Sales:</h6>
          <a class="dropdown-item" href="sales_report.php">Sales Report</a>
          <!-- <a class="dropdown-item" href="purchase_report.php">Purchases Report</a> -->

          <!-- <a class="dropdown-item" href="register.php">Register</a> -->
          <!-- <a class="dropdown-item" href="forgot-password.html">Forgot Password</a> -->
          <div class="dropdown-divider"></div>
          <!-- <h6 class="dropdown-header">Other Pages:</h6> -->
          <!-- <a class="dropdown-item" href="stockCategory.php">Stock Category</a> -->
          <!-- <a class="dropdown-item" href="404.html">404 Page</a> -->
          <!-- <a class="dropdown-item" href="blank.php">Blank Page</a> -->
        </div>
      </li>

      <?php
      }
      ?>
      <!-- <li class="nav-item">
        <a class="nav-link" href="charts.html">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
      </li> -->
      <?php
      if($_SESSION['user_type']=='Admin'){
      ?>
      <li class="nav-item">
        <a class="nav-link" href="register.php">
          <i class="fas fa-fw fa-pen"></i>
          <span>Register</span></a>
      </li>
      <?php
      }
      ?>
    </ul>