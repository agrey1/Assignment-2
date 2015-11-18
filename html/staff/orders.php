<?php
$title = "Customer Orders";
include('../../include/wrapperstart.php');
$result = $mysqli->query("SELECT * FROM `Order`;");
?>

<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th>Order ID</th>
				<th>Items</th>
				<th>Date Placed</th>
				<th>Date Dispatched</th>
				<th>Status</th>
				<th>Delete</th>
				<th>Edit</th>
			</tr>
		</thead>
		<tbody>
			<?php
			while($row = $result->fetch_assoc())
			{
				$datePlaced = DateTime::createFromFormat('Y-m-d H:i:s', $row['date_placed']);
				$datePlaced = $datePlaced->format('d/m/Y H:i:s');
				
				$dateDispatched = DateTime::createFromFormat('Y-m-d H:i:s', $row['date_dispatched']);
				if($dateDispatched != false)
				{
					$dateDispatched = $dateDispatched->format('d/m/Y H:i:s');
				}
				else
				{
					$dateDispatched = "Not Dispatched";
				}
				
				$orderID = $row['id'];
				$shoeResult = $mysqli->query("SELECT shoe_id FROM Order_shoe WHERE order_id = '$orderID';");
				
				$items = "";
				while($shoeID = $shoeResult->fetch_assoc()['shoe_id'])
				{
					$shoeName = $mysqli->query("SELECT shoe_name FROM Shoe WHERE id = '$shoeID';")->fetch_row()[0];
					$items .= $shoeName . ", ";
				}
				
				$items = substr($items, 0, strlen($items) - 2);
				
				?>
				
				<tr>
					<td><?php echo $row['id']; ?></td>
					<td><?php echo $items; ?></td>
					<td><?php echo $datePlaced; ?></td>
					<td><?php echo $dateDispatched; ?></td>
					<td><?php echo $row['status']; ?></td>
					<td>
						<a href="Delete_order.php?id=<?php echo $row["id"]; ?>">Delete</a><br>
					</td>
					<td>
						<a href="editOrder.php?id=<?php echo $row["id"]; ?>">Edit</a><br>
					</td>
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