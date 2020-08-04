<?php
class ShowInfo{
    private $con;
    function __construct(){
        include_once('../db/dbh.php');
        $db = new Database();
        $this->con = $db->connect();
    }

    //Show Tables
    public function showTable($table){
        $rows =[];
        //Show Categories Table
        if($table == 'categories'){
            $sql = "SELECT * FROM product_categories";
            } else if($table == 'active_products'){
                $sql = "SELECT p.product_id,p.product_name,c.category_id,c.category_name,p.product_barcode,p.unit_price,p.product_quantity,p.product_measurement_unit,p.product_reorder_quantity,p.product_batch,p.expiry_date,p.selling_price,p.product_status,p.date_entered,p.date_updated FROM products AS p JOIN product_categories AS c ON p.product_category_id = c.category_id WHERE p.product_status = 'Active'";
            } else if($table =='all_products'){
                $sql = "SELECT p.product_id,p.product_name,c.category_id,c.category_name,p.product_barcode,p.unit_price,p.product_quantity,p.product_measurement_unit,p.product_reorder_quantity,p.product_batch,p.expiry_date,p.selling_price,p.product_status,p.date_entered,p.date_updated FROM products AS p JOIN product_categories AS c ON p.product_category_id = c.category_id";
            } else if($table == 'sales_total'){
                $sql = "SELECT invoice_id,invoice_date,sub_total,discount,net_total,amount_paid,change_amount,payment_type,seller FROM invoices ORDER by invoice_id DESC";
            } else if($table == 'activity_logs'){
                $sql = "SELECT log_id,log_date,log_description,log_status FROM activity_logs WHERE log_status='Unread' ORDER BY log_id DESC";
            } else if($table == 'show_orders'){
                $sql = "SELECT orders.order_id,orders.order_date,orders.order_quantity,products.product_name,products.selling_price,orders.invoice_id FROM orders JOIN products ON orders.product_id = products.product_id ORDER BY orders.order_id DESC";
            } else if ($table == 'notifications'){
                $sql = "SELECT notification_id, notification_date,notification_description,notification_for,notification_status FROM notifications WHERE notification_status='Unread' ORDER BY notification_id DESC";
            } else if ($table == 'inventory_category_details'){
                $sql = "SELECT c.category_name AS product_category,SUM(p.product_quantity) AS product_quantity,p.product_measurement_unit AS measurement_unit,SUM(p.product_quantity*p.unit_price) AS purchase_total FROM products AS p JOIN product_categories AS c ON p.product_category_id = c.category_id GROUP BY c.category_name ORDER BY c.category_name";
            }
            $pre_stmt = $this->con->prepare($sql);
            $pre_stmt->execute() or die($this->con->error);
            $result = $pre_stmt->get_result();
            while($row = $result->fetch_assoc()){
                $rows[] = $row;
        }
        return $rows;
    }
    // SHOW BARCODE INFO
    public function showBarcodeInfo($table,$barcode){
        $rows =[];
        if($table == 'active_products'){
            $sql = "SELECT p.product_id,p.product_name,c.category_id,c.category_name,p.product_barcode,p.unit_price,p.product_quantity,p.product_batch,p.expiry_date,p.selling_price,p.product_status,p.date_entered,p.date_updated FROM products AS p JOIN product_categories AS c ON p.product_category_id = c.category_id WHERE p.product_barcode= ? AND p.product_status = 'Active'";
        }
        $pre_stmt = $this->con->prepare($sql);
        $pre_stmt->bind_param('s',$barcode);
        $pre_stmt->execute() or die($this->con->error);
        $result = $pre_stmt->get_result();
        while($row = $result->fetch_assoc()){
            $rows[] = $row;
        }
        return $rows;
    }

