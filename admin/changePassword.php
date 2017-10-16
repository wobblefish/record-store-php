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

<title>Change Password</title>
<meta http-equiv="content-type"
	content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="/css/styles.css" type="text/css" />
</head>
	<body>
	
	<?php
		
		//---Get the username to be displayed on the password screen
		//----Connect To The database
	
		
		include($_SERVER["DOCUMENT_ROOT"] . '/db/dbinfo.php');
	
		$TableName = "admin_info";
		
		mysql_select_db($DBName);
				
		//SELECT query to find match for the old password
		$QueryString = sprintf("SELECT * FROM $TableName WHERE admin_id='%s'",
									mysql_real_escape_string($user_id));
									
					
		$QueryResult = mysql_query($QueryString) or die (mysql_error());
		
		while ($row = mysql_fetch_assoc($QueryResult)) {
				$username = stripslashes($row["username"]);
			}
		
		mysql_close($DBConnect);				
?>


		<H1>Inventory Management System:</H1>
		   
		   <h3>Change Your Password Below</h3>
		   <fieldset style="text-align:right; width:300px;">
		   <legend>Username: <?php echo "<strong><font color=\"#58ACFA\" weight=\"bold\">" . $username . "</font></strong>"; ?></legend>
		<FORM action="checkPassword.php" method="POST"><br />
			  Old Password: <input type="password" name="password" value="" /><br /><br />
			  New Password: <input type="password" name="newpass1" value="" /><br /><br />
			  Verify New Password <input type="password" name="newpass2" value="" /><br /><br />
			  <input type="submit" name="submit" value="Update" /><br />
		   </FORM>
		</fieldset>

<?php mysql_close($DBConnect); ?>
		
	</body>
</html>

<?php	//If the session and user IDs do not match, redirect back to the login page
	}
	else {
	mysql_close($DBConnect);
	header("location: ../index.html");
	}
	?>