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
	<div class="form-group">
		<label class="col-lg-2 control-label">Email Address</label>
			<div class="col-lg-5">
			<input type="text" class="form-control" placeholder="name@example.com" required>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-lg-2 control-label">Password</label>
		<div class="col-lg-5">
			<input type="password" class="form-control" required>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-lg-2 control-label">First Name</label>
		<div class="col-lg-5" style="width: 200px;">
			<input type="text" class="form-control" required>
		</div>
		<label class="col-lg-2 control-label inline">Last Name</label>
		<div class="col-lg-5" style="width: 200px;">
			<input type="text" class="form-control" required>
		</div>
	</div>

	<div class="form-group">
		<label class="col-lg-2 control-label">Date of Birth</label>
		<div class="col-lg-5" style="width: 200px;">
			<input style="width:100px;" id="dob" type="text" class="form-control" placeholder="mm/dd/yyyy" required>
		</div>
		<label class="col-lg-2 control-label inline">Gender</label>
		<div class="col-lg-2">
			<select class="form-control" style="width: 120px;">
				<option>Male</option>
				<option>Female</option>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-lg-2 control-label">Address Line 1</label>
			<div class="col-lg-5">
			<input type="text" class="form-control" placeholder="1 Example Road" required>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-lg-2 control-label">Address Line 2*</label>
			<div class="col-lg-5">
			<input type="text" class="form-control" placeholder="Optional">
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-lg-2 control-label">Town / City</label>
			<div class="col-lg-5">
			<input style="width:250px;" type="text" class="form-control" placeholder="" required>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-lg-2 control-label">Postcode</label>
			<div class="col-lg-5">
			<input style="width:250px;" id="postcode"type="text" class="form-control" placeholder="" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-lg-2 control-label">Country</label>
			<div class="col-lg-5">
			<input style="width:250px;" id="postcode"type="text" class="form-control" placeholder="" required>
		</div>
	</div>

	<div class="form-group">
		<label class="col-lg-2 control-label">Account Type</label>
		<div class="col-lg-2">
			<select class="form-control">
				<option>Regular Staff</option>
				<option>Manager</option>
				<option>Administrator</option>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-6">
			<input type="submit" class="btn btn-sm btn-default" value="Create Account"></button>
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