    //SHOW SINGLE RECORD 
    public function showSingleRecord($table,$id){
        $id = htmlentities(mysqli_real_escape_string($this->con,$id)); 
        $rows=[];       
        if($table =="categories"){
            $sql = "SELECT * FROM product_categories WHERE category_id = ? LIMIT 1";
        } else if($table == "products"){
            $sql = "SELECT product_name,product_category_id,unit_price,product_quantity,expiry_date,selling_price,product_status FROM products WHERE product_id=? AND product_status = 'Active' LIMIT 1";
        } else if($table == "user_settings"){
            $sql = "SELECT user_setting_id,business_name,low_level_stock,expiry_notification FROM user_settings WHERE user_setting_id =? LIMIT 1";
        }
        $pre_stmt = $this->con->prepare($sql);
        $pre_stmt->bind_param("i",$id);
        $pre_stmt->execute() or die($this->con->error);
        $result = $pre_stmt->get_result();
        while($row = $result->fetch_assoc()){
            $rows[] = $row;
        }
        return $rows;
    }
    // SHOW PRELIMINARY REPORTS WITHOUT DATES
    public function showInitialYearlyReports($table,$date){
        $rows = [];
        if($table == 'monthly_sales'){
            $sql  = "SELECT YEAR(invoices.invoice_date) AS year, date_format(invoices.invoice_date,'%M') AS month, SUM(sub_total) as total_sales FROM invoices WHERE year(invoices.invoice_date) = ? GROUP BY YEAR(invoice_date), MONTH(invoice_date) ORDER BY YEAR(invoice_date),MONTH(invoice_date)";
        } elseif($table == 'monthly_margin'){
            $sql = "SELECT YEAR(orders.order_date) AS year, date_format(orders.order_date,'%M') AS month, SUM((orders.order_quantity * products.selling_price)-(orders.order_quantity*products.unit_price)) AS sales_margin FROM orders JOIN products ON orders.product_id = products.product_id WHERE year(orders.order_date) = ? GROUP BY YEAR(orders.order_date), MONTH(orders.order_date) ORDER BY YEAR(orders.order_date),MONTH(orders.order_date)";
        }
        $pre_stmt = $this->con->prepare($sql);
        $pre_stmt->bind_param('s',$date);
        $pre_stmt->execute() or die($this->con->error);
        $result = $pre_stmt->get_result();
        while($row = $result->fetch_assoc()){
            $rows[]= $row;
        }
        return $rows;
    }
    public function showInitialDailyReports($table,$date){
        $rows=[];
        if($table == 'daily_sales_margin'){
            $sql ="SELECT ( SELECT SUM(invoices.sub_total) FROM invoices  WHERE invoices.invoice_date = ? ) AS revenue, ( SELECT SUM(products.unit_price * orders.order_quantity) FROM orders JOIN products ON products.product_id = orders.product_id WHERE orders.order_date = ? ) AS cost";
        }
        $pre_stmt = $this->con->prepare($sql);
        $pre_stmt->bind_param('ss',$date,$date);
        $pre_stmt->execute() or die($this->con->error);
        $result = $pre_stmt->get_result();
        while($row = $result->fetch_assoc()){
            $rows[] = $row;
        }
        return $rows;
    }
   
