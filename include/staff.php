<?php
	/*******DEBUUG ***/
	ini_set("log_errors", 1);
	ini_set("error_log", "/tmp/php-error.log");
	/****** END DEBUG*****/
class  Staff
{
    private $mysqli;

    function __construct($mysqli)
	{
		$this->mysqli = $mysqli;
    }

    public function getCustomers($name)
	{
        $mysqli = $this->mysqli;

        $result = $mysqli->query("SELECT UserInfo.user_id, UserInfo.first_name, UserInfo.gender, UserInfo.last_name, UserInfo.nationality from UserInfo join User on UserInfo.user_id=User.id where User.role_id=1 and UserInfo.first_name='$name';");
        		
		return $result;
	}
	public function getUserDetails($id){
	
		$mysqli = $this->mysqli;

        $result = $mysqli->query("SELECT UserInfo.first_name, UserInfo.gender, UserInfo.last_name, UserInfo.nationality, date_format(dob,'%m/%d/%Y') as dob from UserInfo where UserInfo.user_id='$id';");
        		
		return $result;
	}
	public function deleteCustomer($id){
		/*******DEBUUG ***/
	//ini_set("log_errors", 1);
	//ini_set("error_log", "/tmp/php-error.log");
	/****** END DEBUG*****/
	
		$mysqli =$this->mysqli;
		
		$test=$mysqli->query("SELECT id, delivery_id from `Order` where Order.user_id='$id';");
		
		if($test->num_rows != 0){
			$array=array();
			$count=0;
			while ($row = $test->fetch_assoc()) {
				
				$mysqli->autocommit(false);
				$orderid=$row["id"];
				$deliveryid=$row["delivery_id"];
					$mysqli->query("DELETE FROM Order_shoe where Order_shoe.order_id='$orderid';");
					$mysqli->query("DELETE FROM `Order` where `Order`.`user_id`='$id' and `Order`.`delivery_id`='$deliveryid';");
					$mysqli->query("DELETE FROM Delivery where Delivery.id='$deliveryid';");
					
					$resultfirst=$mysqli->commit();
						if($resultfirst==false){
						$mysqli->rollback();
						return $resultfirst;
						}
			}
		}
	
		$mysqli->autocommit(false);
            
            $mysqli->query("DELETE FROM Address WHERE userinfo_id = '$id';"); 
            $mysqli->query("DELETE FROM UserInfo WHERE user_id = '$id';"); 
			$mysqli->query("DELETE FROM User WHERE id = '$id';");
			
		$result=$mysqli->commit();
        if($result==false){
		 $mysqli->rollback();
		}
		
		return $result;
	
	}
	
	public function updateCustomer($first_name, $last_name, $gender, $nationality, $date, $id){
		
		$mysqli =$this->mysqli;
		$mysqli->query("UPDATE UserInfo set first_name='$first_name', last_name='$last_name', gender='$gender', nationality='$nationality', dob='$date' WHERE UserInfo.user_id='$id' ");

		return $mysqli->affected_rows;
		
	}
	public function updateCustomerPsw($first_name, $last_name, $gender, $nationality, $date, $password, $id){
		
		$mysqli =$this->mysqli;
		
		$hash = password_hash($password, PASSWORD_DEFAULT);
		
		$mysqli->query("UPDATE UserInfo, User set UserInfo.first_name='$first_name',UserInfo.last_name='$last_name', UserInfo.gender='$gender', UserInfo.nationality='$nationality', UserInfo.dob='$date', User.password='$hash' WHERE UserInfo.user_id=User.id and UserInfo.user_id='$id';");
		
		return $mysqli->affected_rows;
		
	}

}

?>
