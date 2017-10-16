
	
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

<title>Delete Item Confirm</title>
<meta http-equiv="content-type"
	content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="/css/styles.css" type="text/css" />
</head>

<body>
<H1>Delete Item Confirm</h1>

<?php
	
    $DBConnect = mysql_connect("localhost", "root", "") or die ("unable to connect".mysql_error());
    
    mysql_select_db($DBName);

    $item_id=$_POST['item_id'];
    $TableName = "items";
	$QueryString = "SELECT * FROM $TableName WHERE item_id='$item_id'";
	$QueryResult = mysql_query($QueryString) or die ("No Query".mysql_connect_errno());
	
	 while ($Row = mysql_fetch_assoc($QueryResult)) {
		$catdropdown = stripslashes($Row["Category"]);
		$item_id = stripslashes($Row["item_id"]);
		$title = stripslashes($Row["title"]);
		$description = stripslashes($Row["description"]);
		$price = stripslashes($Row["price"]);
		$quantity = stripslashes($Row["quantity"]);
		$sku = stripslashes($Row["sku"]);
		$image = stripslashes($Row["image"]);
		}   
	
	
	echo "<h2>Are you sure you want to delete this item??</h2>";
	echo "<tr>";
    echo "  <td>$title/$item_id/$description";
    echo "  </td>";
    echo "  <td>\n";
    echo "    <FORM action=\"delete_item.php\" method=\"POST\">\n";
    echo "      <input type=\"hidden\" name=\"item_id\" value=\"$item_id\" />\n";
    echo "      <input type=\"submit\" name=\"submit\" value=\"CONFIRM\" />\n";
    echo "    </FORM>\n";
    echo "  </td>\n";
    echo "  <td>\n";
    echo "    <FORM action=\"view_items.php\" method=\"POST\">\n";
    echo "      <input type=\"hidden\" name=\"item_id\" value=\"$item_id\" />\n";
    echo "      <input type=\"submit\" name=\"submit\" value=\"GO BACK\" />\n";
    echo "    </FORM>\n";
    echo "  </td>\n";
    echo "</tr>";
	
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