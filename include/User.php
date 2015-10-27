<?php

class User
{
	private $username;
	private $role; //The type of user. Manager, Customer, Staff or Admin
	
	public function User()
	{
		
	}
	
	public function register($username, $password)
	{
		
	}
	
	public function login($username, $password)
	{
		//Perform authentication here, perhaps throw some exceptions
		//...
		
		//Login successful, create session
		if(session_status() == PHP_SESSION_NONE)
		{
			session_start();
			$_SESSION['username'] = $username;
			//$_SESSION['role'] = $role;
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
	
	public function getUsername()
	{
		return $_SESSION['username'];
	}
	
	public function role()
	{
		return $_SESSION['role'];
	}
}

$user = new User();

?>