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

<title>View Categories</title>
<meta http-equiv="content-type"
	content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="/css/styles.css" type="text/css" />
</head>

<body>
<H1>View Categories</h1>
<TABLE>
<?php
 $DBConnect = mysql_connect("localhost", "root", "") or die ("unable to connect".mysql_error());
 
 mysql_select_db($DBName);

 $TableName = "genres";
 $QueryString = "SELECT * FROM $TableName ORDER BY category_id ASC";
 $QueryResult = mysql_query($QueryString) or die ("No Query".mysql_errno());
 

 
 
 while ($Row = mysql_fetch_assoc($QueryResult))
 {
   $category = stripslashes($Row["category"]);
   $category_id = stripslashes($Row["category_id"]);
   
   
		   echo "<tr>";
		   echo "  <td>";
		   echo "  </td>";
		   echo "  <td>\n";
		   echo "    <fieldset style=\"text-align:right; width:250px;\">";
		   echo "    <FORM action=\"edit_category.php\" method=\"POST\">\n";
		   echo "      <input type=\"hidden\" name=\"category_id\" value=\"$category_id\" />\n";
		   echo "$category \n";
		   echo "      <input type=\"submit\" name=\"submit\" value=\"EDIT\" />\n";
		   echo "    </FORM>\n";

		   echo "  </td>\n";
		   
			$ItemTable = "items";
			
			$QueryString = "SELECT * FROM $ItemTable WHERE Category='$category_id'";
			$CategoryCheck = mysql_query($QueryString) or die ("No Query".mysql_errno($DBConnect));
		   
			$num_rows = mysql_num_rows($CategoryCheck);
		   
			if ($num_rows < 1) 
			{
		   	   echo "  <td>\n";
			   echo "    <FORM action=\"delete_category_confirm.php\" method=\"POST\">\n";
			   echo "      <input type=\"hidden\" name=\"category_id\" value=\"$category_id\" />\n";
			   echo "      <input type=\"submit\" name=\"submit\" value=\"DELETE\" />\n";
			   echo "    </FORM>\n";
			   echo "  </td>\n";
			   echo "</tr>";
			   echo "    </fieldset>";
   			}
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