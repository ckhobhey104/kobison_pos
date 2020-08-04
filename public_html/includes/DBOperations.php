<?php
class  DBOperations{
    private $con;
    function __construct(){
        include_once('../db/dbh.php');
        $db = new Database();
        $this->con = $db->connect();
    }
    //ADD PRODUCT CATEGORIES
    public function addStockCategory($categories){
     $categories = htmlentities(mysqli_real_escape_string($this->con,$categories));
     $status = 'Active';
     $sql = "INSERT INTO `product_categories`(`category_name`, `category_status`) VALUES (?,?)";
     $pre_stmt = $this->con->prepare($sql);
     $pre_stmt->bind_param('ss',$categories,$status);
     $result = $pre_stmt->execute() or die($this->con->error);
     if($result){
         return 'CATEGORY_ADDED';
     }else {
         return 'SOME_ERROR';
     }
    }
    //UPDATE TABLES
    public function updateCategory($category,$status,$id){
        $id = htmlentities(mysqli_real_escape_string($this->con,$id));
        $category = htmlentities(mysqli_real_escape_string($this->con,$category));
        $status = htmlentities(mysqli_real_escape_string($this->con,$status));
        $sql = "UPDATE `product_categories` SET `category_name`=?,`category_status`=? WHERE `category_id`=?";
        $pre_stmt = $this->con->prepare($sql);
        $pre_stmt->bind_param('ssi',$category,$status,$id);
        $result = $pre_stmt->execute() or die($this->con->error);
        if($result){
            return 'CATEGORY_UPDATED';
        }else {
            return 'SOME_ERROR';
        }
    }
    // Add Products
    public function addProduct($productArray){
        
      foreach($productArray as $data){
          //INITIALIZE VARIABLES
          $category_name = $data['product_category'];
          $product_name = $data['product_name'];
        //   Barcode number
          $product_barcode = $data['product_barcode'];
          $unit_price = $data['unit_price'];
          $product_quantity = $data['product_quantity'];
          $product_batch = $data['product_batch'];
          if($data["product_expiry"] == ""){
            $product_expiry = "";
        } else {
            $product_expiry = date('Y-m-d',strtotime($data['product_expiry']));
        }
          $product_measurement_unit = $data["product_measurement_unit"];
          $product_reorder_quantity = $data["product_reorder_quantity"];
          $selling_price = $data['selling_price'];
          $product_status ='Active';
          $pre_stmt = $this->con->prepare("SELECT category_id FROM product_categories WHERE category_name=?");
          $pre_stmt->bind_param('s',$category_name);
          $pre_stmt->execute() or die($this->con->error);
          $result = $pre_stmt->get_result();
          $row = $result->fetch_assoc();
          $category_id = $row['category_id'];
          $registerUpdateDate = date('Y-m-d');
         
          //INSERT DATA INTO SQL
          $sql = "INSERT INTO `products`(`product_name`, `product_category_id`,`product_barcode`, `unit_price`, `product_quantity`, `product_measurement_unit`, `product_reorder_quantity`, `product_batch`, `expiry_date`, `selling_price`, `product_status`,`date_entered`,`date_updated`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
          $pre_stmt = $this->con->prepare($sql);
          $pre_stmt->bind_param('sisdisissdsss',$product_name,$category_id,$product_barcode,$unit_price,$product_quantity,$product_measurement_unit,$product_reorder_quantity,$product_batch,$product_expiry,$selling_price,$product_status,$registerUpdateDate,$registerUpdateDate);
          $result = $pre_stmt->execute() or die($this->con->error);          
      }
      if(!$result){
          return 'SOME_ERROR_OCCURED';
      }else{
          return 'PRODUCTS_INSERTED';
      }
    }

