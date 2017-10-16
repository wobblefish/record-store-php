<?php
	
	//Get Session ID & Get User ID Procedures
		
		//Flags
		$session_pass = 0;
		$id_pass = 0;
	
		
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

<title>Order Details</title>
<meta http-equiv="content-type"
	content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="/css/styles.css" type="text/css" />
</head>
	<body>

	
		<h1>Order Details</h1>
				
		<table width=800 BORDER=1 id="shopping_cart">
			<tr>
				<th><h2>Item</h2></th>
				<th><h2>Quantity</h2></th>
				<th><h2>Price</h2></th>

			</tr>

<?php
//Retrieve The value from the previous form
	$order_id=$_POST['order_id'];
	
		//PULL THE DATA FROM THE ORDER-INFO, SHOPPING CART AND ITEMS-SOLD TABLES
		
		$runningtotal=0;

		$DBConnect = mysql_connect("localhost", "root", "") or die ("unable to connect".mysql_error());
		
		mysql_select_db($DBName);
		
		echo "Order #: " . $order_id;
		
		$QueryString3 = "SELECT * FROM order_info WHERE order_id='$order_id'";
		$QueryResult3 = mysql_query($QueryString3) or die ("No Query".mysql_errno($DBConnect));
		
		while ($Row = mysql_fetch_assoc($QueryResult3))
		{
			//Pull the cart item id from the cart table
			$fname = stripslashes($Row["fname"]);
			$lname = stripslashes($Row["lname"]);
			$phone = stripslashes($Row["phone"]);
			$email = stripslashes($Row["email"]);
		}
		
		$TableName2 = "items_sold";
		$QueryString2 = "SELECT * FROM $TableName2 WHERE order_id='$order_id'";
		$QueryResult2 = mysql_connect("localhost", "root", "") or die ("unable to connect".mysql_error());

		
		$runningtotal = 0;	
		while ($Row = mysql_fetch_assoc($QueryResult2))
		{
			//Pull the cart item id from the cart table
			$item_id = stripslashes($Row["item_id"]);
			$quantity = stripslashes($Row["quantity"]);
			$price = stripslashes($Row["item_price"]);
						$runningtotal += $price;
			
			
			
			//Get the information for the items matching the item ids in the shopping cart
			$TableName = "items";
			$QueryString = "SELECT * FROM $TableName WHERE item_id=$item_id";
			$QueryResult = mysql_query($QueryString) or die ("No Query".mysql_errno());
			
				while ($Row = mysql_fetch_assoc($QueryResult))
				{
				   $title = stripslashes($Row["title"]);
				   
						
		  		}
			
			?>
	<tr>	
		<td><?php echo $title;?></td>
		<td><?php echo $quantity;?></td>
		<td><?php echo "$" . $price;?></td>
	</tr>		
				
<?php
		}
?>
		</form>
		<tr><td><h2>Total:</h2></td>
		<td></td>
		<td><h2><?php echo "$" . $runningtotal; ?></h2></td>
		
	</table>
	<br />
	
	<!-- Customer Information -->
	<table id="custInfo3" border="1" width=800>
	<th>Customer Info</th>
		
			<tr><td>First Name:<?php echo $fname;?></td></tr>
			<tr><td>Last Name: <?php echo $lname;?></td></tr>
			<tr><td>Phone:     <?php echo $phone;?></td></tr>
			<tr><td>Email: 	   <?php echo $email;?></td></tr>
		
		
	</table>
	
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