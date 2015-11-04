<?php
//Check access rights for this page.
session_start();
if($_SESSION['role'] < 4)
{
	//Send the user back to the main page
	header("Location: /staff");
	die();
}

$title = "Add Staff";

include('../../include/wrapperstart.php');

//Haven't finished this yet. The idea is that if there's an error, you won't have to enter everything again.
/*
$emailVal = "";
$firstNameVal = "";
$secondNameVal = "";
$dobVal = "";
$genderVal = "";
$addr1Val = "";
$addr2Val = "";
$cityVal = "";
$postcodeVal = "";
$countryVal = "";
//$accountTypeVal = "";
*/

$error = "";

$staffTypes = array('S' => 'Regular Staff', 'M' => 'Manager', 'A' => 'Administrator');

if(isset($_POST['submit']))
{
	$requiredFields = array('email' => 'email address', 'password1' => 'password', 'password2' => 'confirm password', 'firstName' => 'first name', 'lastName' => 'last name', 
							'dob' => 'date of birth', 'gender', 'addr1' => 'address line 1', 'city', 'postcode', 'country', 'accountType' => 'account type');
	
	foreach($requiredFields as $key => $required)
	{
		if(is_int($key)) $key = $required;
		
		if(!isset($_POST[$key]))
		{
			$error = "Please fill in the $required field for this user.";
			break;
		}
	}
	
	$now = new DateTime;
	$dob = DateTime::createFromFormat('d/m/Y', $_POST['dob']);
	$years = $dob->diff($now)->y;
	
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
	{
		$error = "Please enter a valid email address.";
	}
	else if(strlen($_POST['password1']) < 6)
	{
		$error = "The password should be at least 6 characters long.";
	}
	else if($_POST['password1'] != $_POST['password2'])
	{
		$error = "The two passwords do not match, please try again.";
	}
	else if($years < 1 || $years > 150)
	{
		$error = "Please enter a date of birth within the last 150 years.";
	}
	else if($dob == false)
	{
		$error = "Please enter a valid date of birth. Example: 05/25/1985";
	}
	//These errors should not occur unless the user edits the HTML or we receive a malformed/malicious POST
	else if($_POST['gender'] != 'Male' && $_POST['gender'] != 'Female')
	{
		$error = "Invalid gender."; 
	}
	else if(!in_array($_POST['accountType'], $staffTypes))
	{
		$error = "Invalid account type.";
	}
	
	if($error == "") //The form is valid
	{
		$role = array_search($_POST['accountType'], $staffTypes);
		$gender = array('Male' => 'M', 'Female' => 'F')[$_POST['gender']];
		$addr2 = "NULL";
		if(isset($_POST['addr2'])) $addr2 = $_POST['addr2'];
		$dob = $dob->format('Y-m-d');
		
		try
		{
			$user->register($_POST['email'], $_POST['password1'], $_POST['firstName'], $_POST['lastName'], $dob, $gender, $_POST['addr1'], $addr2, $_POST['city'], $_POST['postcode'], $_POST['country'], $role);
			
			?>
			<script>
			alert("An account has been created for <?php echo $_POST['email']; ?>.");
			</script>
			<?php
		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
		}
	}
	
	if($error != "")
	{
		$error = "<span style=\"color:#DF0101\">$error</span>";
	}
}
?>

<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>

<style>
.inline
{
	width: 65px; 
	text-align:left; 
	padding-left:0px; 
	padding-right:0px;
}
</style>

<form method="POST" class="form-horizontal" role="form">
	<p style="padding-bottom:10px;">Complete the form to add a new member of staff. Optional fields are marked with an asterix.</p>
	<?php echo $error; ?>
	<div class="form-group">
		<label class="col-lg-2 control-label">Email Address</label>
			<div class="col-lg-5">
			<input type="text" name ="email" class="form-control" placeholder="name@example.com" value="<?php echo $emailVal; ?>"required>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-lg-2 control-label">Password</label>
		<div class="col-lg-5" style="width: 200px;">
			<input type="password" name="password1" class="form-control" required>
		</div>
		<label class="col-lg-2 control-label inline" style="width:110px">Confirm Password</label>
		<div class="col-lg-5" style="width: 200px;">
			<input type="password" name ="password2" class="form-control" required>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-lg-2 control-label">First Name</label>
		<div class="col-lg-5" style="width: 200px;">
			<input type="text" name="firstName" class="form-control" value="<?php echo $firstNameVal; ?>" required>
		</div>
		<label class="col-lg-2 control-label inline">Last Name</label>
		<div class="col-lg-5" style="width: 200px;">
			<input type="text" name ="lastName" class="form-control" value="<?php echo $secondNameVal; ?>" required>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-lg-2 control-label">Date of Birth</label>
		<div class="col-lg-5" style="width: 200px;">
			<input style="width:100px;" name="dob" id="dob" type="text" class="form-control" placeholder="mm/dd/yyyy" value="<?php echo $dobVal; ?>" required>
		</div>
		<label class="col-lg-2 control-label inline">Gender</label>
		<div class="col-lg-2">
			<select class="form-control" name ="gender" style="width: 120px;">
				<option>Male</option>
				<option>Female</option>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-lg-2 control-label">Address Line 1</label>
			<div class="col-lg-5">
			<input type="text" name="addr1" class="form-control" placeholder="1 Example Road" value="<?php echo $addr1Val; ?>"required>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-lg-2 control-label">Address Line 2*</label>
			<div class="col-lg-5">
			<input type="text" name="addr2" class="form-control" placeholder="Optional" value="<?php echo $addr2Val; ?>">
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-lg-2 control-label">Town / City</label>
			<div class="col-lg-5">
			<input style="width:250px;" name="city" type="text" class="form-control" placeholder="" value="<?php echo $cityVal; ?>" required>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-lg-2 control-label">Postcode</label>
			<div class="col-lg-5">
			<input style="width:250px;" name="postcode" id="postcode"type="text" class="form-control" placeholder="" value="<?php echo $postcodeVal; ?>" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-lg-2 control-label">Country</label>
			<div class="col-lg-5">
			<input style="width:250px;" name ="country" id="postcode"type="text" class="form-control" placeholder="" value="<?php echo $countryVal; ?>" required>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-lg-2 control-label">Account Type</label>
		<div class="col-lg-2">
			<select class="form-control" name="accountType">
				<?php
				foreach($staffTypes as $type)
				{
					?> <option><?php echo $type; ?></option> <?php
				}
				?>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-6">
			<input name ="submit" type="submit" class="btn btn-sm btn-default" value="Create Account">
		</div>
	</div>
</form>

<script>
jQuery(function($)
{
	$("#dob").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
	$("#postcode").mask("*** ***",{placeholder:"___ ___"});
});
</script>

<?php
include('../../include/wrapperend.php');
?>