<?php

//Get the user's IP address and their session ID

	$customer_ip=$_SERVER['REMOTE_ADDR']; 
	
	session_start();
	$customer_session = session_id();
	

	
?>
	
	<!DOCTYPE html PUBLIC " - //W3C//DTD XHTML 1.0
Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<title>Shopping Cart</title>
<meta http-equiv="content-type"
	content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="/css/styles.css" type="text/css" />
</head>
	<body id="products">
	
	<?php

//CATEGORY BAR

	
			include($_SERVER["DOCUMENT_ROOT"] . '/db/dbinfo.php');
	mysql_select_db($DBName);
	
	$TableName = "genres";
	$QueryString2 = "SELECT * FROM $TableName ORDER BY category_id ASC";
	$QueryResult2 = mysql_query($QueryString2) or die ("No Query".mysql_errno($DBConnect));
	
	?>
	<table border="1" colspan="1" id="category_bar">
	<th colspan="1"><img src="categories.png"></th>
	<tr><td><a href="./products.php"><h3>--All Items--</h3></a></tr></td>

	<?php

//INSIDE A WHILE LOOP WE GET THE VALUES IN THE CATEGORY FIELD

	
	while ($Row2 = mysql_fetch_assoc($QueryResult2))
 {
   $category = stripslashes($Row2["category"]);
   $category_id = stripslashes($Row2["category_id"]);
   
   
   echo "<tr><td>";
   echo "<a href=\"products.php?cid=$category_id\"><h3>$category</h3></a> \n";
   echo "</td></tr>";
   
	$ItemTable = "items";
	
      
 }	?> 
	</table>
	<?php
	

 //END CATEGORY BAR
 ?>
	
		<table width=800 BORDER=1 id="shopping_cart">
			<tr>
				<th><h2>Item</h2></th>
				<th><h2>Quantity</h2></th>
				<th><h2>Price</h2></th>
				<th><h2>Update</h2></th>
				<th><h2>Remove</h2></th>
			</tr>

<?php
		$runningtotal=0;

		$DBConnect = mysql_connect("localhost", "root", "") or die ("unable to connect".mysql_errno($DBConnect));
		
		mysql_select_db($DBName);

		

		$TableName2 = "shopping_cart";
		$QueryString2 = "SELECT * FROM $TableName2 WHERE customer_session='$customer_session' AND customer_ip='$customer_ip'";
		$QueryResult2 = mysql_query($QueryString2) or die ("No Query".mysql_errno($DBConnect));
	
		while ($Row = mysql_fetch_assoc($QueryResult2))
		{
			//Pull the cart item id from the cart table
			$cart_item_id = stripslashes($Row["item_id"]);
			$cart_quantity = stripslashes($Row["quantity"]);
			
			
			//Get the information for the items matching the item ids in the shopping cart
			$TableName = "items";
			$QueryString = "SELECT * FROM $TableName WHERE item_id=$cart_item_id";
			$QueryResult = mysql_query($QueryString) or die ("No Query".mysql_errno($DBConnect));
			
				while ($Row = mysql_fetch_assoc($QueryResult))
				{
				   $title = stripslashes($Row["title"]);
				   $price = stripslashes($Row["price"]);
		  		}
			
			$subtotal = $price * $cart_quantity;
			$runningtotal += $subtotal;
?>
	<tr>	
		<td><?php echo $title;?></td>
		
		<!-- Form for update button -->
		<form action="update_cart.php" method="POST">
			<input type="hidden" name="cart_item_id" value="<?php echo $cart_item_id;?>">
			<td><input type="text" size="4" name="cart_quantity" value="<?php echo $cart_quantity;?>"></td>
			<td><?php echo "$" . ($price * $cart_quantity);?></td>
			<td><input name="submit" type="submit" value="Update" id="Update"></form></td>
		
		<!-- Form for delete button -->
		<form action="remove_item.php" method="POST">
			<input type="hidden" name="cart_item_id" value="<?php echo $cart_item_id;?>">
			<td><input name="submit" type="submit" value="Remove" id="Remove"></form></td>
		
	</tr>		
				
<?php
		}
?>
		</form>
		<tr><td><h2>Subtotal:</h2></td>
		<td></td>
		<td><h2><?php echo "$" . $runningtotal; ?></h2></td>
		<td></td>
		<td></td>
	</table>
	<br />
	
<?php

//Get values from order entry form
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	$phone=$_POST['phone'];
	$email=$_POST['email'];

