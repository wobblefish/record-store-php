
	
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

<title>Edit Category</title>
<meta http-equiv="content-type"
	content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="/css/styles.css" type="text/css" />
</head>

<body>
<H1>Edit Category</h1>

<?php

 $category_id=$_POST['category_id'];
  
 $DBConnect = mysql_connect("localhost", "root", "") or die ("unable to connect".mysql_error());
 
 mysql_select_db($DBName);

 
 $TableName = "genres";
 $QueryString = sprintf("SELECT * FROM $TableName WHERE category_id='%s'",
				mysql_real_escape_string($category_id));

 $QueryResult = mysql_query($QueryString) or die ("No Query".mysql_connect_errno());
 
 while ($Row = mysql_fetch_assoc($QueryResult)) {
   $category_id = stripslashes($Row["category_id"]);
   $category = stripslashes($Row["category"]);

   echo "    <FORM action=\"check_category_save.php\" method=\"POST\">";
   echo "      <input type=\"hidden\" name=\"category_id\" value=\"$category_id\" />";
   echo "      <input type=\"text\" name=\"category\" value=\"$category\" />";
   echo "      <input type=\"submit\" name=\"submit\" value=\"Save\" />";
   echo "    </FORM>";
   
 }   

 mysql_close($DBConnect);
 
?>
<br />
<a href="index.php">Return To Main</a> 
  
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