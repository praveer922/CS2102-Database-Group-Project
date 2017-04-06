<html>
<head>
  <title>Register new pets</title>
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
	$query = "SELECT * FROM pets ORDER BY petid DESC LIMIT 1";
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
	$row = pg_fetch_row($result);
	$petID = ($row[0]+1);
		
	session_start(); 
	$owner = $_SESSION['login_user'];

	$query = "INSERT INTO Pets VALUES ('".$petID."','".$owner."','".($_POST['name'])."', '".$_POST['age']."', '".$_POST['breed']."', '"
		.$_POST['gender']."','".$_POST['description']."');";

	$result = pg_query($query); 
        if (!$result) { 
            $errormessage = pg_last_error(); 
            echo "Error with query: " . $errormessage; 
            exit(); 
        } 
        echo "<script> alert('You have successfully registered, ".$_POST['name'].".'); 
        window.location.href='pet-portal.php'; </script>";
        pg_close(); 


}
?>

   
    	<h1>Register new pet</h1>
        <form action="createPet.php" method="post"> 
		
            <p>Name: </p>  <input type="text" name="name" size="40" length="40"><BR> 
            <p>Age: </p>  <input type="number" name="age" size="40" length="40"><BR> 
            <p>Breed: </p> <input type="text" name="breed" size="40" length="60"><BR> 
            <p>Gender: </p>
            <input type="radio" name="gender" value="Male"> Male<br>
  			<input type="radio" name="gender" value="Female"> Female<br><br>

  			<p>Include a description of your pet: </p>
  			<textarea name="description" rows="15" cols="80" placeholder="Enter text here..."></textarea><br><br>

            <input type="submit" name="submit" value="Register"> 
            
        </form> 
    </div>
    </body> 
</html> 