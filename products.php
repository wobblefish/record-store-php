<?php

//Get the user's IP address and their session ID

	$customer_ip=$_SERVER['REMOTE_ADDR']; 

	
	session_start();
	$customer_session = session_id();
	
	
//Connect to the database and bring down the necessary information

	//Errors hidden otherwise will list invalid index unless a category is chosen
	error_reporting(0);

    //Get the category id sent by the link that is clicked
	$Category_GET=$_GET['cid'];
	//GetDB Connect Info
	include($_SERVER["DOCUMENT_ROOT"] . '/db/dbinfo.php');
	mysql_select_db($DBName);
	$TableName = "items";

	$QueryString = sprintf("SELECT * FROM $TableName");
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

<title>Slick Penguin Records: Home</title>
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
<!-- Start Category Table -->
	<table border="1" colspan="1" id="category_bar">
	<th colspan="1"><img src="/images/categories.png"></th>
	<tr><td><a href="./products.php"><h3>--All Items--</h3></a></tr></td>

<?php

//Loop through the table displaying category names in their own table row

	
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

 //If there is a category id retrieved with GET, display the results under that category, otherwise, display them all
 
   if ($Category_GET!="") { $QueryString = "SELECT * FROM $ItemTable WHERE Category='$Category_GET'";} else { $QueryString = "SELECT * FROM $ItemTable";}

	$items_rs = mysql_query($QueryString) or die ("No Query".mysql_errno($DBConnect));
	
	 
	//Link To Admin Section
 ?>
	<fieldset id="admin"><a href="./admin/index.php">Admin Section</a></fieldset>

<!-- This is the table that will hold the products for each category -->
		
		<table border="5" width="950" id="product_table">
		<tr><th colspan="4"><img src="/images/logo.png"></th></tr>
		<tr><th colspan="4"><img src="/images/releases.png"></th></tr>
		
		<tr>
<?php
	
//Initialize a counter so we can control the way the rows are built	
	$counter=0;
	while ($Row = mysql_fetch_assoc($items_rs))
	{
	   $title = stripslashes($Row["title"]);
	   $image = stripslashes($Row["image"]);
	   $price = stripslashes($Row["price"]);
	   $item_id = stripslashes($Row["item_id"]);

//When the row becomes divisible by 4, end the table row and start a new one
	   if ($counter%4==0) echo "</tr><tr>";
	   $counter++;
?>
			<td>
				<a href="productDetails.php?item_id=<?php echo "$item_id";?>" id="product_link">
				<?php
				echo $title . "<br /><br />";
				echo "<img height=\"150\" src=\"$image\" /><br /></a>";
				echo "$" . $price . "<br />";
				//echo "<button type=\"button\" action=\"productDetails.php\">Buy Now</button>";
				?>
				
			<form action="add_to_cart.php" method="post" name="AddToCart">
			  <input name="item_id" type="hidden" value="<?php echo "$item_id";?>">
			  <input name="cart_quantity" type="hidden" value="1">
			  <input name="submit" type="submit" value="Add to Cart">
			</form>
				<br />
				
				</td>
				
<?php
}
mysql_close($DBConnect);
?>
				</tr>
		</table>		
	  
				
	</body>

</html>

