
	
<?php
	
	//Get Session ID & Get User ID Procedures
		
		//Flags
		$session_pass = 0;
		$id_pass = 0;
	
		//
		session_start();

		$session_id = session_id();
			
		//Connect To The database
		
		
		include($_SERVER["DOCUMENT_ROOT"] . '/db/dbinfo.php');
	
		$TableName = "current_session";
		
		mysql_select_db($DBName);
		
		
		//See if the current browser session ID exists in the database
		$QueryString = sprintf("SELECT * FROM $TableName WHERE session_num='%s'",
									mysql_real_escape_string($session_id));
									
					
		$QueryResult = mysql_query($QueryString) or die (mysql_error());
		
		//If it does, pull down the user_id
		
			while ($row = mysql_fetch_assoc($QueryResult)) {
				$user_id = stripslashes($row["user_id"]);
			}
		
			$num_rows = mysql_num_rows($QueryResult);
			
		if ($num_rows > 0) $session_pass=1;
			
		//See if the correct user ID for this session exists
		
		$QueryString = sprintf("SELECT * FROM current_session WHERE session_num='%s' AND user_id='%s'",
									mysql_real_escape_string($session_id),
									mysql_real_escape_string($user_id));
									
		$QueryResult = mysql_query($QueryString) or die (mysql_error());
		
			$num_rows = mysql_num_rows($QueryResult);
			
		if ($num_rows > 0) $id_pass=1;
		
			
		
		if ($session_pass > 0 && $id_pass > 0)
		{
		?>
<!DOCTYPE html PUBLIC " - //W3C//DTD XHTML 1.0
Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<title>View Orders</title>
<meta http-equiv="content-type"
	content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="/css/styles.css" type="text/css" />
</head>

<body>
<H1>View Orders</h1>
<a href="index.php">Return To Main</a>
<!-- START OF ORDER LIST TABLE -->
<table border=1 id="orderList">


<?php
 $DBConnect = mysql_connect("localhost", "root", "") or die ("unable to connect".mysql_error());
 
 mysql_select_db($DBName);

 $TableName = "order_info";
 $QueryString = "SELECT * FROM $TableName ORDER BY order_id ASC";
 $QueryResult = mysql_query($QueryString) or die ("No Query".mysql_errno());
  
 $counter = 0;
 
 while ($Row = mysql_fetch_assoc($QueryResult))
 {
   $order_id = stripslashes($Row["order_id"]);
   $fname = stripslashes($Row["fname"]);
   $lname = stripslashes($Row["lname"]);
   $phone = stripslashes($Row["phone"]);
   $email = stripslashes($Row["email"]);
   if ($counter%6==0) echo "</tr><tr>";
   $counter++;
?>   
   
		<td>
   <FORM action="order_details.php" method="post">
   <input type="hidden" name="order_id" value="<?php echo "$order_id"; ?>" />
<?php   echo "#$order_id" . " - " . "$fname" . " " . "$lname <br />";
		echo "Phone: $phone <br /> Email: $email"; ?>
		<br />
   <input type="submit" name="submit" value="Details" />
   </FORM>
		</td>
   
<?php
   
   
	      
 }

 mysql_close($DBConnect);
?>
</table>
<a href="index.php">Return To Main</a>
</body>

</html>

<?php	//If the session and user IDs do not match, redirect back to the login page
	}
	else {
	mysql_close($DBConnect);
	header("location: ../index.html");
	}
	?>