<?php

//Get the user's IP address and their session ID


//Get the user's IP address and their session ID

	$customer_ip=$_SERVER['REMOTE_ADDR']; 

	
	session_start();
	$customer_session = session_id();
	
	
	$item_id=$_POST['item_id'];
	$cart_quantity=$_POST['cart_quantity'];
	

	
	//Connect To The database
	
		
				include($_SERVER["DOCUMENT_ROOT"] . '/db/dbinfo.php');
		$TableName = "shopping_cart";
		mysql_select_db($DBName);
		
		//If the item exists in the database, pull the quantity
		
		$QueryString = sprintf("SELECT * FROM $TableName WHERE item_id='$item_id' AND customer_session='$customer_session' AND customer_ip='$customer_ip'");
		$QueryResult = mysql_query($QueryString) or die (mysql_error());					
		
		if (mysql_num_rows($QueryResult) > 0)
		{
		
		while ($Row = mysql_fetch_assoc($QueryResult)) {
			$cart_quantity = stripslashes($Row["quantity"]);
		}
		
		
		$QueryString2 = sprintf("UPDATE $TableName SET quantity = '%s' + 1 WHERE item_id = '%s' AND customer_session='$customer_session' AND customer_ip='$customer_ip'",
						mysql_real_escape_string($cart_quantity),
						mysql_real_escape_string($item_id));
									
		
		$QueryResult2 = mysql_query($QueryString2) or die (mysql_error());
				
		}
		

		//Else add to cart
		else {
		$QueryString = sprintf("INSERT INTO $TableName (item_id, customer_session, customer_ip, quantity)
								VALUES ('%s', '%s', '%s', '%s')",
								mysql_real_escape_string($item_id),
								mysql_real_escape_string($customer_session),
								mysql_real_escape_string($customer_ip),
								mysql_real_escape_string($cart_quantity));
							
		$QueryResult = mysql_query($QueryString) or die (mysql_error());
		}
		mysql_close($DBConnect);
		header("location: ./shopping_cart.php");
		
						
	
?>