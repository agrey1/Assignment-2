<?php
	/*******DEBUUG ***/
	ini_set("log_errors", 1);
	ini_set("error_log", "/tmp/php-error.log");
	/****** END DEBUG*****/
class  Supplier
{
    private $mysqli;

    function __construct($mysqli)
	{
		$this->mysqli = $mysqli;
    }

	public function getSupplierbyName($name)
	{
        $mysqli = $this->mysqli;

        $result = $mysqli->query("SELECT Supplier.id, Supplier.supplier_name, Supplier.address_id, Supplier.phonenumber, Supplier.email, Address.first_line, Address.second_line, Address.postcode, Address.city, Address.country from Supplier, Address WHERE Supplier.supplier_name='$name' and Supplier.address_id=Address.id;");
        		
		return $result;
	}
	public function getSupplierbyShoe($name)
	{
        $mysqli = $this->mysqli;

        $result = $mysqli->query("SELECT distinct Supplier.supplier_name, Supplier.address_id, Supplier.phonenumber, Supplier.email, Address.first_line, Address.second_line, Address.postcode, Address.city, Address.country  from Supplier, Address, Shoe_supplier, Shoe  WHERE Supplier.address_id=Address.id and Supplier.id= Shoe_supplier.supplier_id and Shoe_supplier.shoe_id=Shoe.id and Shoe.shoe_name='$name';");
        		
		return $result;
	}
	//~ public function getAddress($id)
	//~ {	
		//~ $mysqli = $this->mysqli;

        //~ $result = $mysqli->query("SELECT first_line,second_line,city,postcode,country FROM `Address` WHERE id='$id';");
        		
		//~ return $result;
	//~ }
	public function deleteSupplier($id, $addressid)
	{
        $mysqli = $this->mysqli;
        
        $mysqli->autocommit(false);

        $mysqli->query("DELETE Shoe_supplier FROM Shoe_supplier WHERE Shoe_supplier.supplier_id='$id';");
        $mysqli->query("DELETE Supplier FROM Supplier WHERE Supplier.id='$id';");
        $mysqli->query("DELETE Address FROM Address WHERE Address.id='$addressid';");
        
        $result=$mysqli->commit();
		return $result;
	}
	
	public function addSupplier($supplier_name, $phonenumber, $email, $first_line, $second_line, $postcode, $city, $country)
	{
        
        $mysqli = $this->mysqli;
        
        $mysqli->autocommit(false);
        
        $mysqli->query("INSERT INTO Address (first_line, second_line, city, postcode, country) VALUES ('$first_line', '$second_line', '$city', '$postcode', '$country');");
		$addressid=$mysqli->insert_id;
		$mysqli->query("INSERT INTO Supplier (supplier_name, address_id, phonenumber, email) VALUES ('$supplier_name', '$addressid', '$phonenumber', '$email');");
		
		$result=$mysqli->commit();
		//~ if (!$mysqli->multi_query($sql)) {
			//~ echo "Multi query failed: (" . $mysqli->errno . ") " . $mysqli->error;
			//~ }	
		return $result;
	}
	public function updateSupplierAddress($addressid, $first_line, $second_line, $city, $postcode, $country){
	
	$mysqli = $this->mysqli;
        
        $result=$mysqli->query("UPDATE Address SET Address.first_line='$first_line', Address.second_line='$second_line', Address.city='$city', Address.postcode='$postcode', Address.country='$country' WHERE Address.id='$addressid';");
        
        return $result;
	}
	public function updateSupplier($id, $supplier_name, $phonenumber, $email){
		
		$mysqli = $this->mysqli;
        
        $result=$mysqli->query("UPDATE Supplier SET Supplier.supplier_name='$supplier_name',Supplier.phonenumber='$phonenumber', Supplier.email='$email' WHERE Supplier.id='$id';");
		
		return $result;
	}
}
