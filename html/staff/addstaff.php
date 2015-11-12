<?php
//Check access rights for this page.
session_start();
if($_SESSION['role'] < 4)
{
	//Send the user back to the main page
	header("Location: /staff");
	die();
}

$values['email'] = "";
$values['firstName'] = "";
$values['lastName'] = "";
$values['dob'] = "";
$values['gender'] = "";
$values['addr1'] = "";
$values['addr2'] = "";
$values['city'] = "";
$values['postcode'] = "";
$values['country'] = "";
$values['accountType'] = "";

$title = "Add Staff";
$message = "Complete the form to add a new member of staff. Optional fields are marked with an asterix.";
$action = "Create Account";
if(isset($_POST['edit']))
{
	$message = "Make changes to the form below to edit this account. Optional fields are marked with an asterix.";
	$action = "Save Changes";
	
	require_once('../../include/connect.php');
	$mysqli = mysqlConnect();
	$result = $mysqli->query("SELECT first_name, last_name FROM UserInfo WHERE user_id = '" . $mysqli->escape_string($_POST['edit']) . "';")->fetch_assoc();
	$title = "Edit Account: " . $result['first_name'] . " " . $result['last_name'];
}

$error = "";
$staffTypes = array('S' => 'Regular Staff', 'M' => 'Manager', 'A' => 'Administrator');
$genderOptions = array('M' => 'Male', 'F' => 'Female');

include('../../include/wrapperstart.php');

