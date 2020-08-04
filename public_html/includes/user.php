<?php
class User {
	private $con;

	function __construct() {
		include_once("../db/dbh.php");
		$db = new Database();
		$this->con = $db->connect();
	}
	//Email Exists
	private function emailExists($email){
		$pre_stmt = $this->con->prepare("SELECT * FROM users WHERE user_email=?");
		$pre_stmt->bind_param("s",$email);
		$pre_stmt->execute() or die($this->con->error);
		$result = $pre_stmt->get_result();
		if($result->num_rows > 0){
			return 1;
		} else {
			return 0;
		}
	}
	//Create User Account
	public function createUserAccount($fullname,$email,$username,$password,$userType){
		$fullname = htmlentities(mysqli_real_escape_string($this->con,$fullname));
		$email = htmlentities(mysqli_real_escape_string($this->con,$email));
		$username = htmlentities(mysqli_real_escape_string($this->con,$username));
		$password = htmlentities(mysqli_real_escape_string($this->con,$password));
		$userType = htmlentities(mysqli_real_escape_string($this->con,$userType));
		
		if($this->emailExists($email)){
			return 'EMAIL_EXISTS';
		} else {
			$pass_hash = password_hash($password,PASSWORD_DEFAULT);
			$date = date("Y-m-d h:i:s");
			$sql = "INSERT INTO `users`(`user_name`,`fullname`, `user_email`, `user_pwd`, `user_type`, `register_date`, `last_login`) VALUES (?,?,?,?,?,?,?)";
			$pre_stmt = $this->con->prepare($sql);
			$pre_stmt->bind_param('sssssss',$username,$fullname,$email,$pass_hash,$userType,$date,$date);
			$result = $pre_stmt->execute() or die($this->con->error);
			if($result){
				return 'REGISTERED SUCCESSFULLY';
			} else {
				return 'SOME_ERROR';
			}
		}
		
	}
	//User Login
	public function userLogin($email,$pass){
		$email = htmlentities(mysqli_real_escape_string($this->con,$email));
		$pass = htmlentities(mysqli_real_escape_string($this->con,$pass));

		$sql = "SELECT user_id,user_name,fullname,user_email,user_pwd,user_type,user_status,register_date,last_login FROM
				users WHERE user_email=? AND user_status='Active'";
		$pre_stmt = $this->con->prepare($sql);
		$pre_stmt->bind_param('s',$email);
		$pre_stmt->execute() or die($this->con->error);
		$result = $pre_stmt->get_result();
		if($result->num_rows < 1){
			return 'NOT_REGISTERED';
		} else {
			$row = $result->fetch_assoc();
			if(password_verify($pass,$row['user_pwd'])){
				//SET SESSIONS
				$_SESSION['user_id'] = $row['user_id'];
				$_SESSION['fullname'] = $row['fullname'];
				$_SESSION['user_name'] = $row['user_name'];
				$_SESSION['user_email'] = $row['user_email'];
				$_SESSION['user_type'] = $row['user_type'];
				$_SESSION['register_date'] = $row['register_date'];
				$_SESSION['last_login'] = $row['last_login'];

				// SET BUSINESS NAME SESSION
				$pre_stmt = $this->con->prepare("SELECT business_name FROM user_settings LIMIT 1");
				$pre_stmt->execute() or die($this->con->error);
				$result = $pre_stmt->get_result();
				$row = $result->fetch_assoc();
				$_SESSION["business_name"] = $row["business_name"];
				
				$last_login = date("Y-m-d h:i:s");
				$log_msg = $_SESSION['user_name'].' logged in';
				$log_status='Unread';
				//INSERT INTO ACTIVITY LOGS
				$pre_stmt = $this->con->prepare("INSERT INTO `activity_logs`(`log_date`, `log_description`, `log_status`) VALUES (?,?,?)");
				$pre_stmt->bind_param('sss',$last_login,$log_msg,$log_status);
				$pre_stmt ->execute() or die($this->con->error);

				//UPDATE LAST LOGIN
				$pre_stmt = $this->con->prepare("UPDATE users SET last_login = ? WHERE user_email = ?");
				$pre_stmt->bind_param('ss',$last_login,$email);
				$result = $pre_stmt->execute() or die($this->con->error);
				if($result){
					return 'LOGIN_SUCCESSFUL';
				} else {
					return 0;
				}

			} else {
				return 'PASSWORD_NOT_MATCHED';
			}
		}

	}
	public function userLogout(){
		$log_date = date('Y-m-d h:i:s');
		$log_msg = $_SESSION['user_name'] .' logged out';
		$log_status ='Unread';
		$sql = "INSERT INTO `activity_logs`(`log_date`, `log_description`, `log_status`) VALUES (?,?,?)";
		$pre_stmt = $this->con->prepare($sql);
		$pre_stmt->bind_param('sss',$log_date,$log_msg,$log_status);
		$result = $pre_stmt->execute() or die($this->con->error);
		if($result){
			return 'LOGOUT';
		}else {
			return false;
		}
	}
	public function showProfile($table){
		$rows =[];
		if($table == 'users'){
		$sql = "SELECT user_id,user_name,fullname,user_email,user_type,user_status,register_date,last_login FROM users";
		}
		$pre_stmt = $this->con->prepare($sql);
		$pre_stmt->execute() or die($this->con->error);
		$result = $pre_stmt->get_result();
		while($row = $result->fetch_assoc()){
			$rows[] = $row;
		}
		return $rows;
	}
	// EDIT USER PROFILE
	public function editUserProfile($id,$fullname,$username,$email,$user_type,$status){
		$id = htmlentities(mysqli_real_escape_string($this->con,$id));
		$fullname = htmlentities(mysqli_real_escape_string($this->con,$fullname));
		$username = htmlentities(mysqli_real_escape_string($this->con,$username));
		$email = htmlentities(mysqli_real_escape_string($this->con,$email));
		$user_type = htmlentities(mysqli_real_escape_string($this->con,$user_type));
		$status = htmlentities(mysqli_real_escape_string($this->con,$status));
		$sql = "UPDATE `users` SET `user_name`= ?,`fullname`=?,`user_email`=?,`user_type`=?,`user_status`=? WHERE `user_id` =?";
		$pre_stmt = $this->con->prepare($sql);
		$pre_stmt->bind_param('sssssi',$username,$fullname,$email,$user_type,$status,$id);
		$result = $pre_stmt->execute() or die($this->con->error);
		if($result){
			return "USER_PROFILE_UPDATED";
		} else{
			return "SOME_ERROR_OCCURED";
		}

	}
	// PUBLIC FUNCTION CHANGE PASSWORD
	public function changeUserPassword($id,$oldPwd,$newPwd){
		$id = htmlentities(mysqli_real_escape_string($this->con,$id));
		$oldPwd = htmlentities(mysqli_real_escape_string($this->con,$oldPwd));
		$newPwd = htmlentities(mysqli_real_escape_string($this->con,$newPwd));
		$sql = "SELECT user_pwd FROM users WHERE user_id=?";
		$pre_stmt = $this->con->prepare($sql);
		$pre_stmt->bind_param('i',$id);
		$pre_stmt->execute() or die($this->con->error);
		$result = $pre_stmt->get_result();
		$row = $result->fetch_assoc();		
		if(password_verify($oldPwd,$row['user_pwd'])){
			$pass_hash = password_hash($newPwd,PASSWORD_DEFAULT);
			$sql = "UPDATE users SET user_pwd =? WHERE user_id =?";
			$pre_stmt = $this->con->prepare($sql);
			$pre_stmt->bind_param('si',$pass_hash,$id);
			$result = $pre_stmt->execute() or die($this->con->error);
			if($result){
				return "PASSWORD_UPDATED";
			}else{
				return "SOME_ERROR_OCCURED";
			}
		} else {
			return "INCORRECT_PASSWORD";
		}
	}

}
// $user = new User();
// echo $user->userLogout();
// echo $user->emailExists('kobby@kobby.com');
// echo $user->createUserAccount("Kobina Otu","kobby@gmail.com","Kobby104","1234567890","Admin");
//  print_r($user->userLogin('kobby@gmail.com','1234567890'));
// print_r($user->showProfile('users'));
// echo $user->changeUserPassword(1,'123456789','1234567890');
