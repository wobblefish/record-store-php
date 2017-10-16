
	
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

<title>Check Category Add</title>
<meta http-equiv="content-type"
	content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="/css/styles.css" type="text/css" />
</head>
<body>

  
<?php

  //GET THE VALUES FROM THE PREVIOUS FORM
  //$category_id=$_POST['category_id'];
  $category=$_POST['category'];
  
    
  //DEFAULT AN ERROR FLAG TO 0
  $Blank = 0;
  
  //CHECK ALL VARIABLE WE NEED TO CHECK TO SEE IF THERE ARE ERRORS
  //IF THERE ARE, TRIP SENTINEL
  
  if ($category=="") $Blank=1;
  
  
  //IF THERE ARE ERRORS, RESHOW FORM WITH VALUES FILLED IN AND 
  //AN ERROR MESSAGE BESIDE THE FIELD
    if ($Blank>0) {
?>  
   <FONT color=red><h2>All Fields Are Required</h2></font>
   <FORM action="check_category_add.php" method="POST">
      <input type="hidden" name="category_id" value="<?php echo "$category_id"; ?>" /> <br />
      Name: <input type="text" name="category" value="<?php echo "$category"; ?>" />
<?php if ($category=="") echo "<font color=red> *required</font>"; ?>
      <br><br>
      <input type="submit" name="submit" value="Save" />
   </FORM>

<?php

  } else {

     //OTHERWISE UPDATE DATABASE. SHOW SUCCESS
    
	
	
			include($_SERVER["DOCUMENT_ROOT"] . '/db/dbinfo.php');
	
    
	$TableName = "genres";
	
			mysql_select_db($DBName);
			//$QueryResult = mysql_query($SQLString, $DBConnect = mysql_connect("localhost", "root", "") or die ("unable to connect".mysql_error()););
			
			$Duplicates = 0;
			
			$QueryString = sprintf("SELECT * FROM $TableName WHERE category='%s'",
									mysql_real_escape_string($category));
									
			
			$DuplicateCheck = mysql_query($QueryString);
			$num_rows = mysql_num_rows($DuplicateCheck);
							
				
				
		if ($num_rows > 0) {
					$Duplicates = 1;
					echo "<h1>Record already exists!</h1>";
				
							
					?>  
					<FONT color=red><h2>Genre already exists, Please try again.</h2></font>
					<FORM action="check_category_add.php" method="POST">
					<input type="hidden" name="category_id" value="<?php echo "$category_id"; ?>" /> <br />
					Name: <input type="text" name="category" value="<?php echo "$category"; ?>" />
					<?php if ($category=="") echo "<font color=red> *required</font>"; ?>
					<br><br>
					<input type="submit" name="submit" value="Save" />
					</FORM>

	<?php
				}
				else
				{
				$SQLString = sprintf("INSERT INTO $TableName(category)values('%s')",
							mysql_real_escape_string($category));	
				
				$QueryResult = mysql_query($SQLString) or die (mysql_error());
				echo "<h1>Genre was added to the list!</h1>";
				?> <a href="index.php">Return To Main</a>
					<?php
				}
	}

				mysql_close($DBConnect);
?>
</body>

</html>

<?php	//If the session and user IDs do not match, redirect back to the login page
	}
	else {
	mysql_close($DBConnect);
	header("location: ../index.html");
	}
	?>