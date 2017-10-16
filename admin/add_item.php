
	
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

<title>Add An Item</title>
<meta http-equiv="content-type"
	content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="/css/styles.css" type="text/css" />
</head>
<body>

<h2>Enter Album Details Below</h2>



   <?php
   
	
		
			include($_SERVER["DOCUMENT_ROOT"] . '/db/dbinfo.php');
	mysql_select_db($DBName);
   
    $result = mysql_query("select category_id, category from inventory.genres");

	

 ?>
	
	



   <FORM action="check_item_add.php" method="POST" enctype="multipart/form-data">
 	
		Category: <select name="catdropdown">
    <option value = "">Select a genre:</option>
<?php

    while ($row = mysql_fetch_assoc($result)) {
			$category_id = stripslashes($row['category_id']);
			$category = stripslashes($row['category']);
			echo "<option value=\"$category_id\">$category\n";
			}
	 echo "</select>\n";
	 echo "</p>\n";
	 
	 
	 
?>	

<fieldset style="text-align:right; width:250px;">
<legend><b>Item Details</b></legend>

      Title: 		<input type="text" name="title" value="" /><br />
	  Description : 	<input type="text" name="description" value="" /><br />
	  Price: 		<input type="text" name="price" value="" /><br />
	  Quantity:		<input type="text" name="quantity" value="" /><br />
	  SKU  : 			<input type="text" name="sku" value="" /><br />
	  Please choose an image: <input name="uploaded" type="file" id="upload"/><br />
	  	  
	  

    

</fieldset>	  
      <input type="submit" name="submit" value="Save" />
</form>

<br />
<a href="index.php">Return To Main</a>   

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