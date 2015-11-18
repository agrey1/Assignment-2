<?php
$title = "Restock";
include('../../include/wrapperstart.php');

?>

<p>
 <form action="Re_stock.php" method="post" enctype="multipart/form-data">
    <table>
	<tr><td><strong>Product id:</strong><br><br></td><td>
	
	
	<select name="id" type="text">
	<?php
	
	$sql1 = "SELECT id FROM `Shoe`";
	$result = $mysqli->query($sql1);
	while (($row = $result->fetch_assoc())) 
	{
		$shoe_id=$row["id"];
			echo "<option>
				$shoe_id
			</option>";
	}
	
	?>
	</select><br><br></td></tr>
	<tr><td><strong>new Quantity:</strong><br><br></td><td><input name="quantity" type="text"><br><br></td></tr>
    <tr><td colspan="2" align="center"><input type="submit" value="Upload">&nbsp;<input type="reset" value="Clear"><br><br></td></tr>
    </table>
    </form>

</p>

<?php
include('../../include/wrapperend.php');
?>