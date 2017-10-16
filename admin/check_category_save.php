
	
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

<title>Check Category Save</title>
<meta http-equiv="content-type"
	content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="/css/styles.css" type="text/css" />
</head>

<body>
<H1>Check Category Save</h1>

<?php

	$category_id=stripslashes($_POST['category_id']);
	$category=stripslashes($_POST['category']);

    $DBConnect = mysql_connect("localhost", "root", "") or die ("unable to connect".mysql_error());
    
    mysql_select_db($DBName);

    $TableName = "genres";
	
	
				$Duplicates = 0;
			
			$QueryString = sprintf("SELECT * FROM $TableName WHERE category='%s'",
									mysql_real_escape_string($category));
									
			
			$DuplicateCheck = mysql_query($QueryString);	
				
			$num_rows = mysql_num_rows($DuplicateCheck);
							
				
				
		if ($num_rows > 0) 
				{
					$Duplicates = 1;
												
					?>  
					<FONT color=red><h2>Genre already exists, Please try again.</h2></font>
					<FORM action="check_category_save.php" method="POST">
					<input type="hidden" name="category_id" value="<?php echo "$category_id"; ?>" /> <br />
					New Category Name: <input type="text" name="category" value="<?php echo "$category"; ?>" />
					<?php if ($category=="") echo "<font color=red> *required</font>"; ?>
					<br><br>
					<input type="submit" name="submit" value="Save" />
					</FORM>

	<?php
				}
		else	
				{
					$QueryString = sprintf("UPDATE $TableName SET category='%s' WHERE category_id='%s'",
									mysql_real_escape_string($category),
									mysql_real_escape_string($category_id));
					
					$QueryResult = mysql_query($QueryString) or die ("No Query".mysql_connect_errno());
    
					echo "<h2>Entry Changed</h2>";
					?> <a href="index.php">Return To Main</a>
					<?php
					
					
					?><br /> <a href="view_categories.php">View List</a>
					<?php
				}
				
					mysql_close($DBConnect);
				

?>
  
</table>
</body>

</html>

<?php	//If the session and user IDs do not match, redirect back to the login page
	}
	else {
	mysql_close($DBConnect);
	header("location: ../index.html");
	}
	?>