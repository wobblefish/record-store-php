<?php

$cart_quantity=$_POST['cart_quantity'];
$cart_item_id=$_POST['cart_item_id'];

//Get the user's IP address and their session ID

	$customer_ip=$_SERVER['REMOTE_ADDR']; 

	
	session_start();
	$customer_session = session_id();
	
	
	
	//Connect To The database
	
		
		include($_SERVER["DOCUMENT_ROOT"] . '/db/dbinfo.php');
	
		$TableName = "shopping_cart";
		
		mysql_select_db($DBName);
			
		
		//Check the maximum number of items available from the items table
		$QueryString = "SELECT * FROM items WHERE item_id='$cart_item_id'";
		$QueryResult = mysql_query($QueryString) or die ("No Query".mysql_errno($DBConnect));
			
				while ($Row = mysql_fetch_assoc($QueryResult))
				{
				   $quantity = stripslashes($Row["quantity"]);
				}
				
		if ($cart_quantity > $quantity) {
			$cart_quantity = $quantity;
			}
		
		//Get the item, quantity information
				
		$QueryString2 = sprintf("UPDATE $TableName SET quantity = '%s' WHERE item_id = '%s'",
						mysql_real_escape_string($cart_quantity),
						mysql_real_escape_string($cart_item_id));
									
		$QueryResult2 = mysql_query($QueryString2) or die (mysql_error());
		
		mysql_close($DBConnect);
		header("location: ./shopping_cart.php");
		
						
	
?>