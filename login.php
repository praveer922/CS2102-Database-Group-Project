<?php
session_start();
?>

<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

  <link rel="stylesheet" type="text/css" href="app.css">
</head>
<body>

  <!--NAVBAR -->
  <?php
  include_once("navbarloggedout.php");
  ?>

<?php
$dbconn = pg_connect("postgres://plwneqlk:-2HZ6tyCgzUN7vQTK8m0FBkUlQOZ6brW@babar.elephantsql.com:5432/plwneqlk")
    or die('Could not connect: ' . pg_last_error());
?>

 <body>
 <div class="container">
<?php

if(isset($_SESSION['login_user'])) {
  echo "<h3>You are already logged in.</h3>";
		die();
}

if(isset($_POST['submit']))
{
	$query = "SELECT * FROM Users u WHERE u.userid = '".$_POST['username']."' AND u.password = '".$_POST['password']."';";
	$result = pg_query($query);
        if (!$result) {
            $errormessage = pg_last_error();
            echo "Error with query: " . $errormessage;
            exit();
        }

		if ($row = pg_fetch_row($result)) {
      $_SESSION['login_user'] = $_POST['username'];
			echo "<script> alert('Welcome back ".$_POST['username'].".');
		    window.location.href='pet-portal.php'; </script>";
		} else {
      echo "<script> alert('Sorry, you have entered the wrong username or password :(')</script>";
		}
    pg_close();
}
?>


    	<h1>Login</h1>
        <form action="login.php" method="post">
            <p>Username: </p>  <input type="text" name="username" size="40" length="40"><BR>
            <p>Password: </p>  <input type="text" name="password" size="40" length="40"><BR>
            <br>
            <input type="submit" name="submit" value="Login">

        </form>
    </div>
    </body>
</html>
