<html>
<head>
  <title>Pets Paradise</title>
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
        <li><a href="register.php">Signup  <i class="fa fa-user-plus"></i></a></li>
        <li><a href="login.php">Login  <i class="fa fa-user"></i></a></li>
      </ul>
    </div>
  </div>
 </nav>

<?php
$dbconn = pg_connect("postgres://plwneqlk:-2HZ6tyCgzUN7vQTK8m0FBkUlQOZ6brW@babar.elephantsql.com:5432/plwneqlk")
    or die('Could not connect: ' . pg_last_error());
?>

<?php

	if(isset($_GET['user'])) {
    $userid = $_GET['user'];
    $query = "SELECT name, email, address, description FROM Users WHERE userid='$userid'";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    $row = pg_fetch_row($result);

    echo"

    <div class='row'>
    <div class='col-md-5 col-md-offset-1'>
    <h2>". $userid . "'s Profile</h2>
    <div class='panel panel-default'>
  <div class='panel-heading'>User Information</div>
  <div class='panel-body'>
  <p><strong>Name:</strong> ". $row[0] ."</p>
  <p><strong>Email:</strong> ". $row[1] ."</p>
  <p><strong>Address:</strong> ". $row[2] ."</p>
  <p><strong>Description:</strong> ". $row[3] ."</p></div>
</div>";
  
  $today = date("Y-m-d");
  $query = "SELECT price FROM Bids WHERE fromDate>='$today' AND caretakerid='$userid' AND price >= ALL(SELECT price FROM Bids WHERE fromDate>='$today' AND caretakerid='$userid')";

  $result = pg_query($query) or die('Query failed: ' . pg_last_error());
  if (pg_num_rows($result) > 0) {
    $row = pg_fetch_row($result);
    echo "<h4>The highest bid that " . $_GET['user'] . " has from today onwards is <strong>$" . $row[0] . "</strong>.</h4>
    <h4>Bid a higher price to secure your petkeeper!</h4></div>";
  } else {
    echo "no bids";
  }

		echo "<div class='col-md-5'>
    <h2>Received bids</h2>";

		$query = "SELECT b.petownerid, p.name, p.breed, b.fromDate, b.toDate, b.price FROM Bids b INNER JOIN Pets p ON p.owner = b.petownerid WHERE b.caretakerid='$userid'";

		$result = pg_query($query) or die('Query failed: ' . pg_last_error());

		echo "<div class='panel panel-default'><table class='table table-striped table-hover table-bordered table-responsive'>
			    <tr>
			    <th>Pet Owner</th>
			    <th>Pet Name</th>
			    <th>Pet Breed</th>
			    <th>From</th>
			    <th>To</th>
			    <th>Price</th>
			    </tr>";
		while ($row = pg_fetch_row($result)){
		      echo "<tr>";
		      echo "<td>" . $row[0] . "</td>";
		      echo "<td>" . $row[1] . "</td>";
		      echo "<td>" . $row[2] . "</td>";
		      echo "<td>" . $row[3] . "</td>";
		      echo "<td>" . $row[4] . "</td>";
		      echo "<td>$" . $row[5] . "</td>";
		      echo "</tr>";
		}
		echo "</table></div>
    </div>
    </div>";



		pg_free_result($result);
	}

?>

</body>
</html>