if(isset($_POST['edit']))
{
	$userid = $_POST['edit'];
	$useridQuery = $mysqli->escape_string($userid);
	$result = $mysqli->query("SELECT * FROM User, Role, UserInfo, Address WHERE User.role_id > 1 AND User.role_id = Role.id AND User.id = UserInfo.user_id AND User.id = '$userid' AND userinfo_id = '$userid';")->fetch_assoc();
	$values['email'] = $result['email_address'];
	$values['firstName'] = $result['first_name'];
	$values['lastName'] = $result['last_name'];
	
	$dobStr = DateTime::createFromFormat('Y-m-d', $result['dob']);
	$dobStr = $dobStr->format('d/m/Y');
	
	$values['dob'] = $dobStr;
	$values['gender'] = $genderOptions[$result['gender']];
	$values['addr1'] = $result['first_line'];
	$values['addr2'] = $result['second_line'];
	$values['city'] = $result['city'];
	$values['postcode'] = $result['postcode'];
	$values['country'] = $result['country'];
	$values['accountType'] = $staffTypes[$result['role_name']];
}
else if(isset($_POST['submit']))
{
	$requiredFields = array('email' => 'email address', 'password1' => 'password', 'password2' => 'confirm password', 'firstName' => 'first name', 'lastName' => 'last name', 
							'dob' => 'date of birth', 'gender', 'addr1' => 'address line 1', 'city', 'postcode', 'country', 'accountType' => 'account type');
	
	$edit = false;
	if($_POST['submit'] == "Save Changes")
	{
		$edit = true;
		unset($requiredFields['password1']);
		unset($requiredFields['password2']);
	}
	
	foreach($requiredFields as $key => $required)
	{
		if(is_int($key)) $key = $required;
		
		if(!isset($_POST[$key]))
		{
			if($error = "")
			{
				$error = "Please fill in the $required field for this user.";
			}
		}
		else
		{
			$values[$key] = $_POST[$key];
		}
	}
	
	if(isset($_POST['addr2'])) $values['addr2'] = $_POST['addr2'];
	
	$now = new DateTime;
	$dob = DateTime::createFromFormat('d/m/Y', $_POST['dob']);
	$years = $dob->diff($now)->y;
	
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
	{
		$error = "Please enter a valid email address.";
	}
	else if($edit == false && strlen($_POST['password1']) < 6)
	{
		$error = "The password should be at least 6 characters long.";
	}
	else if($edit == false && $_POST['password1'] != $_POST['password2'])
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
			$userid = null;
			if($edit == true)
			{
				$userid = $_POST['edit'];
				$emailQuery = $mysqli->escape_string($_POST['email']);
				$result = $mysqli->query("SELECT id, password FROM User WHERE email_address = '$emailQuery';")->fetch_assoc();
				$userid = $result['id'];
				$_POST['password1'] = $result['password'];
				
				$user->delete($userid);
			}
			
			$user->register($_POST['email'], $_POST['password1'], $_POST['firstName'], $_POST['lastName'], $dob, $gender, $_POST['addr1'], $addr2, $_POST['city'], $_POST['postcode'], $_POST['country'], $role, $userid);
			
			if($edit == true)
			{
				?>
				<script>
				alert("Your changes have been saved.");
				</script>
				<?php
			}
			else
			{
				?>
				<script>
				alert("An account has been created for <?php echo $_POST['email']; ?>.");
				</script>
				<?php
			}
			
			$values = array_fill_keys(array_keys($values), "");
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
	<p style="padding-bottom:10px;"><?php echo $message; ?></p>
	<?php echo $error; ?>
	<div class="form-group">
		<label class="col-lg-2 control-label">Email Address</label>
			<div class="col-lg-5">
			<input type="text" name ="email" class="form-control" placeholder="name@example.com" value="<?php echo $values['email']; ?>"required>
		</div>
	</div>
	
	<?php
	$attribute = "required";
	if(isset($_POST['edit'])) $attribute = "disabled";
	?>
	
	<div class="form-group">
		<label class="col-lg-2 control-label">Password</label>
		<div class="col-lg-5" style="width: 200px;">
			<input type="password" name="password1" class="form-control" <?php echo $attribute; ?>>
		</div>
		<label class="col-lg-2 control-label inline" style="width:110px">Confirm Password</label>
		<div class="col-lg-5" style="width: 200px;">
			<input type="password" name ="password2" class="form-control" <?php echo $attribute; ?>>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-lg-2 control-label">First Name</label>
		<div class="col-lg-5" style="width: 200px;">
			<input type="text" name="firstName" class="form-control" value="<?php echo $values['firstName']; ?>" required>
		</div>
		<label class="col-lg-2 control-label inline">Last Name</label>
		<div class="col-lg-5" style="width: 200px;">
			<input type="text" name ="lastName" class="form-control" value="<?php echo $values['lastName']; ?>" required>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-lg-2 control-label">Date of Birth</label>
		<div class="col-lg-5" style="width: 200px;">
			<input style="width:100px;" name="dob" id="dob" type="text" class="form-control" placeholder="mm/dd/yyyy" value="<?php echo $values['dob']; ?>" required>
		</div>
		<label class="col-lg-2 control-label inline">Gender</label>
		<div class="col-lg-2">
			<select class="form-control" name ="gender" style="width: 120px;">
				<?php
				foreach($genderOptions as $gender)
				{
					$selected = "";
					if($values['gender'] == $gender)
					{
						$selected = " selected";
					}
					
					echo "<option$selected>$gender</option>";
				}
				?>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-lg-2 control-label">Address Line 1</label>
			<div class="col-lg-5">
			<input type="text" name="addr1" class="form-control" placeholder="1 Example Road" value="<?php echo $values['addr1']; ?>" required>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-lg-2 control-label">Address Line 2*</label>
			<div class="col-lg-5">
			<input type="text" name="addr2" class="form-control" placeholder="Optional" value="<?php echo $values['addr2']; ?>">
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-lg-2 control-label">Town / City</label>
			<div class="col-lg-5">
			<input style="width:250px;" name="city" type="text" class="form-control" placeholder="" value="<?php echo $values['city']; ?>" required>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-lg-2 control-label">Postcode</label>
			<div class="col-lg-5">
			<input style="width:250px;" name="postcode" id="postcode"type="text" class="form-control" placeholder="" value="<?php echo $values['postcode']; ?>" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-lg-2 control-label">Country</label>
			<div class="col-lg-5">
			<input style="width:250px;" name ="country" id="postcode"type="text" class="form-control" placeholder="" value="<?php echo $values['country']; ?>" required>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-lg-2 control-label">Account Type</label>
		<div class="col-lg-2">
			<select class="form-control" name="accountType">
				<?php
				foreach($staffTypes as $type)
				{
					$selected = "";
					if($values['accountType'] == $type) $selected = " selected";
					echo "<option$selected>$type</option>";
				}
				?>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-6">
			<input name ="submit" type="submit" class="btn btn-sm btn-default" value="<?php echo $action; ?>">
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