//DEFAULT ERROR FLAGS TO 0
	$Blank = 0;
	$fnameBlank = 0;
	$lnameBlank = 0;
	$phoneBlank = 0;
	$emailBlank = 0;
	$emailFormat = 0;
  
	if ($fname=="") 		{$fnameBlank=1; $Blank+=1;}
	if ($lname=="") 		{$lnameBlank=1; $Blank+=1;}
	if ($phone=="") 		{$phoneBlank=1; $Blank+=1;}
	
	$emailPattern="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)?*(\.[a-z]{2,3})$";
	
	if ($email=="") 		{
	   $emailBlank=1; $Blank+=1;
	} else {
	   if (preg_match("/^[^@]*@[^@]*\.[^@]*$/", $email)) {echo "Email Validates";} else {$emailFormat=1; $Blank+=1;}
	}
			 
 
 if ($Blank>0) {
	echo "There are " . $Blank . " errors.";

?>	
	
	<!-- Customer Information -->
	<table id="custInfo" border="1">
	<th>Customer Info</th>
		<form action="check_order.php" method="POST">
			<input type="hidden" name="cart_item_id" value="<?php echo $cart_item_id;?>">
			<tr><td><?php if ($fnameBlank == 1) echo "<FONT color=red>*</font>"; ?>First Name:   	<input type="text" name="fname" value="<?php echo $fname;?>"></td></tr>
			<tr><td><?php if ($lnameBlank == 1) echo "<FONT color=red>*</font>"; ?>Last Name:   		<input type="text" name="lname" value="<?php echo $lname;?>"></td></tr>
			<tr><td><?php if ($phoneBlank == 1) echo "<FONT color=red>*</font>"; ?>Phone:   			<input type="text" name="phone" value="<?php echo $phone;?>"></td></tr>
			<tr><td><?php if ($emailBlank == 1 || $emailFormat == 1) echo "<FONT color=red>*</font>"; ?>Email:   			<input type="text" name="email" value="<?php echo $email;?>"></td></tr>
			<td><input name="submit" type="submit" value="Submit Order" id="Update"></td>
		</form>
	</table>
	
	<?php

			/*IF THE FORM VALUES ARE OK, UPDATE THE order_info TABLE
			RETREIVE THE ORDER_ID AND LOOP THROUGH THE CART AND MOVE EACH ITEM INTO A TABLE CALLED items_sold (item_id, order_id, item_price, quantity)
			REDIRECT TO order_thankyou */
			
			} else {
			
		
			//Connect to the database
			
					include($_SERVER["DOCUMENT_ROOT"] . '/db/dbinfo.php');
			$TableName = "order_info";
			mysql_select_db($DBName);
			
			$QueryString = sprintf("INSERT INTO $TableName (customer_session, customer_ip, fname, lname, phone, email)
														VALUES ('%s', '%s', '%s', '%s', '%s', '%s')",
														mysql_real_escape_string($customer_session),
														mysql_real_escape_string($customer_ip),
														mysql_real_escape_string($fname),
														mysql_real_escape_string($lname),
														mysql_real_escape_string($phone),
														mysql_real_escape_string($email));
														
			$QueryResult = mysql_query($QueryString) or die ("No Query".mysql_errno($DBConnect));
		
			$TableName = "order_info";
			$QueryString = sprintf("SELECT * FROM $TableName WHERE customer_session='$customer_session' AND customer_ip='$customer_ip'");
			$QueryResult = mysql_query($QueryString) or die (mysql_error());
			
			//PULL THE ORDER ID FROM ORDER-INFO
			while ($Row = mysql_fetch_assoc($QueryResult)) {
			$order_id = stripslashes($Row["order_id"]);
			}
			
			$QueryString2 = sprintf("SELECT * FROM shopping_cart WHERE customer_session='$customer_session' AND customer_ip='$customer_ip'");
			$QueryResult2 = mysql_query($QueryString2) or die (mysql_error());
			
			//PULL THE ITEM-ID AND QUANTITY FROM SHOPPING CART
			while ($Row = mysql_fetch_assoc($QueryResult2))
			{
				   $item_id = stripslashes($Row["item_id"]);
				   $quantity = stripslashes($Row["quantity"]);
							
				
				//PULL THE PRICE FROM THE ITEMS TABLE
				$QueryString = sprintf("SELECT * FROM items WHERE item_id='$item_id'");
				$QueryResult = mysql_query($QueryString) or die (mysql_error());
				
				while ($Row = mysql_fetch_assoc($QueryResult))
				{
				   $price = stripslashes($Row["price"]);
				   $price *= $quantity;
				}
				
				//Draw the quantity ordered away from the amount available in the items table
				
				
				$QueryString3 = sprintf("UPDATE items SET quantity = quantity - '%s' WHERE item_id = '%s'",
						mysql_real_escape_string($quantity),
						mysql_real_escape_string($item_id));
									
		
				$QueryResult3 = mysql_query($QueryString3) or die (mysql_error());
				
			//Now update the database with the values we pulled
			$QueryString4 = sprintf("INSERT INTO items_sold (item_id, order_id, item_price, quantity)
														VALUES ('%s', '%s', '%s', '%s')",
														mysql_real_escape_string($item_id),
														mysql_real_escape_string($order_id),
														mysql_real_escape_string($price),
														mysql_real_escape_string($quantity));											
														
			$QueryResult4 = mysql_query($QueryString4) or die ("No Query".mysql_errno($DBConnect));
			mysql_close($DBConnect);
			header("location: ./order_thankyou.php");
			}
		}
			
			
?>				
	
	
	
	</body>
</html>