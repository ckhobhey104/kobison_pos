<?php
 class Notify{
    private $con;
    function __construct(){
        include_once('../db/dbh.php');
        $db = new Database();
        $this->con = $db->connect();
    }
    public function notifyExpiration(){
      // DELETE ALL NOTIFICATIONS
      $sql = "DELETE FROM notifications";
      $pre_stmt = $this->con->prepare($sql);
      $pre_stmt->execute() or die($this->con->error);
        $expiry = date('Y-m-d');
        $rows = [];
        $sql = "SELECT product_id,product_name,product_batch,expiry_date FROM products WHERE expiry_date <= ?";
        $pre_stmt= $this->con->prepare($sql);
        $pre_stmt->bind_param('s',$expiry);
        $pre_stmt->execute() or die($this->con->error);
        $result = $pre_stmt->get_result();
        while($row = $result->fetch_assoc()){
            $rows[] = $row;
        }
        foreach($rows as $row){

            $product_id = $row["product_id"];
            $product_name = $row["product_name"];
            $product_batch = $row['product_batch'];
            $expiry = $row['expiry_date'];
            $msg = $product_name . " with the batch number of ".$product_batch." has expired since ".$expiry;
            $msg_date = date('Y-m-d');
            $msg_for = $_SESSION['user_type'];
            $msg_status = 'Unread';
            $product_status = 'Expired';
 
            
            // INSERT NOTIFICATION
            $sql = "INSERT INTO `notifications`(`notification_date`, `notification_description`, `notification_for`, `notification_status`) VALUES (?,?,?,?)";
            $pre_stmt = $this->con->prepare($sql);
            $pre_stmt->bind_param('ssss',$msg_date,$msg,$msg_for,$msg_status);
            $pre_stmt->execute() or die($this->con->error);

            $sql = "UPDATE products SET product_status =? WHERE product_id =?";
            $pre_stmt = $this->con->prepare($sql);
            $pre_stmt->bind_param('si',$product_status,$product_batch);
            $pre_stmt->execute() or die($this->con->error);
        }        
        

    }

 }
 $notify = new Notify();
 $notify->notifyExpiration();

