<?php
//Check access rights for this page.
session_start();
if($_SESSION['role'] < 4)
{
	//Send the user back to the main page
	header("Location: /staff");
	die();
}

$title = "Manage Staff";

include('../../include/wrapperstart.php');

$name = "";
if(isset($_POST['name']))
{
	$name = $_POST['name'];
}

if(isset($_POST['edit']))
{
	
}
else if(isset($_POST['delete']))
{
	$user->delete($_POST['delete']);
}

$result = $mysqli->query("SELECT User.id, email_address, first_name, last_name, role_name, date_registered FROM User, Role, UserInfo WHERE (first_name LIKE '%$name%' OR last_name LIKE '%$name%') AND User.role_id > 1 AND User.role_id = Role.id AND User.id = UserInfo.user_id ORDER BY date_registered DESC;");

?>

<form method="POST" class="form-horizontal" role="form">
	<p style="padding-bottom:10px;">Filter by name <i>(The first and last name will be searched)</i>:</p>
	<div class="form-group">
		<label class="col-lg-2" style="width:37px; padding:0px; padding-left:10px; padding-top:6px;">Name</label>
		<div class="col-lg-5">
			<input type="text" name ="name" class="form-control" style="width: 150px;">
			<input name ="filterSubmit" type="submit" class="btn btn-sm btn-default" style="margin-top:5px; width:75px;" value="Filter">
		</div>
		
	</div>
</form>

<div class="widget-content" style="display: block;">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Staff ID</th>
					<th>Email Address</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Role</th>
					<th>Date Registered</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
				while($row = $result->fetch_assoc())
				{
					$dateRegistered = DateTime::createFromFormat('Y-m-d', $row['date_registered']);
					$dateRegistered = $dateRegistered->format('d/m/Y');
					
					$roles = array('C' => 'Customer', 'S' => 'Regular Staff', 'M' => 'Manager', 'A' => 'Admin');
					$roleName = $roles[$row['role_name']];
					
					?>
					
					<tr>
						<td><?php echo $row['id']; ?></td>
						<td><?php echo $row['email_address']; ?></td>
						<td><?php echo $row['first_name']; ?></td>
						<td><?php echo $row['last_name']; ?></td>
						<td><?php echo $roleName; ?></td>
						<td><?php echo $dateRegistered; ?></td>
						<td>
							<form method="POST" style="display:inline-block;">
								<input type="hidden" name="edit" value="<?php echo $row['id']; ?>">
								<a href="javascript:{}" onclick="$(this).parents('form:first').submit();">Edit</a>
							</form>
								| 
							<form method="POST" style="display:inline-block;">
								<input type="hidden" name="delete" value="<?php echo $row['id']; ?>">
								<a href="javascript:{}" onclick="$(this).parents('form:first').submit();">Delete</a>
							</form>
						</td>
					</tr>
					
					<?php
				}
				?>
				
			</tbody>
		</table>
	</div>
	
	<div class="widget-foot">
		<ul class="pagination pagination-sm pull-right">
			<li><a href="#">Prev</a></li>
			<li><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>
			<li><a href="#">Next</a></li>
		</ul>
		
		<div class="clearfix"></div>
	</div>
</div>

<?php
include('../../include/wrapperend.php');
?>