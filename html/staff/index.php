<?php
$title = "Stock Levels";

include('../../include/wrapperstart.php');

$result = $mysqli->query("SELECT * FROM Shoe ORDER BY id;");
?>

<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th>Item ID</th>
				<th>Shoe Name</th>
				<th>Size</th>
				<th>Colour</th>
				<th>Quantity</th>
				<th>Price</th>
			</tr>
		</thead>
		<tbody>
			<?php
			while($row = $result->fetch_assoc())
			{
				?>
				
				<tr>
					<td><?php echo $row['id']; ?></td>
					<td><?php echo $row['shoe_name']; ?></td>
					<td><?php echo $row['size']; ?></td>
					<td><?php echo $row['color']; ?></td>
					<td><?php echo $row['quantity'] . ' Units'; ?></td>
					<td><?php echo '£' . $row['price']; ?></td>
				</tr>
				
				<?php
			}
			?>
			
		</tbody>
	</table>
</div>  

<?php
include('../../include/wrapperend.php');
?>