    public function updateProduct($updateProductArray){
        $record = 0;
        foreach($updateProductArray as $data){
            $pid = $data['pid'];
            $product_name = $data['pName'];
            $batch = $data['product_batch'];
            $category_id = $data['product_category'];
            $product_barcode = $data['product_barcode'];
            if($data["product_expiry"] == ""){
                $expiry = "";
            } else {
                $expiry = date('Y-m-d',strtotime($data['product_expiry']));
            }
            $product_qty = $data['product_quantity'];
            $product_measurement_unit = $data["product_measurement_unit"];
            $product_reorder_quantity = $data["product_reorder_quantity"];
            $selling_price = $data['selling_price'];
            $unit_price = $data['unit_price'];
            $status=$data['product_status'];
            $dateUpdated = date('Y-m-d');
            // UPDATE PRODUCTS
            $sql ="UPDATE `products` SET `product_name`=?,`product_category_id`=?,`product_barcode`=?,`unit_price`=?,`product_quantity`=?,`product_measurement_unit`=?,`product_reorder_quantity`=?,`product_batch`=?,`expiry_date`=?,`selling_price`=?,`product_status`=?,`date_updated`=? WHERE product_id=?";
            $pre_stmt=$this->con->prepare($sql);
            $pre_stmt->bind_param('sisdisissdssi',$product_name,$category_id,$product_barcode,$unit_price,$product_qty,$product_measurement_unit,$product_reorder_quantity,$batch,$expiry,$selling_price,$status,$dateUpdated,$pid);
            $result = $pre_stmt->execute() or die($this->con->error); 
            $record +=1;           
        }
        if($result){
            // INSERT INTO ACTIVE LOGS
            $log_date = date('Y-m-d');
            $status = 'Unread';
            $msg = $record." products updated by ".$_SESSION['fullname'];
            $sql = "INSERT INTO `activity_logs`(`log_date`, `log_description`, `log_status`) VALUES (?,?,?)";
            $pre_stmt = $this->con->prepare($sql);
            $pre_stmt->bind_param('sss',$log_date,$msg,$status);
            $pre_stmt->execute() or die($this->con->error);
            return 'PRODUCTS_UPDATED';
        }else{
            return 'SOME_ERROR';
        }
    }

    // NEW SALE
    public function makeNewSale($orderData,$totalData){ 
        // GET INVOICE DETAILS
        $subtotal = $totalData[0]['sub'];
        $net_total = $totalData[0]['net_tot'];
        $discount = $totalData[0]['disc'];
        $amount_paid = $totalData[0]['amt_pd'];
        $amount_change = $totalData[0]['change'];
        $payment_method = $totalData[0]['pmt_mthd'];
        $invoice_date = date('Y-m-d');
        $seller = $_SESSION['fullname'];
        // INSERT INTO INVOICE TABLE
        $sql = "INSERT INTO `invoices`( `invoice_date`, `sub_total`, `discount`, `net_total`, `amount_paid`, `change_amount`, `payment_type`,`seller`) VALUES (?,?,?,?,?,?,?,?)";
        $pre_stmt = $this->con->prepare($sql);
        $pre_stmt->bind_param('sdddddss',$invoice_date,$subtotal,$discount,$net_total,$amount_paid,$amount_change,$payment_method,$seller);
        $pre_stmt->execute() or die($this->con->error);
        // GET INVOICE ID
        $invoice_id = $pre_stmt->insert_id;
        if($invoice_id != null){
            foreach($orderData as $data){
                $pid = $data['pid'];
                $orderQty = $data['qty'];
                $order_date = date('Y-m-d');
                // GET TOTAL QUANTITY
                $sql = "SELECT product_quantity FROM products WHERE product_id =?";
                $pre_stmt = $this->con->prepare($sql);
                $pre_stmt->bind_param('i',$pid);
                $pre_stmt->execute() or die($this->con->error);
                $result = $pre_stmt->get_result();
                $row = $result->fetch_assoc();
                $totalQty = $row['product_quantity'];  
                // REMAINING QUANTITY
                $remQty = $totalQty - $orderQty;
                if($remQty < 0){
                    return "ORDER_FAILED_TO_COMPLETE";
                }else {
                    $sql = "UPDATE products SET product_quantity =? WHERE product_id=?";
                    $pre_stmt = $this->con->prepare($sql);
                    $pre_stmt->bind_param('ii',$remQty,$pid);
                    $result= $pre_stmt->execute() or die($this->con->error);
                    // INSERT INTO ORDERS
                    $sql = "INSERT INTO `orders`(`product_id`, `order_date`, `order_quantity`, `invoice_id`) VALUES (?,?,?,?)";
                    $pre_stmt=$this->con->prepare($sql);
                    $pre_stmt->bind_param('isii',$pid,$order_date,$orderQty,$invoice_id);
                    $result = $pre_stmt->execute() or die($this->con->error);
                }
            }
            if($result){
                return 'ORDER_COMPLETED';
            } else {
                return 'ORDER_COULD_NOT_BE_COMPLETED';
            }

        }//End if invoice_id is not null
       
     }



    
     //  UPDATE ACTIVITY LOGS
     public function updateLogs(){
        $pre_stmt = $this->con->prepare("UPDATE activity_logs SET log_status ='Read' WHERE log_status='Unread'");
        $result = $pre_stmt->execute() or die($this->con->error);
        if($result){
            return 1;
        }else{
            return false;
        }
    }
    
