<?php
$title = "Products";

include('../../include/wrapperstart.php');
?>

<p>






 <form action="Add_item.php" method="post" enctype="multipart/form-data">
    <table>
	<tr><td><strong>name:</strong><br><br></td><td><input name="shoe_name" type="text"><br><br></td></tr>
	<tr><td><strong>size:</strong><br><br></td><td><input name="size" type="text"><br><br></td></tr>
	<tr><td><strong>color:</strong><br><br></td><td><input name="color" type="text"><br><br></td></tr>
	<tr><td><strong>price:</strong><br><br></td><td><input name="price" type="text"><br><br></td></tr>
	<tr><td><strong>supplier:</strong><br><br></td><td>
	
	
	<select name="supplier_id" type="text">
	<?php
	   $sql1 = "SELECT id FROM `Supplier`";
       $result = $mysqli->query($sql1);
	while (($row = $result->fetch_assoc())) {
            $supplier=$row["id"];
                echo "<option>
                    $supplier
                </option>";
	}
	?>
	</select><br><br></td></tr>
    <tr><td colspan="2" align="right"><input type="file" name="file" id="file" /><br><br></td></tr>
    <tr><td colspan="2" align="center"><input type="submit" value="Upload">&nbsp;<input type="reset" value="Clear"><br><br></td></tr>
    </table>
    </form>

</p>

<?php
include('../../include/wrapperend.php');
?>