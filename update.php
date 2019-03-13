<?php
	// zhiyu
	if(isset($_POST["btnUpdate"])){
		$con=mysql_connect("localhost","zhiyu","password000");
		
		if(!$con)
		{
			die('Cannot connect to database:'.mysql_error());
		}
		
		mysql_select_db("33_zhiyu_pessdb",$con);
		
	$sql="UPDATE patrolcar SET patrolcarStatusId='".$_POST["patrolCarStatus"]."' 
	WHERE patrolCarId='".$_POST["patrolcarId"]."'";
		
		if(!mysql_query($sql,$con))
		{
			die('Error4:'.mysql_error());
		}
		
		if($_POST["patrolCarStatus"]=='4'){
		
	$sql = "UPDATE dispatch SET timeArrived=NOW() 
	WHERE timeArrived is NULL AND patrolCarId='".$_POST["patrolCarId"]."'";
		
		if(!mysql_query($sql,$con))
		{
			die('Error4:'.mysql_error());
		}
		
		} elseif($_POST["patrolCarStatus"]=='3'){
		
	$sql="SELECT incidentid FROM dispatch WHERE timeCompleted IS NULL AND patrolcarId='".$_POST["patrolcarId"]."'";

	$result = mysql_query($sql,$con);
		
	$incidentId;
		
		while($row = mysql_fetch_array($result))
		{
			$incidentId = $row['incidentId'];
		}
		
	$sql = "UPDATE dispatch SET timeCompleted=NOW() 
	WHERE timeCompleted is NULL AND patrolcarId='".$_POST["patrolcarId"]."'";
		
		if(!mysql_query($sql,$con))
		{
			die('Error4:'.mysql_error());
		}
		
	$sql="UPDATE incident SET incidentStatusId='3' 
	WHERE incidentId NOT IN (SELECT incidentId FROM dispatch WHERE timeCompleted IS NULL)";
	
		if(!mysql_query($sql,$con))
		{
			die('Error5:'.mysql_error());
		}
	}
	
	mysql_close($con);
	
	?>
	
	<script type="text/javascript">window.location="./LogCall.php";</script>
	<?php } ?>	

<!DOCTYPE html>
<html>
<title>Update Patrol Cars</title>
<head><?php include 'NavigationBar.php'; ?></head>
<body>
<?php
	if(!isset($_POST["btnSearch"])){
		$con=mysql_connect("localhost","zhiyu","password000");
		
		if(!$con)
		{
			die('Cannot connect to database:'.mysql_error());
		}
		
		mysql_select_db("33_zhiyu_pessdb",$con);
		$result = mysql_query('SELECT * FROM patrolcar');
		
		$carPlate;
		while($row=mysql_fetch_array($result))
			$carPlate[$row['patrolcarId']] = $row['patrolcarId'];
		mysql_close($con);		
?>
<fieldset>
<legend>Dispatch Patrol Cars</legend>
	<form name="form1" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
	<table width="80%" border="0" align="center" cellpadding="4" cellspacing="4">
<tr>
	<td width="25%" class="td_label">Patrol Car ID:</td>
	<td width="25%" class="td_Data"><input type="text" name="patrolcarId" id="patrolcarId"></td>
	<td class="td_Data"><input type="submit" name="btnSearch" id="btnSearch" value="Search"></td>
</tr>

</table>

</form>

<?php
	} else{
		$con = mysql_connect("localhost","zhiyu","password000");
			if(!$con)
			{
				die('Cannot connect to database:'.mysql_error());
			}
		mysql_select_db("33_zhiyu_pessdb",$con);
		$sql = "SELECT * FROM patrolcar WHERE patrolcarId='".$_POST['patrolcarId']."'";

		$result = mysql_query($sql,$con);
		$patrolcarId;
		$patrolcarStatusId;
			while($row = mysql_fetch_array($result))
			{
				$patrolCarId = $row['patrolcarId'];
				$patrolcarStatusId = $row['patrolcarStatusId'];
			}
		$sql = "SELECT * FROM patrolcar_status";
		$result = mysql_query($sql,$con);
		$patrolCarStatusMaster;
			while($row = mysql_fetch_array($result))
			{
				$patrolCarStatusMaster[$row['statusid']] = $row['statusDesc'];
			}
	mysql_close($con);
?>

	<form name="form2" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
	
	<table width="80%" border="0" align="center" cellpadding="4" cellspacing="4">
	
<tr>
	<td width="25%" class="td_label">ID :</td>
	<td width="25%" class="td_Data"><?php echo $_POST["patrolcarId"]?>
	<input type="hidden" name="patrolcarId" id="patrolcarId" value="<?php echo $_POST["patrolcarId"]?>">
	</td>
</tr>
<tr>
	<td class="td_label">Status :</td>
	<td class="td_Data"><select name="patrolCarStatus" id="$patrolCarStatus">
	
	<?php foreach($patrolCarStatusMaster as $key => $value){?>
	
	<option value="<?php echo $key ?>"
	<?php if($key==$patrolcarStatusId) {?>selected="selected"
	<?php }?>>
	<?php echo $value ?>
	</option>
	
	<?php } ?>
	
	</select></td>
	</tr>
	
	</table>
	
	<br/>
	
	<table width="80%" border="0" align="center" cellpadding="4" cellspacing="4">
	
<tr>
	<td width="46%" class="td_label"><input type="reset" name="btnCancel" id="btnCancel" value="Reset"></td>
	<td width="54%" class="td_Data">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="btnUpdate" id="btnUpdate" value="Update">
	</td>
</tr>
</table>
</form>
	<?php } ?>
</fieldset>
</body>
</html>