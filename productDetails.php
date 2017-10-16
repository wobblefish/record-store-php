<?php

//Get the user's IP address and their session ID

	$customer_ip=$_SERVER['REMOTE_ADDR'];

	
	session_start();
	$customer_session = session_id();
	
	
//Retrieve the item ID for the item being displayed
$item_id=$_GET['item_id'];
  
	
	$DBConnect = mysql_connect("localhost", "root", "") or die ("unable to connect".mysql_connect_errno());
	
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

 
	$result = mysql_query("select image from inventory.items WHERE item_id='$item_id'");
	$row = mysql_fetch_assoc($result);
	$image = $image = stripslashes($row['image']);
 
?>

<?php

//Connect to the database and bring down the necessary information

	
	
			include($_SERVER["DOCUMENT_ROOT"] . '/db/dbinfo.php');

	mysql_select_db($DBName);
	
	$TableName = "items";
	
	$QueryString = sprintf("SELECT * FROM $TableName WHERE item_id=$item_id");
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
	
	<!DOCTYPE html PUBLIC " - //W3C//DTD XHTML 1.0
Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<title>Slick Penguin Records: <?php echo $title; ?></title>
<meta http-equiv="content-type"
	content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="/css/styles.css" type="text/css" />
</head>
	<body id="products">

	<?php
//Category Bar Displayed on The Left Of The Page

	
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
	<tr><td><a href="./shopping_cart.php"><h3>--Checkout--</h3></a></tr></td>
	</table>
	<?php
	 //END CATEGORY BAR
 	?>
	
	<table border="1" colspan="1" width="950" id="productDetails"><tr><td>

<H1><?php echo $title;?></H1>

<?php
//Display the price, quantity, SKU, description for the image
echo "<br /><img width=\"300\" src=\"./admin/images/lrg_$image\" /><br />"; ?>
Price: $<?php echo $price;?><br />
SKU: <?php echo $sku;?><br />
Quantity: <?php echo $quantity;?><br />

			<form action="add_to_cart.php" method="post" name="AddToCart">
			  <input name="item_id" type="hidden" value="<?php echo "$item_id";?>">
			  <input name="cart_quantity" type="hidden" value="1">
			  <input name="submit" type="submit" value="Add to Cart">
			</form>


<h2>Description:</h2><?php echo $description;?>
							   
<?php
 	echo "</td></tr></table>";

 mysql_close($DBConnect);
 
?>
  
</body>

</html>
