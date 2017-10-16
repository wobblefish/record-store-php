<!DOCTYPE html PUBLIC " - //W3C//DTD XHTML 1.0
Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<title>Check Login</title>
<meta http-equiv="content-type"
	content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="/css/styles.css" type="text/css" />
</head>
	<body>
		<H1>Inventory Management System:</H1>
		  
		<?php

		  //GET THE VALUES FROM THE PREVIOUS FORM
		  
		  $username=$_POST['username'];
		  $password=$_POST['password'];
			
		  $Valid = 0;

			
			
					include($_SERVER["DOCUMENT_ROOT"] . '/db/dbinfo.php');			
			$TableName = "admin_info";
			mysql_select_db($DBName);
			$Duplicates = 0;
			$QueryString = "SELECT * FROM $TableName WHERE username='$username' AND password='$password' AND active='1'";
			$QueryResult = mysql_query($QueryString);

			//Check for matching rows
			$num_rows = mysql_num_rows($QueryResult);
			if ($num_rows > 0) $Valid=1;
			
			//IF THERE ARE ERRORS, RESHOW FORM WITH VALUES FILLED IN AND 
			//AN ERROR MESSAGE BESIDE THE FIELD
			if ($Valid == 0)
			{
	?>  
		   
		   <FONT color=red><h3>Invalid Username And Password</h3></font>
		   <fieldset style="text-align:right; width:250px;">
		<legend><h3>Please Verify And Try Again:</h3></legend>
		<FORM action="checkLogin.php" method="POST">
			  Username: <input type="text" name="username" value="<?php echo "$username";?>" /><br />
			  Password: <input type="password" name="password" value="<?php echo "$password"; ?>" /><br />
			  <input type="submit" name="submit" value="Login" />
		   </FORM>
		</fieldset>
	
	</body>
</html>


<?php


  } else 	{
			
			//Get the user ID from the record entered
			
			$TableName = "admin_info";
			
			$QueryString = sprintf("SELECT * FROM $TableName WHERE username='%s' AND password='%s'",
									mysql_real_escape_string($username),
									mysql_real_escape_string($password));
									
					
			$result = mysql_query($QueryString) or die (mysql_error());
			
			while ($row = mysql_fetch_assoc($result)) {
				$user_id = stripslashes($row["admin_id"]);
			}
			
			//Get a session id
			
			session_start();

			$session_id = session_id();
					
			//Set them in Java session db
			
						
			$SQLString = sprintf("INSERT INTO current_session (user_id, session_num) 
						VALUES('%s', '%s')",
						mysql_real_escape_string($user_id),
						mysql_real_escape_string($session_id));
						
			$QueryResult = mysql_query($SQLString) or die (mysql_error());
			mysql_close($DBConnect);			
			
			header("location: ./admin/index.php");
		
			}

?>