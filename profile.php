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
<!--         <li><a href="#about">Login  <i class="fa fa-user"></i></a></li>
 -->      </ul>
    </div>
  </div>
 </nav>

<?php
$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=Prav33r1234")
    or die('Could not connect: ' . pg_last_error());    
?>

<?php

	if(isset($_GET['user'])) {
		echo "<h1>".$_GET['user']."'s received bids<hr>";

		$query = "SELECT petownerid, fromDate, toDate, price FROM Bids WHERE caretakerid='".$_GET['user']."'";

		$result = pg_query($query) or die('Query failed: ' . pg_last_error());

		echo "<table border=\"1\" >
			    <col width=\"25%\">
			    <col width=\"25%\">
			    <col width=\"20%\">
			    <col width=\"25%\">
			    <tr>
			    <th>Pet Owner</th>
			    <th>From</th>
			    <th>To</th>
			    <th>Price</th>
			    </tr>";

		while ($row = pg_fetch_row($result)){
		      echo "<tr>";
		      echo "<td>" . $row[0] . "</td>";
		      echo "<td>" . $row[1] . "</td>";
		      echo "<td>" . $row[2] . "</td>";
		      echo "<td>$" . $row[3] . "</td>";
		      echo "</tr>";
		    }
		echo "</table>";
		    
		pg_free_result($result);	    
	} 

?>

</body>
</html>