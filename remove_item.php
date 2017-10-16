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
			
		//Get the item, quantity information
				
		$QueryString2 = sprintf("DELETE from $TableName WHERE item_id = '%s' AND customer_session='$customer_session' AND customer_ip='$customer_ip'",
						mysql_real_escape_string($cart_item_id));
									
		
		$QueryResult2 = mysql_query($QueryString2) or die (mysql_error());
		
		mysql_close($DBConnect);
		header("location: ./shopping_cart.php");
		
						
	
?>