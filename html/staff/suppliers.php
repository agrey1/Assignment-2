<?php
/*******DEBUUG ***/
	//~ ini_set("log_errors", 1);
	//~ ini_set("error_log", "/tmp/php-error.log");
	/****** END DEBUG*****/
//Check access rights for this page.
session_start();
if($_SESSION['role'] < 3)
{
	//Send the user back to the main page
	header("Location: /staff");
	die();
}
require_once('../../include/suppliers.php');
$title = "Suppliers";

include('../../include/wrapperstart.php');

function isdateValid($date)
{
	if(strlen($date)!=10){
		return false;
	}
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') == $date;
}
function ispostcodeValid($postcode)
{
    
    if(strlen($postcode)<=7  && preg_match("/^[a-zA-Z0-9 ]+$/", $postcode) == 1) {
	return true;
	}
    
}
function isphonenumberValid($phonenumber){
	//~ $test=preg_match("/^[0-9 ]+$/", $phonenumber) == 1;
	//~ echo "$test<br/>";
	if(strlen($phonenumber)<=16  && preg_match("/^[0-9 ]+$/", $phonenumber) == 1) {
	return true;
	}
}
?>
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<div class="container"></div>
<h3>Search Supplier</h3>

<form class="pull-right" action="/staff/suppliers.php" method="POST">
	<input type="submit" name="addsupplier" value="Add Supplier">
</form>

<form action="/staff/suppliers.php" method="POST">
             
             <select name="searchby">
				 <option value="byname">by Name</option>
				 <option value="byshoe">by Shoe Name</option>
             </select>
				<input type="text" name="fname">
                <input type="submit" name="srcsupplier" value="Submit">
</form >


<p>Allow admins and managers to view, edit and add supplier information.</p>


