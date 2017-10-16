
	
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

<title>Delete Category</title>
<meta http-equiv="content-type"
	content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="/css/styles.css" type="text/css" />
</head>

<body>
<H1>Delete Category</h1>

<?php

 $category_id=$_POST['category_id'];
 
	
    $DBConnect = mysql_connect("localhost", "root", "") or die ("unable to connect".mysql_error());
    
    mysql_select_db($DBName);
	
	//Double check to make sure there are no items within this category
	$ItemTable = "items";
	
	$QueryString = "SELECT * FROM $ItemTable WHERE Category='$category_id'";
	$CategoryCheck = mysql_query($QueryString) or die ("No Query".mysql_errno($DBConnect));   
	$num_rows = mysql_num_rows($CategoryCheck);
   
	
	
	
	//Gather the information for the category being deleted
	
	$TableName = "genres";
	$QueryString = "SELECT * FROM $TableName WHERE category_id='$category_id'";
	$QueryResult = mysql_query($QueryString) or die ("No Query".mysql_connect_errno());
 
 while ($Row = mysql_fetch_assoc($QueryResult))
	$category = stripslashes($Row["category"]);
	
	if($num_rows <= 0)	
	{
		$query = sprintf("DELETE FROM $TableName WHERE category_id = ('%s')",
					mysql_real_escape_string($category_id));
							
		$result = mysql_query($query);
		
		echo "The category " . $category . " has been deleted.";
	}
	else {
		echo "The category " . $category . " could not be deleted. Some new data must have been entered somewhere in between your request and now.";
	}
	
	
	?><br /> <a href="index.php">Return To Main</a>
	<?php
					
					
	?><br /> <a href="view_categories.php">View Categories List</a>
	<?php
			
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