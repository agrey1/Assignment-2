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
            <p> '*' to search all users</p>

<p>Allow admins and managers to make changes to customer accounts. (View, delete, edit)</p>

<?php
if(isset($_POST['fname']))
{	
	$staff = new Staff($mysqli);
	
		$result=$staff->getCustomers($_POST['fname']);	
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

$user_id=$_REQUEST['id'];
$_SESSION['user_id'] = $user_id;

$result=$staff->getUserDetails($user_id);
$row = $result->fetch_assoc();
if ($row!=null) { 
	?>
		<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-7 col-xs-offset-2">
	<h3>Edit Profile Values</h3>
     <form action="/staff/customers.php" method="POST">
             <div class="form-group">
                    <label for="first_name"> First Name: </label>  
                    <input type="text" name="first_name" size="25" class="form-control" value="<?php echo $row["first_name"];?>">
                </div>
                <div class="form-group">
                    <label for="last_name"> Last Name: </label>  
                    <input type="text" name="last_name" size="25" class="form-control" value="<?php echo $row["last_name"];?>">
                </div>
                <div class="form-group">
                    <label for="nationality"> Nationality: </label>  
                    <input type="text" name="nationality" class="form-control" value="<?php echo $row["nationality"];?>">
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
                    <input id="dob" name="dob" type="text" style="width:100px;" class="form-control" value="<?php echo $row["dob"];?>">
                </div>
                <div class="form-group">
                    <label for="password"> Password: </label>  
                    <input id="password"  name='password' type="password" style="width:100px;" class="form-control">
                </div>

                <button type="submit" name="editvalues" value="Edit Values" class="btn btn-default">Edit Values</button>
            </form>
</div>



<?php
 }


}elseif ($_POST['delete']){
	/*******DEBUUG ***/
	ini_set("log_errors", 1);
	ini_set("error_log", "/tmp/php-error.log");
	/****** END DEBUG*****/
	
	$staff = new Staff($mysqli);
	//debug
//printf("Select returned %d rows. <br/>", $result->num_rows);
$user_id=$_REQUEST['id'];
//end debug

	
	
	$result=$staff->deleteCustomer($user_id);
	//error_log( "ERRORRR " . (string)$result);
	if($result == 0){
	 echo "Echo Customer cannot be deleted";
	die();
	} 

}elseif($_POST['editvalues']){
	/*******DEBUUG ***/
	ini_set("log_errors", 1);
	ini_set("error_log", "/tmp/php-error.log");
	/****** END DEBUG*****/
	
	$staff = new Staff($mysqli);
	
	$user_id= $_SESSION['user_id'];
	
	
    $dateFormated = explode("/", $_REQUEST['dob']);
    $date = $dateFormated[2].'-'.$dateFormated[0].'-'.$dateFormated[1];
	
	error_log("DOBBB " . $date);
	
	if($_REQUEST['password']==""){
	$result=$staff->updateCustomer($_REQUEST['first_name'], $_REQUEST['last_name'],$_REQUEST['gender'], $_REQUEST['nationality'], $date,$user_id);
	}else{
	$result=$staff->updateCustomerPsw($_REQUEST['first_name'], $_REQUEST['last_name'], $_REQUEST['gender'], $_REQUEST['nationality'], $date, $_REQUEST['password'], $user_id);
	}
	//Remove Variable from session
	$unset($_SESSION['user_id']);
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