    //DELETE MULTIPLE RECORDS
    public function deleteMultipleRecords($table,$id){
        if($table == 'orders'){
            // CHOOSE SQL
            $sql = "SELECT product_id,order_quantity FROM orders WHERE invoice_id =?";
            $pre_stmt = $this->con->prepare($sql);
            $pre_stmt->bind_param('i',$id);
            $pre_stmt->execute() or die($this->con->error);
            $result = $pre_stmt->get_result();
            while($row = $result->fetch_assoc()){
                $rows[] = $row;
            }
            foreach($rows as $row){
                $qty = $row['order_quantity'];
                $pid = $row['product_id'];
                $sql = "SELECT product_quantity FROM products WHERE product_id =?";
                $pre_stmt = $this->con->prepare($sql);
                $pre_stmt->bind_param('i',$pid);
                $pre_stmt->execute() or die($this->con->error);
                $result = $pre_stmt->get_result();
                $row = $result->fetch_assoc();
                $product_quantity = $row['product_quantity'];
                $remQty = $product_quantity + $qty;
                $sql = "UPDATE products SET product_quantity =? WHERE product_id=?";
                $pre_stmt = $this->con->prepare($sql);
                $pre_stmt->bind_param('ii',$remQty,$pid);
                $pre_stmt->execute() or die($this->con->error);
            }
            // DELETE FROM ORDERS
            $sql = "DELETE FROM orders WHERE invoice_id =?";
            $pre_stmt = $this->con->prepare($sql);
            $pre_stmt->bind_param('i',$id);
            $result = $pre_stmt->execute() or die($this->con->error);
            if($result){
                // DELETE FROM INVOICE
                $sql = "DELETE FROM invoices WHERE invoice_id =?";
                $pre_stmt= $this->con->prepare($sql);
                $pre_stmt->bind_param('i',$id);
                $result = $pre_stmt->execute() or die($this->con->error);
                if($result){
                    return 'ORDERS_REMOVED';
                }else {
                    return 'SOME_ERROR';
                }
            }else{
                return 'THERE_SEEMS_TO_BE_AN_ERROR';
            }
        }

    }

    }
    // $op = new DBOperations(); 
//  echo $op->addStockCategory('Hamburger');
// echo $op->updateCategory('Elephants','Active',23);
// $products =[
//     ["product_name"=>"Paracetamol","product_category"=>"Antibiotics","product_barcode"=>"","unit_price"=>"32","product_quantity"=>"11","product_batch"=>"11223","product_expiry"=>"31-05-2020","selling_price"=>"55"]
   
// ];

//  print_r($op->addProduct($products));
// echo $op->deleteMultipleRecords('orders',27);