</div>
<?php
if(isset($_POST['fname'])){
	/*******DEBUUG ***/
	//~ ini_set("log_errors", 1);
	//~ ini_set("error_log", "/tmp/php-error.log");
	/****** END DEBUG*****/
		
		$suppliers = new Supplier($mysqli);
	
	
	$searchby= $_REQUEST['searchby'];
	$fname=$mysqli->escape_string($_REQUEST['fname']);
	if($searchby=="byname"){
		$result=$suppliers->getSupplierbyName($fname);
	}else if($searchby=="byshoe"){
		$result=$suppliers->getSupplierbyShoe($fname);	
	}
	
		if($result->num_rows != 0){
			?>
			  <br/>
			  <div class="container">
              <div class="panel panel-default">
              <!-- Default panel contents -->
              <div class="panel-heading">Customer Results</div>
              <table class="table">
                        <tr>
                            <td>#</td>
                            <td>Supplier Name</td>
                            <td>Phone Number</td>
                            <td>Email</td>
                            <td>Address</td>
                            <td>Edit</td>
                            <td>Delete</td>                     
                        </tr>
<?php
		$i=1;
		while ($row = $result->fetch_assoc()) {?>		
			<tr>
				<td><?php echo "$i";?></td>
				<td><?php echo $row["supplier_name"];?> </td>
				<td><?php echo $row["phonenumber"];?></td>
				<td><?php echo $row['email'];?></td>
				<!--Get Address of Supplier-->
				<td><?php
				echo $row["first_line"] . "<br/>";
				echo $row["second_line"]."<br/>";
				echo $row["city"]. "<br/>";
				echo $row["postcode"]. "<br/>";
				echo $row["country"];
				?></td>
				<td>
				<!--form code Use User_info id to delete from tables-->
				<form action="/staff/suppliers.php" method="POST">
					<input type="hidden" name="name" value="<?php echo $row["supplier_name"];?>">
					<input type="submit" name="edit" value="Edit">
				</form>
				</td>
				<td>
				<form action="/staff/suppliers.php" method="POST">
					<input type="hidden" name="addressid" value="<?php echo $row["address_id"];?>">
					<input type="hidden" name="id" value="<?php echo $row['id'];?>">
					<input type="submit" name="delete" value="Delete">
				</form>
				</td>
			</tr>
	
			<?php $i++;
        //printf ("%s %s %s\n", $row["gender"], $row["nationality"], $row["last_name"]);
		
    }?>
    </table>
    </div>
    </div>
<?php
		
		
	}

}else if($_POST['addsupplier']){ ?>
		<br/>
		<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-7 col-xs-offset-2" style="background-color: #ededed;">
	<h3>Add Supplier Information</h3>
     <form action="/staff/suppliers.php" method="POST">
             <div class="form-group">
                    <label for="first_name"> Supplier Name: </label>  
                    <input type="text" name="supplier_name" maxlength="20" style="width:250px;" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="last_name"> Phone Number: </label>  
                    <input id="phonenumber" type="text"  maxlength="16" name="phonenumber" style="width:250px;" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="nationality"> Email: </label>  
                    <input type="text" name="email" maxlength="20" class="form-control" style="width:250px;" required>
                </div>
				<h3>Address:</h3>
                <div class="form-group">
                    <label for="first_line"> First line: </label>  
                    <input  name="first_line" type="text" maxlength="20" style="width:250px;"class="form-control" required>
                </div>   
                <div class="form-group">
                    <label for="second_line"> Second line: </label>  
                    <input name='second_line' type="text" maxlength="20" style="width:250px;" class="form-control" required>
                </div>
                 <div class="form-group">
                    <label for="postcode"> Postcode: </label>  
                    <input id="postcode"  name='postcode' maxlength="7" type="text" size="6" style="width:100px;" class="form-control" required>
                </div>
                 <div class="form-group">
                    <label for="city"> City: </label>  
                    <input  name='city' type="text" maxlength="20" style="width:250px;" class="form-control" required>
                </div>
				 <div class="form-group">
                    <label for="country"> Country: </label>  
                    <input name='country' type="text" maxlength="20" style="width:250px;" class="form-control" required>
                </div>
                <button type="submit" name="submitsupplier" value="Edit Values" class="btn btn-default">Add Supplier</button>
            </form>
</div>

<?php 
}else if(isset($_POST['submitsupplier'])){
	/*******DEBUUG ***/
	//~ ini_set("log_errors", 1);
	//~ ini_set("error_log", "/tmp/php-error.log");
	/****** END DEBUG*****/
	$suppliers = new Supplier($mysqli);
	
	//error_log($_REQUEST['supplier_name']. " " .$_REQUEST['phonenumber']. " " .$_REQUEST['email']. " " .$_REQUEST['first_line']. " " .$_REQUEST['second_line']. " " .$_REQUEST['postcode']. " " .$_REQUEST['city']. " " .$_REQUEST['country']);
	$supplier_name=$mysqli->escape_string($_REQUEST['supplier_name']);
	$phonenumber=$mysqli->escape_string($_REQUEST['phonenumber']);
	$email=$mysqli->escape_string($_REQUEST['email']);
	$first_line=$mysqli->escape_string($_REQUEST['frst_line']);
	$second_line=$mysqli->escape_string($_REQUEST['second_line']);
	$postcode=$mysqli->escape_string($_REQUEST['postcode']);
	$city=$mysqli->escape_string($_REQUEST['city']);
	$country=$mysqli->escape_string($_REQUEST['country']);
	
	if(strlen($supplier_name)>20 || strlen($email)>20 || strlen($first_line)>20 || strlen($second_line)>20 || strlen($city)>20 || strlen($country)>20){
		echo "Input String too long, possibly > 20 Chars. Reconsider input please...";
		exit();
	}
	if(!ispostcodeValid($postcode)){
		echo "Postcode format wrong or length exceeded";
		exit();
	}
	if(!isphonenumberValid($phonenumber)){
	echo "Postnumber format wrong or length exceeded";
		exit();
	}
	
	
	$result=$suppliers->addSupplier($supplier_name, $phonenumber, $email ,$first_line,$second_line,$postcode ,$city ,$country);
	
	//returns boolean
	if($result == 0){
	echo "Error - Supplier cannot be added!";
	die();
	}else{
	echo "<br/> Supplier has been added!";
	} 
}else if(isset($_POST['edit'])){
	/*******DEBUUG ***/
	//~ ini_set("log_errors", 1);
	//~ ini_set("error_log", "/tmp/php-error.log");
	/****** END DEBUG*****/

	$suppliers = new Supplier($mysqli);
	
	$name=$mysqli->escape_string($_REQUEST['name']);
	$result=$suppliers->getSupplierbyName($name);
	
	if($result->num_rows != 0){ 
		$row = $result->fetch_assoc();?>
		<br/>
		<div class="col-md-8 col-md-offset-2">
			<div class="container center-block" style="background-color: #ededed;">
				
					
				<div style="display:block; float:left; padding:30px;">
					<h3> Supplier Address</h3>
				<br/>
				<form action="/staff/suppliers.php" method="POST">
				 <div class="form-group">
                    <label for="first_line"> First Line: </label>  
                    <input type="text" name="first_line" maxlength="20" style="width:250px;" class="form-control" value="<?php echo $row["first_line"];?>" required>
                </div>
                <div class="form-group">
                    <label for="second_line"> Second Line: </label>  
                    <input type="text" name="second_line" maxlength="20" style="width:250px;" class="form-control" value="<?php echo $row["second_line"];?>" required>
                </div>
                <div class="form-group">
                    <label for="postcode"> Postcode: </label>  
                    <input id="postcode"  name='postcode'  maxlength="7" type="text" size="6" style="width:100px;" class="form-control" value="<?php echo $row["postcode"]; ?>" required>
                </div>
                 <div class="form-group">
                    <label for="city"> City: </label>  
                    <input  name='city' type="text" maxlength="20" style="width:250px;" class="form-control" value="<?php echo $row["city"]; ?>" required>
                </div>
				 <div class="form-group">
                    <label for="country"> Country: </label>  
                    <input name='country' type="text" maxlength="20" style="width:250px;" class="form-control" value="<?php echo $row["country"]; ?>" required>
                </div>
                <button type="submit" name="editaddress" class="btn btn-default">Edit Supplier Address</button>
					<input type="hidden" name="addressid" value="<?php echo $row['address_id'];?>">
				</form>
				</div>
					
					<div style="display:block; float:left; padding:30px;">
						<h3>Supplier Details</h3>
					<br/>
			 <form action="/staff/suppliers.php" method="POST">
				 <div class="form-group">
                    <label for="supplier_name"> Supplier Name: </label>  
                    <input type="text" name="supplier_name" style="width:250px;" maxlength="20" class="form-control" value="<?php echo $row["supplier_name"];?>" required>
                </div>
                <div class="form-group">
                    <label for="phonenumber"> Phone Number: </label>  
                    <input type="text" name="phonenumber" style="width:250px;" maxlength="16" class="form-control" value="<?php echo $row["phonenumber"];?>" required>
                </div>
                <div class="form-group">
                    <label for="email"> Email: </label>  
                    <input type="text" name="email" style="width:250px;" maxlength="20" class="form-control" value="<?php echo $row["email"];?>" required>
                </div>
					<input type="hidden" name="id" value="<?php echo $row['id'];?>">
                <button type="submit" name="editsupplier" class="btn btn-default">Edit Supplier</button>
				</form>
				</div>
				
				</div>
		</div>
	<?php } 
}else if(isset($_POST['editaddress'])){
	/*******DEBUUG ***/
	//~ ini_set("log_errors", 1);
	//~ ini_set("error_log", "/tmp/php-error.log");
	/****** END DEBUG*****/
	$suppliers = new Supplier($mysqli);
	
	//error_log(" ID" . $_REQUEST['addressid']. " " .$_REQUEST['first_line'].$_REQUEST['second_line'].$_REQUEST['city'].$_REQUEST['postcode'].$_REQUEST['country']);
	
	$first_line=$mysqli->escape_string($_REQUEST['first_line']);
	$second_line=$mysqli->escape_string($_REQUEST['second_line']);
	$city=$mysqli->escape_string($_REQUEST['city']);
	$postcode=$mysqli->escape_string($_REQUEST['postcode']);
	$country=$mysqli->escape_string($_REQUEST['country']);
	
	$addressid=$mysqli->escape_string($_REQUEST['addressid']); //This is probably not necessary
	 
	if(!ispostcodeValid($postcode)){
		echo "Postcode format wrong or length exceeded";
		exit();
	}
	if(strlen($first_line)>20 || strlen($second_line)>20 || strlen($city)>20 || strlen($country)>20){
		echo "Input String too long, possibly > 20 Chars. Reconsider input please...";
		exit();
	}
	
	
	$result=$suppliers->updateSupplierAddress($addressid,$first_line,$second_line,$city,$postcode,$country);
	if($result == 0){
		echo "No Address has been updated!";
		die();
	}else{
	echo "<br/> Address has been updated!";
	} 
	


}else if(isset($_POST['editsupplier'])){
	/*******DEBUUG ***/
	//~ ini_set("log_errors", 1);
	//~ ini_set("error_log", "/tmp/php-error.log");
	/****** END DEBUG*****/
	$suppliers = new Supplier($mysqli);
	//~ //error_log("Supplier " . $_REQUEST['id']. " " . $_REQUEST['addressid']);
	
	$id=$mysqli->escape_string($_REQUEST['id']);
	$supplier_name=$mysqli->escape_string($_REQUEST['supplier_name']);
	$phonenumber=$mysqli->escape_string($_REQUEST['phonenumber']);
	$email=$mysqli->escape_string($_REQUEST['email']);
	
	if(strlen($supplier_name)>20 || strlen($email)>20 ){
		echo "Input String too long, possibly > 20 Chars. Reconsider input please...";
		exit();
	}
	if(!isphonenumberValid($phonenumber)){
	echo "Phonenumber format wrong or length exceeded";
		exit();
	}
	
	$result=$suppliers->updateSupplier($id, $supplier_name, $phonenumber, $email);
	
	if($result == 0){
		echo "No Supplier has been updated!";
		die();
	}else{
	echo "<br/> Supplier has been updated!";
	} 
}else if(isset($_POST['delete'])){

	/*******DEBUUG ***/
	//~ ini_set("log_errors", 1);
	//~ ini_set("error_log", "/tmp/php-error.log");
	/****** END DEBUG*****/
	$suppliers = new Supplier($mysqli);
	
	$id=$mysqli->escape_string($_REQUEST['id']);
	$addressid=$id=$mysqli->escape_string($_REQUEST['addressid']);
	$result=$suppliers->deleteSupplier($id, $addressid);
	
	//returns boolean
	if($result == 0){
		echo "No Supplier has been deleted!";
		die();
	}else{
	echo "<br/> Supplier has been deleted!";
	} 
}
?>
<script>
jQuery(function($)
{
	$("#postcode").mask("*** ***",{placeholder:"___ ___"});
	$("#phonenumber").mask("0099 999-9999999");
});
</script>
<?php
include('../../include/wrapperend.php');
?>
