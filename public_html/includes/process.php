<?php
 include_once('../db/constants.php');
 include_once('./user.php');
 include_once('./DBOperations.php');
 include_once('./showInfo.php');

 $receiveJson = file_get_contents("php://input");
$obj = json_decode($receiveJson,true);

//Register User
if(isset($obj['fullname']) && isset($obj['email'])) {
    $user = new User();
    $fullname = $obj['fullname'];
    $email = $obj['email'];
    $username = $obj['username'];
    $password = $obj['password'];
    $usertype = $obj['usertype'];
    $result = $user->createUserAccount($fullname,$email,$username,$password,$usertype);
    echo $result;
    exit();
 } 
 //USER LOGIN
 if(isset($obj['loginEmail']) && isset($obj['loginPass'])){
     $user = new User();
     $email = $obj['loginEmail'];
     $password = $obj['loginPass'];
     $result = $user->userLogin($email,$password);
     echo $result;
     exit();
 }
//  USER LOGOUT
if(isset($_POST['userlogout'])){
    $user = new User();
    $result = $user->userLogout();
    echo $result;
}

// GET USERS PROFILE
if(isset($_GET['getUsersProfile'])){
    $user = new User();
    $data = $user->showProfile('users');
    echo json_encode($data);
}
// EDIT USER PROFILE
if(isset($_GET['editUsersProfile'])){
    $user = new User();
    $id = $obj['edit_user_id'];
    $fullname = $obj['edit_fullname'];
    $username = $obj['edit_username'];
    $email = $obj['edit_email'];
    $user_type = $obj['edit_user_type'];
    $status = $obj["edit_user_status"];
    $result = $user-> editUserProfile($id,$fullname,$username,$email,$user_type,$status);
    echo $result;
    exit();
}

// CHANGE USER PASSWORD
if(isset($_GET['changeUserPassword'])){
    $user = new User();
    $id = $obj['change_id'];
    $oldPwd = $obj['oldPwd'];
    $newPwd = $obj['newPwd'];
    $result = $user->changeUserPassword($id,$oldPwd,$newPwd);
    echo $result;
    exit();
}

// GET USER SETTINGS INFO
if(isset($_GET["getUserSettingsInfo"])){
    $show = new ShowInfo();
    $result = $show->showSingleRecord("user_settings",1);
    echo json_encode($result);
}

 //ADD STOCK CATEGORY
 if(isset($obj['category'])){
    $op = new DBOperations();
    $category = $obj['category'];
    $result = $op->addStockCategory($category);
    echo $result;
    exit();
}
//SHOW STOCK CATEGORIES
if(isset($_GET['getCategories'])){
    $show = new ShowInfo();
    $data = $show->showTable('categories');     
    echo json_encode($data);
}
//GET SINGLE CATEGORY
if(isset($_GET['getSingleCategory'])){
    $show = new ShowInfo();
    $id = $obj['eid'];
    $result = $show->showSingleRecord('categories',$id);
    echo json_encode($result);
}
if(isset($obj['editCategoryId']) && isset($obj['editCategoryName'])){
    $id = $obj['editCategoryId'];
    $category = $obj['editCategoryName'];
    $status = $obj['editCategoryStatus'];
    $op = new DBOperations();
    $result = $op->updateCategory($category,$status,$id);
    echo $result;
}
//DELETE CATEGORY
if(isset($_GET['deleteCategory'])){
    $id = $_GET['deleteCategory'];
    $show = new ShowInfo();
    $result = $show->deleteRecord('product_categories','category_id',$id);
    echo $result;
}

//FETCH PRODUCT CATEGORIES
if(isset($_GET['fetchCategories'])){
    $show = new ShowInfo();
    $rows = $show->showTable('categories');
    foreach($rows as $row){
        echo '<option value="'.$row["category_name"].'">'.$row["category_name"].'</option>';
    }
    exit();
}
if(isset($_GET['fetchJsonCategories'])){
    $show = new ShowInfo();
    $data = $show->showTable('categories');
    echo json_encode($data);
    exit();
}
//ADD PRODUCT
if(isset($_GET['addProductsItem'])){
    $op = new DBOperations();
    $result=$op->addProduct($obj);
    echo $result;
    exit();
}

//SHOW STOCK PRODUCTS
if(isset($_GET['getProducts'])){
    $show = new ShowInfo();
    $data = $show->showTable('all_products');     
    echo json_encode($data);
    exit();
}

//FETCH PRODUCTS
if(isset($_GET['fetchProducts'])){
    $show = new ShowInfo();
    $rows = $show->showTable('active_products');
    // foreach($rows as $row){
    //     echo '<option value="'.$row["product_id"].'">'.$row["product_name"].'</option>';
    // }
    // exit();
    echo json_encode($rows);
    exit();
}