    // SHOW MULTIPLE RECORDS
    public function showMultipleRecordsById($table,$id){
        $id = htmlentities(mysqli_real_escape_string($this->con,$id));
        $rows=[];
        if($table == 'show_orders'){
            $sql = "SELECT orders.order_id,orders.order_date,orders.order_quantity,products.product_name,products.selling_price,orders.invoice_id FROM orders JOIN products ON orders.product_id = products.product_id WHERE orders.invoice_id=?";
        }
        $pre_stmt = $this->con->prepare($sql);
        $pre_stmt->bind_param('i',$id);
        $pre_stmt->execute() or die($this->con->error);
        $result = $pre_stmt->get_result();
        while($row = $result->fetch_assoc()){
            $rows[] = $row;
        }
        return $rows;
        
    }
    //DELETE INFO
    public function deleteRecord($table,$pk,$id){
        $sql = "DELETE FROM ".$table." WHERE ".$pk."=?";
		$pre_stmt = $this->con->prepare($sql);
		$pre_stmt->bind_param("i",$id);
		$result = $pre_stmt->execute() or die($this->con->error);
		if($result){
			return "DELETED";
		} else {
			return "SOME_ERROR";
		}
    }
    public function countTables($table){
        $rows = [];
        if($table == 'margin'){
            $sql = "SELECT ( SELECT SUM(invoices.sub_total) FROM invoices ) AS revenue, ( SELECT SUM(products.unit_price * orders.order_quantity) FROM orders JOIN products ON products.product_id = orders.product_id ) AS cost, (SELECT COUNT(notification_id) FROM notifications WHERE notification_status='Unread') AS notification,(SELECT COUNT(log_id) FROM activity_logs WHERE log_status = 'Unread') AS log_data, (SELECT SUM(products.product_quantity * products.unit_price) FROM products) AS total_inventory, (SELECT SUM(invoices.discount) FROM invoices)AS total_discount";
        } 
        $pre_stmt= $this->con->prepare($sql);
        $pre_stmt->execute() or die($this->con->error);
        $result = $pre_stmt->get_result();
        while($row = $result->fetch_assoc()){
            $rows[] = $row;
        }
        return $rows;
    }
    // SHOW SALES AND PURCHASE REPORT INFO
        public function showSalesPurchaseReportByDate($table,$from,$end){
            $rows =[];
            if($table =='daily_sales'){
                $sql = "SELECT orders.order_id,orders.order_date,orders.product_id,products.product_name,SUM(orders.order_quantity * products.selling_price) AS sale_amount,SUM(orders.order_quantity) AS sale_quantity,SUM((orders.order_quantity * products.selling_price)-(orders.order_quantity*products.unit_price)) AS sales_margin FROM orders JOIN products ON orders.product_id = products.product_id WHERE orders.order_date BETWEEN ? AND ? GROUP BY orders.product_id ";
            }elseif($table == 'daily_card_sales'){
            $sql = "SELECT SUM(orders.order_quantity * products.selling_price) AS sales,SUM(orders.order_quantity * products.unit_price) AS cost_of_sales, SUM((orders.order_quantity * products.selling_price)-(orders.order_quantity*products.unit_price)) AS sales_margin FROM orders JOIN products ON orders.product_id = products.product_id WHERE orders.order_date BETWEEN ? AND ? ";
            }elseif($table =="daily_purchases"){
                $sql = "SELECT p.product_name,c.category_name,p.product_quantity,p.product_measurement_unit,p.unit_price, p.date_entered,p.date_updated FROM products AS p JOIN product_categories AS c ON p.product_category_id = c.category_id WHERE p.date_updated BETWEEN ? AND ?";
            }
            $pre_stmt = $this->con->prepare($sql);
            $pre_stmt->bind_param('ss',$from,$end);
            $pre_stmt->execute() or die($this->con->error);
            $result = $pre_stmt->get_result();
            while($row = $result->fetch_assoc()){
                $rows[] = $row;
            }
            return $rows;
        } 

}
// $show = new ShowInfo();
// print_r($show->showTable('inventory_category_details'));
// print_r($show->showSingleRecord('categories',10));
// echo $show->deleteRecord('product_categories','category_id',10);
// print_r($show->showTable('products'));
// print_r($show->showSingleRecord('products',11));
// print_r($show->countTables('navbar'));
// print_r($show->showTable("sales_total"));
// print_r($show->showMultipleRecordsById('show_orders',16));
// print_r($show->showInitialYearlyReports('monthly_margin','2020'));
// print_r($show->showInitialDailyReports('daily_sales','2020-05-23'));
// print_r($show->showSalesPurchaseReportByDate('daily_sales','2020-05-01','2020-05-31'));
// print_r($show->showSalesPurchaseReportByDate('daily_card_sales','2020-05-01','2020-05-31'));
// print_r($show->showTable('notifications'));

