<?php
$title = "Products";
include('../../include/wrapperstart.php');
  $id = $_GET['id'];
?>

<p>

<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
 <form action="Edit_order.php" method="post" enctype="multipart/form-data">
    <input name="id" type="hidden" value=<?php echo $id   ?> >
    <table>
	<tr><td><strong>Status:</strong><br><br></td><td><input name="status" type="text"><br><br></td></tr>
	<tr><td><strong>Date Placed:</strong>&nbsp;&nbsp;&nbsp;<br><br></td>
	<td>
	  <input name="placed" type="datetime" id="date0" size="30" maxlength="30" style="width: 130px;">
	 <br><br></td></tr>
	 <tr><td><strong>Date Dispatched:</strong>&nbsp;&nbsp;&nbsp;<br><br></td>
	<td>
	  <input name="dispatched" type="text" id="date1" size="30" maxlength="30" style="width: 130px;">
	 <br><br></td></tr>
	  
	  <tr><td colspan="2" align="center"><input type="submit" value="Upload">&nbsp;<input type="reset" value="Clear"><br><br></td></tr>
      </table>
	  
     </form>

</p>


<script type="text/javascript">
jQuery(function($){
	$("#date0").mask("9999-99-99 99:99:99", {placeholder: 'yyyy-mm-dd hh:mm:ss'});
	$("#date1").mask("9999-99-99 99:99:99", {placeholder: 'yyyy-mm-dd hh:mm:ss'});
});
</script>

<?php
include('../../include/wrapperend.php');
?>