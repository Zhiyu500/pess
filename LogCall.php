<!DOCTYPE html>
<html>
<head>
<title>Log Call</title>
<script>
	function validateForm()
	{
		var x = document.forms["myForm"]["callerName"].value;
		if (x == "")
		{
			alert("Name must be filled out");
			return false;
		}
	}
</script>
<?php
	if(isset($_POST['btnSubmit']))
	{
		$con=mysql_connect("localhost","zhiyu","password000");
		if(!$con)
			die('Cannot connect to database:'.mysql_error());
		mysql_select_db("33_zhiyu_pessdb",$con);
		
		$sql="INSERT INTO incident(callerName, phoneNumber, incidentTypeId, incidentLocation, incidentDesc, incidentStatusId) 
		VALUES('$_POST[callerName]','$_POST[contactNo]','$_POST[incidenttype]','$_POST[location]'),'$_POST[incidentDesc]','1')";
		
		//echo $sql;
		
		if(!mysql_query($sql,$con))
			die ("Error:" .mysql_error());
		mysql_close($con);
	}
	$con=mysql_connect("localhost","zhiyu","password000");
	if(!$con)
	{
		die('Cannot connect to database:'.mysql_error());
	}
	mysql_select_db("33_zhiyu_pessdb",$con);
	
	$result=mysql_query("SELECT * FROM incidenttype");
	
	$incidenttype;
	
	while($row=mysql_fetch_array($result))
	{
		$incidenttype[$row['incidentTypeDesc']] = $row['incidentTypeDesc'];
	}
	mysql_close($con);
?>
<?php include 'NavigationBar.php'; ?>
</head>
<body>
<?php
	$con=mysql_connect("localhost","zhiyu","password000");
	if(!$con)
	{
	die('Cannot connect to database:'.mysql_error());
	}
	
	mysql_select_db("33_zhiyu_pessdb",$con);
	
	$result=mysql_query("SELECT * FROM incidenttype");
	
	$incidenttype;
	
	while($row=mysql_fetch_array($result))
	{
	//incidentid, incidentTypeDesc
	
	$incidenttype[$row['incidentTypeDesc']] = $row['incidentTypeDesc'];
	}
	
	mysql_close($con);
?>
<fieldset>
<legend>Log Call</legend>
<form name="frmLogCall" method="post" action="dispatch.php">
<table>
	<tr>
		<td>Caller's Name: </td>
		<td><p><input type="text" name="callerName" /></p></td>
	</tr>
	<tr>
		<td>Contact No: </td>
		<td><p><input type="text" name="contactNo" /></p></td>
	</tr>
	<tr>
		<td>Location: </td>
		<td><p><input type="text" name="location" /></p></td>
	</tr>
	<tr>
		<td align="right" class="td_label">Incident Type: </td>
		<td class="td_Date">
			<p>
			<select name="incidenttype" id="incidenttype">
				<?php foreach ($incidenttype as $key => $value){ ?>
					<option value="<?php echo $key ?>"><?php echo $value ?></option>
				<?php } ?>
			</select>
			</p>
		</td>
	</tr>
	<tr>
		<td>Description: </td>
		<td><p><textarea name="description" rows="5" cols="50"></textarea></p></td>
	</tr>
</table>
	<input type="Reset">
	<input type="Submit" value="Process Call">
</fieldset>
</form>
</body>
</html>