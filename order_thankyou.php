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

<title>Thank You For Ordering!</title>
<meta http-equiv="content-type"
	content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="/css/styles.css" type="text/css" />
</head>
	<body>
	
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

 //Display thank you message
 ?>
		<h1>Thanks For Ordering From Slick Penguin Records!</h1>
		<p>Please allow approximately 2-4 weeks for delivery</p>
		<p>You may print this page for your records.</p>
		
		<table width=800 BORDER=1 id="shopping_cart">
			<tr>
				<th><h2>Item</h2></th>
				<th><h2>Quantity</h2></th>
				<th><h2>Price</h2></th>

			</tr>

<?php
		
		//PULL THE DATA FROM THE ORDER-INFO, SHOPPING CART AND ITEMS-SOLD TABLES
		
		$runningtotal=0;

		$DBConnect = mysql_connect("localhost", "root", "") or die ("unable to connect".mysql_errno($DBConnect));
		
		mysql_select_db($DBName);
		
		$QueryString3 = "SELECT * FROM order_info WHERE customer_session='$customer_session' AND customer_ip='$customer_ip'";
		$QueryResult3 = mysql_query($QueryString3) or die ("No Query".mysql_errno($DBConnect));
		
		while ($Row = mysql_fetch_assoc($QueryResult3))
		{
			//Pull the cart item id from the cart table
			$fname = stripslashes($Row["fname"]);
			$lname = stripslashes($Row["lname"]);
			$phone = stripslashes($Row["phone"]);
			$email = stripslashes($Row["email"]);
		}
		
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
		<td><?php echo $cart_quantity;?></td>
		<td><?php echo "$" . ($price * $cart_quantity);?></td>
	</tr>		
				
<?php
		}
?>
		</form>
		<tr><td><h2>Subtotal:</h2></td>
		<td></td>
		<td><h2><?php echo "$" . $runningtotal; ?></h2></td>
		
	</table>
	<br />
	
	<!-- Customer Information -->
	<table id="custInfo2" border="1" width=800>
	<th>Customer Info</th>
		
			<tr><td>First Name:<?php echo $fname;?></td></tr>
			<tr><td>Last Name: <?php echo $lname;?></td></tr>
			<tr><td>Phone:     <?php echo $phone;?></td></tr>
			<tr><td>Email: 	   <?php echo $email;?></td></tr>
		
		
	</table>
	
<?php 
		mysql_close($DBConnect);
		
		//Unset the session id
		session_unset();
		session_regenerate_id();
		unset($customer_ip);
?>
	
	</body>
</html>