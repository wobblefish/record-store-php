
	
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

<title>Edit Item</title>
<meta http-equiv="content-type"
	content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="/css/styles.css" type="text/css" />
</head>

<body>
<H1>Edit Item</h1>

<?php
   

 $item_id=$_POST['item_id'];
  
	$DBConnect = mysql_connect("localhost", "root", "") or die ("unable to connect".mysql_error());
	
	mysql_select_db($DBName);

	$TableName = "items";
	
	$QueryString = sprintf("SELECT * FROM $TableName WHERE item_id='%s'",
					mysql_real_escape_string($item_id));
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
 
 
 ?>
 <FORM action="check_item_save.php" method="POST" enctype="multipart/form-data">
 Category: <select name="catdropdown">
					<option value = "">Select a genre:</option>
								   
					<?php

   $result = mysql_query("select category_id, category from inventory.genres");
					while ($row = mysql_fetch_assoc($result)) {
							$category_id = stripslashes($row["category_id"]);
							$category = stripslashes($row["category"]);
							
							echo "<option value=\"$category_id\" ";
							
							if($category_id == $catdropdown) echo "SELECTED ";
							echo ">$category</option>";
					}	
					 echo "</select>\n";
					 echo "</p>\n";
	 
	$result = mysql_query("select image from inventory.items WHERE item_id='$item_id'");
	$row = mysql_fetch_assoc($result);
	$image = $image = stripslashes($row['image']);
	

   echo "    <fieldset style=\"text-align:right; width:350px;\">";
   echo "	 <legend><b>Item Details</b></legend>";
   echo "      <input type=\"hidden\" name=\"item_id\" value=\"$item_id\" />";
   echo "      Title:<input type=\"text\" name=\"title\" value=\"$title\" /><br />";
   
   
   
   echo "      Description: <textarea id=\"description\" name=\"description\">$description</textarea><br />";
   echo "      Price:<input type=\"text\" name=\"price\" value=\"$price\" /><br />";
   echo "      Quantity::<input type=\"text\" name=\"quantity\" value=\"$quantity\" /><br />";
   echo "      SKU #:<input type=\"text\" name=\"sku\" value=\"$sku\" /><br />";
  
   echo "Please choose an image: <input name=\"uploaded\" type=\"file\" value=\"$image\" /><br />";
   echo "Current Image: " . $image;
   echo "	   </fieldset>";
   echo "      <input type=\"submit\" name=\"submit\" value=\"Save\" />";
   echo "    </FORM>";
   
   
   
   
   
    // Include CKEditor class.
		include("./ckeditor/ckeditor.php");
    // Create class instance.
		$CKEditor = new CKEditor();
	// Path to CKEditor directory, ideally instead of relative dir, use an absolute path:
    //   $CKEditor->basePath = '/ckeditor/'
    // If not set, CKEditor will try to detect the correct path.
		$CKEditor->basePath = './ckeditor/';
    // Replace all textareas with CKEditor.
		$CKEditor->replaceAll();

 mysql_close($DBConnect);
 
?>

<br />
<a href="view_items.php">Return To Items</a> 
  
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