//GET SINGLE PRODUCT
if(isset($_GET['getSingleProduct'])){
    $show = new ShowInfo();
    $id = $obj['pid'];
    $result = $show->showSingleRecord('products',$id);
    echo json_encode($result);
    exit();
}
// UPDATE PRODUCT STOCK
if(isset($_GET['addUpdateProductsItem'])){
    $op = new DBOperations();
    $result = $op->updateProduct($obj);
    print_r($result);
    exit();
}
// GET BARCODE INFO
if(isset($_GET['getBarcodeInfo'])){
    $show = new ShowInfo();
    $barcode = $_GET['reqCode'];
    $result = $show->showBarcodeInfo('active_products',$barcode);
    echo json_encode($result);
    exit();
}

// MAKE SALES
if(isset($_GET['makeSales'])){
    $op = new DBOperations();
    $result=$op->makeNewSale($obj['order'],$obj['totals']);
    print_r($result);
    exit();
}

// ****** REPORTS *******

//GET MARGIN
if(isset($_GET['getMargin'])){
    $show= new ShowInfo();
    $row = $show->countTables('margin');
    echo json_encode($row);
    exit();
}

//GET NAVBAR ITEMS
if(isset($_GET['getNavItems'])){
    $show = new ShowInfo();
    $row = $show->countTables('navbar');
    echo json_encode($row);
    exit();
}

// VIEW SALES TOTAL
if(isset($_GET['viewSalesTotal'])){
    $show = new ShowInfo();
    $data = $show->showTable('sales_total');     
    echo json_encode($data);
    exit();
}
// VIEW ACTIVITY LOG
if(isset($_GET['viewActivityLog'])){
    $show = new ShowInfo();
    $data = $show->showTable('activity_logs');     
    echo json_encode($data);
    exit();
}
// VIEW NOTIFICATION
if(isset($_GET['viewNotification'])){
    $show = new ShowInfo();
    $data = $show->showTable('notifications');     
    echo json_encode($data);
    exit();
}
// UPDATE LOGS
if(isset($_GET['updateLogs'])){
    $op = new DBOperations();
    $result = $op->updateLogs();
    echo $result;
    exit();
}
//GET MULTIPLE ORDERS
if(isset($_GET['getSaleDetails'])){
    $show = new ShowInfo();
    $id = $obj['id'];
    $result = $show->showMultipleRecordsById('show_orders',$id);
    echo json_encode($result);
    exit();
}
//REMOVE SALE ORDER
if(isset($_GET['removeSalesInfo'])){
    $id = $_GET['removeSalesInfo'];
    $op = new DBOperations();
    $result = $op->deleteMultipleRecords('orders',$id);
    echo $result;
    exit();
}
// MONTHLY PRELIMINARY SALES REPORT
if(isset($_GET['getInitialMonthlySalesReport'])){
    $show = new ShowInfo();
    $date = date('Y');
    $result = $show->showInitialYearlyReports('monthly_sales',$date);
    echo json_encode($result);
    exit();
}
// DAILY MARGIN REPORT
if(isset($_GET['getInitialDailyMarginReport'])){
    $show = new ShowInfo();
    $date = date('Y-m-d');
    $result = $show->showInitialDailyReports('daily_sales_margin',$date);
    echo json_encode($result);
}
if(isset($_GET['getDailySalesReport'])){
    $show = new ShowInfo();
    $from = $_GET['fromDate'];
    $end = $_GET['endDate'];
    $data  = $show->showSalesPurchaseReportByDate('daily_sales',$from,$end);
    echo json_encode($data);
    exit();
}
if(isset($_GET['getDailySalesSummaryByDate'])){
    $show = new ShowInfo();
    $from = $_GET['fromDate'];
    $end = $_GET['endDate'];
    $data = $show->showSalesPurchaseReportByDate('daily_card_sales',$from,$end);
    echo json_encode($data);
    exit();
}

if(isset($_GET['getMonthlyMargin'])){
    $show = new ShowInfo();
    $date = date('Y');
    $data = $show->showInitialYearlyReports('monthly_margin',$date);
    echo json_encode($data);
    exit();
}
// PURCHASE DETAILS REPORT
if(isset($_GET['viewInventoryCategoryDetails'])){
    $show = new showInfo();
    $data = $show->showTable("inventory_category_details");
    echo json_encode($data);
    exit();
}

if(isset($_GET['getPurchaseByDateReport'])){
    $show = new ShowInfo();
    $from = $_GET['fromDate'];
    $end = $_GET['endDate'];
    $data  = $show->showSalesPurchaseReportByDate('daily_purchases',$from,$end);
    echo json_encode($data);
    exit();
}