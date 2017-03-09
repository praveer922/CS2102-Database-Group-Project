<html> 
<head> <title>Register</title> </head>
<?php
$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=amos0907")
    or die('Could not connect: ' . pg_last_error());
?>
 
 <body> 
<?php

if(isset($_POST['submit'])) 
{
    $data = $_POST['description'];
    echo $_POST['description'] . "\n";
    $escaped = pg_escape_literal($data);
    echo $escaped. "\n";
	$query = "INSERT INTO Users VALUES ('".$_POST['username']."', '".$_POST['password']."', '".strtoupper($_POST['fullname'])."', '".$_POST['emailaddress']."', '"
        .$_POST['address']."', '".$_POST['isA']."', '".$_POST['description']."');";

	$result = pg_query($query); 
        if (!$result) { 
            $errormessage = pg_last_error(); 
            echo "Error with query: " . $errormessage; 
            exit(); 
        } 
        echo "<script> alert('You have successfully registered, ".$_POST['username'].". Please log in.'); 
        window.location.href='pet-portal.php'; </script>";
        pg_close(); 


}
?>

   
    	<h1>Register</h1>
        <form action="register.php" method="post"> 
            <p>Username: </p>  <input type="text" name="username" size="40" length="40"><BR> 
            <p>Password: </p>  <input type="text" name="password" size="40" length="40"><BR> 
            <p>Email Address: </p>  <input type="text" name="emailaddress" size="40" length="40"><BR> 
            <p>Full Name: </p> <input type="text" name="fullname" size="40" length="60"><BR> 
            <p>Address: </p> <input type="text" name="address" size="40" length="60"><BR> 
            <p>Are you a: </p> 
            <input type="radio" name="isA" value="petowner"> Pet Owner<br>
  			<input type="radio" name="isA" value="caretaker"> Care-Taker<br>
  			<input type="radio" name="isA" value="both"> Both <br><br>
  			<p>Include a description: </p>
  			<textarea name="description" rows="15" cols="80" placeholder="Enter text here..."></textarea><br><br>

            <input type="submit" name="submit" value="Register"> 
            
        </form> 
    </body> 
</html> 

