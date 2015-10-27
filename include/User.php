<?php

//Session variables in use:
//$_SESSION['email'] - Email address
//$_SESSION['role'] - The type of user. Manager, Customer, Staff or Admin

class User
{
	private $mysqli;
	
	function __construct($mysqli)
	{
		$this->mysqli = $mysqli;
	}
	
	private function getRoleID($role)
	{
		$mysqli = $this->mysqli;
		$result = $mysqli->query("SELECT id FROM Role where role_name = '$role' LIMIT 1;");
		if($result->num_rows == 0)
		{
			throw new Exception("Database error: $role role not found.");
		}
		
		return $result->fetch_assoc()['id'];
	}
	
	private function validateRoll($role)
	{
		$validRoles = array('customer', 'staff', 'manager', 'admin');
		if(!in_array($role, $validRoles))
		{
			//This shouldn't be thrown as long as our code is correct, in which case we'll receive an error.
			throw new Exception('Invalid role.');
		}
	}
	
	//I am assuming that the rest of the user's details (Name, address, etc) will be updated during their first order
	//This is to simplify the registration process.
	//Return: void
	//Throws exceptions
	public function register($email, $password, $role)
	{
		$this->validateRoll($role);
		$mysqli = $this->mysqli;
		
		$role = $this->getRoleID($role);
		$email = $mysqli->escape_string($email);
		if($this->mysqli->query("SELECT NULL FROM User_Info WHERE email_address = '$email';")->num_rows == 0)
		{
			//Email not registered, safe to proceed
			
			$mysqli->query("INSERT INTO User_Info (email_address) VALUES ('$email');");
			$userInfo = $mysqli->insert_id;
			
			$hash = password_hash($password, PASSWORD_DEFAULT);
			$mysqli->query("INSERT INTO User (role_id, user_info_id, password) VALUES('$role', '$userInfo', '$hash');");
		}
		else
		{
			throw new Exception('An account already exists with this email address.');
		}
	}
	
	//I have assumed that this function does not need a role parameter as the variable $_SESSION['role'] will be checked after login.
	//If the login page is a separate page, this should be acceptable.
	public function login($email, $password)
	{
		$mysqli = $this->mysqli;
		
		$email = $mysqli->escape_string($email);
		$hash = password_hash($password, PASSWORD_DEFAULT);
		
		$result = $mysqli->query("SELECT role_id, password FROM User, User_Info WHERE User_Info.email_address = '$email' AND User.user_info_id = User_Info.id;");
		
		$loggedIn = false;
		
		if($result->num_rows != 0)
		{
			$result = $result->fetch_assoc();
			
			if(password_verify($password, $result['password']))
			{
				//Login successful, create session
				if(session_status() == PHP_SESSION_NONE)
				{
					session_start();
					$_SESSION['email'] = $email;
					$_SESSION['role'] = $result['role_id'];
					$loggedIn = true;
				}
			}
		}
		
		if($loggedIn == false) 
		{	
			throw new Exception('Invalid username or password.');
		}
	}
	
	public function logout()
	{
		session_destroy();
	}
	
	//Returns true if the user is logged in (has an active session) otherwise, false.
	public function isLoggedIn()
	{
		return session_status() == PHP_SESSION_ACTIVE;
	}
	
	public function getEmail()
	{
		return $_SESSION['email'];
	}
	
	public function role()
	{
		return $_SESSION['role'];
	}
}

?>