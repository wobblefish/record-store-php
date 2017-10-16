
	
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

<title>Check Item Save</title>
<meta http-equiv="content-type"
	content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="/css/styles.css" type="text/css" />
</head>

<body>
<H1>Check Item Save</h1>

<?php

	$item_id=$_POST['item_id'];
	$title=$_POST['title'];
	$description=$_POST['description'];
	$price=$_POST['price'];
	$quantity=$_POST['quantity'];
	$sku=$_POST['sku'];
	$catdropdown=$_POST['catdropdown'];
	$image=$_FILES["uploaded"]["name"];
	
	
	 //DEFAULT ERROR FLAGS TO 0
  $Blank = 0;
  $TitleBlank = 0;
  $DescBlank = 0;
  $PriceBlank = 0;
  $QuantityBlank = 0;
  $SKUBlank = 0;
  $ImageBlank = 0;
    
  //CHECK ALL VARIABLE WE NEED TO CHECK TO SEE IF THERE ARE ERRORS
  //IF THERE ARE, TRIP SENTINEL
  
  if ($title=="") 		{$TitleBlank=1; $Blank+=1;}
  if ($description=="") {$DescBlank=1; $Blank+=1;}
  if ($price=="") 		{$PriceBlank=1; $Blank+=1;}
  if ($quantity=="") 	{$QuantityBlank=1; $Blank+=1;}
  if ($sku=="") 		{$SKUBlank=1; $Blank+=1;}
  if ($image=="") 		{$ImageBlank=1;}
  
  //IF THERE ARE ERRORS, RESHOW FORM WITH VALUES FILLED IN AND 
  //AN ERROR MESSAGE BESIDE THE FIELD
    if ($Blank>0) {
	echo "There are " . $Blank . " errors.";
	
?>  
   <FONT color=red><h2>All Fields Are Required</h2></font>
   <FORM action="check_item_save.php" method="POST" enctype="multipart/form-data">

   <?php
   
      
	
		
			include($_SERVER["DOCUMENT_ROOT"] . '/db/dbinfo.php');
	mysql_select_db($DBName);
   
    $result = mysql_query("select category_id, category from inventory.genres");
   
    echo "<p>Select a genre:\n";
	echo "<select name=\"category_id\">\n";
    while ($row = mysql_fetch_assoc($result)) {
			$category_id = stripslashes($row['category_id']);
			$category = stripslashes($row['category']);
			echo "<option value=$category_id>$category\n";
			}
	 echo "</select>\n";
	 echo "</p>\n";


?>
	

				   
					  
					  Title: 		<input type="text" name="title" value="<?php echo "$title"; ?>" /> <?php if ($TitleBlank > 0) echo "*required"; ?> <br /> 
					  Description: <textarea id="description" name="description"><?php echo "$description"; ?></textarea><?php if ($DescBlank > 0) echo "*required"; ?><br />
					  Price: 		<input type="text" name="price" value="<?php echo "$price"; ?>" /><?php if ($PriceBlank > 0) echo "*required"; ?><br />
					  Quant:		<input type="text" name="quantity" value="<?php echo "$quantity"; ?>" /><?php if ($QuantityBlank > 0) echo "*required"; ?><br />
					  SKU  : 			<input type="text" name="sku" value="<?php echo "$sku"; ?>" /><?php if ($SKUBlank > 0) echo "*required"; ?><br />
					  Image: 		<input name="uploaded" type="file" value="<?php echo "$image"; ?>" /><br />
					  <br />
					  <br />
					  <input type="submit" name="submit" value="Save" />
				   </FORM>

<?php

	} else {
	
	
	
	
	

    $DBConnect = mysql_connect("localhost", "root", "") or die ("unable to connect".mysql_error());
    
    mysql_select_db($DBName);

    $TableName = "items";
	
    
	$query = sprintf("UPDATE $TableName SET Category = '%s', title = '%s', description = '%s', 
			price = '%s', quantity = '%s', sku = '%s' WHERE item_id = '%s'",
						mysql_real_escape_string($catdropdown),
						mysql_real_escape_string($title),
						mysql_real_escape_string($description),
						mysql_real_escape_string($price),
						mysql_real_escape_string($quantity),
						mysql_real_escape_string($sku),
						mysql_real_escape_string($item_id));

    // Execute Query
    $result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ()); 
    
	
	//Update the stored file
	
	
	
	if($ImageBlank > 0)
	{
		echo "No changes made to image";	
	
	}
	else
	{
	
		$SQLString = "SELECT item_id, image from $TableName WHERE item_id='$item_id'";
	   
		$result = mysql_query($SQLString) or die (mysql_error());
		
		while ($row = mysql_fetch_assoc($result)) {
				$item_id = stripslashes($row["item_id"]);
				$OldImage = stripslashes($row["image"]);
								
				
				}
		
		
		

		$target = "./images/".$item_id."_".$_FILES['uploaded']['name'];
			
		$target_fn = $item_id."_".$_FILES['uploaded']['name'];
		
		$result = mysql_query("UPDATE $TableName SET image = '$target_fn' WHERE item_id='$item_id'");
		$ok=1;
		
		$prev_pic_target = "./images/".$OldImage;
		unlink($prev_pic_target);

		
if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $target)) 
    {
       echo "The file ". basename( $_FILES['uploaded']['name']). " has been uploaded";
	    include('SimpleImage.php');
		$thumb1="./images/tn_".$target_fn;
		$image = new SimpleImage();
		$image->load($target);
		$image->resizeToWidth(150);
		$image->save($thumb1);
		
		
		$fullsize="./images/lrg_".$target_fn;
		$image = new SimpleImage();
		$image->load($target);
		$image->resizeToWidth(300);
		$image->save($fullsize);
		
    } else 	{
			echo "Sorry, there was a problem uploading your file.";
			}
	}	
		echo "<h2>Entry Changed</h2>";
		?> <a href="index.php">Return To Main</a>
		<?php
		
		mysql_close($DBConnect);
    }

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