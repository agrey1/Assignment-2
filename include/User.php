<?php

class User
{
	private $username;
	private $role; //The type of user. Manager, Customer, Staff or Admin
	
	public function User()
	{
		
	}
	
	public function login($username, $password)
	{
		if(session_status() == PHP_SESSION_NONE)
		{
			session_start();
		}
	}
	
	public function logout()
	{
		session_destroy();
	}
	
	public function getUsername()
	{
		return $this->username;
	}
	
	public function role()
	{
		return $this->role;
	}
}

$user = new User();

?>