<?php

//Check access rights for this page.
session_start();
if($_SESSION['role'] < 3)
{
	//Send the user back to the main page
	header("Location: /staff/customers.php");
	die();
}

require_once('../../include/staff.php');

$title = "Customers";

include('../../include/wrapperstart.php');
?>
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>

<h3>Search Customer</h3>

<form action="/staff/customers.php" method="POST">
             
				<input type="text" name="fname">
                <input type="submit" name="searchcustomer" value="Submit">
</form>
<!--
            <p> '*' to search all users</p>
-->

<p>Allow admins and managers to make changes to customer accounts. (View, delete, edit)</p>

<?php
if(isset($_POST['fname']))
{	
	$staff = new Staff($mysqli);
		
		$fname=$mysqli->escape_string($_POST['fname']);	
		$result=$staff->getCustomers($fname);	
		
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
                            <td>First Name</td>
                            <td>Last Name</td>
                            <td>Gender</td>
                            <td>Nationality</td>
                            <td>Edit</td>
                            <td>Delete</td>                     
                        </tr>
<?php
		$i=1;
		while ($row = $result->fetch_assoc()) {?>		
			<tr>
				<td><?php echo "$i";?></td>
				<td><?php echo $row["first_name"];?> </td>
				<td><?php echo $row["last_name"];?></td>
				<td><?php echo $row['gender'];?></td>
				<td><?php echo $row["nationality"];?></td>
				<td>
				<!--form code Use User_info id to delete from tables-->
				<form action="/staff/customers.php" method="POST">
					<input type="hidden" name="id" value="<?php echo $row["user_id"];?>">
					<input type="submit" name="edit" value="Edit">
				</form>
				</td>
				<td>
				<form action="/staff/customers.php" method="POST">
					<input type="hidden" name="id" value="<?php echo $row["user_id"];?>">
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
}elseif ($_POST['edit']){
	$staff = new Staff($mysqli);
//debug
printf("Select returned %d rows. <br/>", $result->num_rows);

$id=$_REQUEST['id'];
$_SESSION['user_id'] = $id;
$user_id=$mysqli->escape_string($id);
$result=$staff->getUserDetails($user_id);
$row = $result->fetch_assoc();
if ($row!=null) { 
	?>
		<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-7 col-xs-offset-2">
			<div class="container center-block" style="background-color: #ededed;">
				<br/>
	<h3>Edit Profile Values</h3>
     <form action="/staff/customers.php" method="POST">
             <div class="form-group">
                    <label for="first_name"> First Name: </label>  
                    <input type="text" name="first_name" size="25" class="form-control" value="<?php echo $row["first_name"];?>" required>
                </div>
                <div class="form-group">
                    <label for="last_name"> Last Name: </label>  
                    <input type="text" name="last_name" size="25" class="form-control" value="<?php echo $row["last_name"];?>" required>
                </div>
                <div class="form-group">
                    <label for="nationality"> Nationality: </label>  
                    <input type="text" name="nationality" class="form-control" value="<?php echo $row["nationality"];?>" required>
                </div>
                <div class="form-group">
                    <label for="gender"> Gender: </label>  
                     <select name="gender">
						<option ><?php echo $row["gender"];?></option>
						<?php if($row["gender"]=="M"){?>
						<option >F</option>
						<?php }else{?>
						<option>M</option>
						<?php }?>	
					 </select>  
                </div>
                <div class="form-group">
                    <label for="dob"> Date of Birth: </label>  
                    <input id="dob" name="dob" type="text" style="width:100px;" class="form-control" value="<?php echo $row["dob"];?>" required>
                </div>
                <div class="form-group">
                    <label for="password"> Password: </label>  
                    <input id="password"  name='password' type="password" style="width:100px;" class="form-control" value="">
                </div>

                <button type="submit" name="editvalues" value="Edit Values" class="btn btn-default">Edit Values</button>
            </form>
            <br/>
</div>
</div>


<?php
 }


}elseif ($_POST['delete']){
	/*******DEBUUG ***/
	//~ ini_set("log_errors", 1);
	//~ ini_set("error_log", "/tmp/php-error.log");
	/****** END DEBUG*****/
	
	$staff = new Staff($mysqli);

	$id=$_REQUEST['id'];
	$user_id=$mysqli->escape_string($id);
	
	$result=$staff->deleteCustomer($user_id);
	//error_log( "ERRORRR " . (string)$result);
	if($result == 0){
	 echo "Echo Customer cannot be deleted";
	die();
	}else{
	echo "<br/> Customer has been deleted!";
	}  

}elseif($_POST['editvalues']){
	/*******DEBUUG ***/
	ini_set("log_errors", 1);
	ini_set("error_log", "/tmp/php-error.log");
	/****** END DEBUG*****/
	
	$staff = new Staff($mysqli);
	
	$id= $_SESSION['user_id'];
	
	
	

    $dateFormated = explode("/", $mysqli->escape_string($_REQUEST['dob']));
    $date = $dateFormated[2].'-'.$dateFormated[0].'-'.$dateFormated[1];
	
	
	$user_id=$mysqli->escape_string($id);
	$first_name=$mysqli->escape_string($_REQUEST['first_name']);
	$last_name=$mysqli->escape_string($_REQUEST['last_name']);
	$gender=$mysqli->escape_string($_REQUEST['gender']);
	$nationality=$mysqli->escape_string($_REQUEST['nationality']);
	
	if($_REQUEST['password']==""){
	$result=$staff->updateCustomer($first_name, $last_name,$gender, $nationality, $date, $user_id);
	}else{
	$password=$mysqli->escape_string($_REQUEST['password']);
	$result=$staff->updateCustomerPsw($first_name, $last_name, $gender, $nationality, $date, $password, $user_id);
	}
	
	//error_log("AFFECTED ROWS" . (string)$result);
	//Remove Variable from session
	unset($_SESSION['user_id']);
	
	if($result == 0){
		echo "No Customer has been updated!";
		die();
	}else{
	echo "<br/> Customer Profile has been updated!";
	} 
}
?>
<script>
jQuery(function($)
{
	$("#dob").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
});
</script>
<?php
include('../../include/wrapperend.php');
?>
