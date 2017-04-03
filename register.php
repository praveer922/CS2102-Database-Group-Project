<html>
<head>
  <title>Register</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

  <link rel="stylesheet" type="text/css" href="app.css">
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home.html">Pets Paradise <i class="fa fa-paw fa-fw"></i></a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a href="home.html#contact">Contact</a></li>
      </ul>
      <ul class="nav navbar-nav">
        <li><a href="pet-portal.php">Search</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="login.php">Login  <i class="fa fa-user"></i></a></li>
      </ul>
    </div>
  </div>
 </nav>

<?php
$dbconn = pg_connect("postgres://plwneqlk:-2HZ6tyCgzUN7vQTK8m0FBkUlQOZ6brW@babar.elephantsql.com:5432/plwneqlk")
    or die('Could not connect: ' . pg_last_error());
?>
 
 <body> 
 <div class="container">
<?php

if(isset($_POST['submit'])) 
{
	$query = "INSERT INTO Users VALUES ('".$_POST['username']."', '".$_POST['password']."', '".strtoupper($_POST['fullname'])."', '".$_POST['emailaddress']."', '"
		.$_POST['address']."', '".$_POST['isA']."', '".$_POST['description']."', '".$_POST['likebreeds']."');";


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
        <p>What is your favourite breed?</p>
        <textarea name="likebreeds" rows="15" cols="80" placeholder="Enter text here..."></textarea><br><br>
  			<p>Include a description: </p>
  			<textarea name="description" rows="15" cols="80" placeholder="Enter text here..."></textarea><br><br>

            <input type="submit" name="submit" value="Register"> 
            
        </form> 
    </div>
    </body> 
</html> 

