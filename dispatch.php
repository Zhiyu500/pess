<?php
	// zhiyu
	if(isset($_POST["btnSubmit"]))
	{
		// connect to database
		$con = mysql_connect("localhost","zhiyu","password000");
		
	if(!$con)
	{
		die('Cannot connect to database:'.mysql_error());
	}
	
	mysql_select_db("33_zhiyu_pessdb",$con);
	
	// update patrolcar status table and dispatch table
	$patrolcarDispatched = $_POST["chkPatrolcar"];
	
	$c = count($patrolcarDispatched);
	
	// insert new incident
	$status;
	if($c > 0)
	{
		$status='2';
	}
	else
	{
		$status='1';
	}
	
	$sql = "INSERT INTO incident(callerName, phoneNumber, incidentTypeld, incidentLocation, incidentDesc, incidentStatusld) 
	VALUES('".$_POST['callerName']."','".$_POST['contactNo']."','".$_POST['incidenttype']."','".$_POST['location']."','".$_POST['description']."','$status')";
	
	if(!mysql_query($sql,$con))
	{
		die('Error1:'.mysql_error());
	}
	// retrieve new incremental key for incidentId
	$incidentId=mysql_insert_id($con);;
	
	for($i=0; $i<$c; $i++)
	{
		$sql = "UPDATE patrolcar SET patrolcarStatusId='1' 
		WHERE patrolcarId='$patrolcarDispatched[$i]'";

			if(!mysql_query($sql,$con))
			{
				die('Error2:'.mysql_error());
			}
			
		$sql = "INSERT INTO dispatch(incidentid, patrolcarld, timeDispatched) 
		VALUES('$incidentId','$patrolcarDispatched[$i]',NOW())";
	
			if(!mysql_query($sql,$con))
			{
				die('Error3:'.mysql_error());
			}
	}
	
	mysql_close($con);
	}
	?>

<!DOCTYPE html>
<html>
<title>Dispatch Patrol Cars</title>
<head><?php include 'NavigationBar.php'; ?></head>
<body>
<?php
$con=mysql_connect("localhost","zhiyu","password000");
	if(!$con)
	{
		die('Cannot connect to database:'.mysql_error());
	}
	
	mysql_select_db("33_zhiyu_pessdb",$con);
	
	$sql = "SELECT patrolcarId, statusDesc FROM patrolcar JOIN patrolcar_status 
	ON patrolcar.patrolcarstatusId=patrolcar_status.statusid 
	WHERE patrolcar.patrolcarstatusId='2' OR patrolcar.patrolcarstatusId='3'";
	
	$result = mysql_query($sql, $con);
	
	$incidentArray;
	$count=0;
	
	while($row = mysql_fetch_array($result))
	{
		$patrolcarArray[$count]=$row;
		$count++;
	}
	
	if(!mysql_query($sql, $con))
	{
		die('Error: '.mysql_error());
	}
	
	mysql_close($con);
	
?>
<fieldset>
<legend>Dispatch Patrol Cars</legend>
<form name="frmLogCall" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
<table width="40%" align="center" cellpadding="4" cellspacing="8">
	<tr>
		<td>Caller's Name: </td>
		<td>
			<?php echo $_POST["callerName"]; ?>
			<input type="hidden" name="callerName" value="<?php echo $_POST["callerName"]; ?>" />
		</td>
	</tr>
	<tr>
		<td>Contact No: </td>
		<td>
			<?php echo $_POST["contactNo"]; ?>
			<input type="hidden" name="contactNo" value="<?php echo $_POST["contactNo"]; ?>" />
		</td>
	</tr>
	<tr>
		<td>Location: </td>
		<td>
			<?php echo $_POST["location"]; ?>
			<input type="hidden" name="location" value="<?php echo $_POST["location"]; ?>" />
		</td>
	</tr>
	<tr>
		<td>Incident Type: </td>
		<td>
			<?php echo $_POST["incidenttype"]; ?>
			<input type="hidden" name="incidenttype" value="<?php echo $_POST["incidenttype"]; ?>" />
		</td>
	</tr>
	<tr>
		<td>Description: </td>
		<td>
			<?php echo $_POST["description"]; ?>
			<input type="hidden" name="description" value="<?php echo $_POST["description"]; ?>" />
		</td>
	</tr>
</table>
<table width="40%" border="1" align="center" cellpadding="4" cellspacing="8">
	<tr>
		<td width="20%">&nbsp;</td>
		<td width="51%">Patrol Car ID</td>
		<td width="29%">Status</td>
	</tr>
<?php
$i=0;
	while($i < $count){
	?>
<tr>
	<td class="td_label">
	<input type="checkbox" name="chkPatrolcar[]" value="<?php echo $patrolcarArray[$i]['patrolcarId']?>">
	</td>
	<td><?php echo $patrolcarArray[$i]['patrolcarId']?></td>
	<td><?php echo $patrolcarArray[$i]['statusDesc']?></td>
</tr>
<?php $i++;
	} ?>
</table>

<table width="80%" border="0" align="center" cellpadding="4" cellspacing="4">
<td width="46%" class="td_label">
<input type="reset" name="btnCancel" id="btnCancel" value="Reset">
</td>
<td width="54%" class="td_Data">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="btnSubmit" id="btnSubmit" value="Submit">
</td>
</fieldset>
</table>
</form>
</body>
</html>