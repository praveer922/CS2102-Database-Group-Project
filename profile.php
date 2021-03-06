<?php
session_start();
?>

<html>
<head>
  <title>Pets Paradise</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

  <link rel="stylesheet" type="text/css" href="app.css">
</head>
<body>

  <!--NAVBAR -->
  <?php
  if(isset($_SESSION['login_user'])) {
    include_once("navbarloggedin.php");
  } else {
    include_once("navbarloggedout.php");
  }
  ?>

<?php
$dbconn = pg_connect("postgres://plwneqlk:-2HZ6tyCgzUN7vQTK8m0FBkUlQOZ6brW@babar.elephantsql.com:5432/plwneqlk")
    or die('Could not connect: ' . pg_last_error());
?>

<?php

if(isset($_GET['submit'])) /** PLACES BID if bid button is pressed **/
{

  $query = "INSERT INTO Bids VALUES ('".$_SESSION['login_user']."', '".$_GET['user']."', '".$_GET['PetID']."', '".$_GET['startDate']."', '"
  .$_GET['endDate']."', '".$_GET['price']."');";

  $result = pg_query($query);
    if (!$result) {
      $errormessage = pg_last_error();
      echo "<script> alert('You have failed to bid');
      window.location.href='profile.php'; </script>";
      pg_close();
      exit();
    }
    echo "<script> alert('You have successfully bidded');
    window.location.href='profile.php'; </script>";
    pg_close();

}

if(!isset($_GET['user'])) {  /** SET get user to session user if get is not set **/
  if(isset($_SESSION['login_user'])) {
    $_GET['user'] = $_SESSION['login_user'];
  } else {
    echo "<div class='container'><h3>Please <a href='/login.php'>log in</a> first.</h3></div>";
    die();
  }
}

    $userid = $_GET['user'];
    $queryOne = "SELECT u.name, u.email, u.address, u.description FROM Users u WHERE userid='$userid'";
    $resultOne = pg_query($queryOne) or die('Query failed: ' . pg_last_error());
    $rowOne = pg_fetch_row($resultOne);

    echo "

    <div class='row'>
    <div class='col-md-5 col-md-offset-1'>
    <h2>". $userid . "'s Profile</h2>
    <div class='panel panel-default'>
  <div class='panel-heading'>User Information</div>
  <div class='panel-body'>
  <p><strong>Name:</strong> ". $rowOne[0] ."</p>
  <p><strong>Email:</strong> ". $rowOne[1] ."</p>
  <p><strong>Address:</strong> ". $rowOne[2] ."</p>
  <p><strong>Description:</strong> ". $rowOne[3] ."</p>";


  echo "<p><strong>Pets:</strong></p>";
  $queryTwo = "SELECT p.petid, p.name, p.age, p.breed, p.gender, p.description FROM Pets p WHERE p.owner='$userid'";
  $resultTwo = pg_query($queryTwo) or die('Query failed: ' . pg_last_error());

  echo "<div class='panel panel-default'><table class='table table-striped table-hover table-bordered table-responsive'>
          <tr>
          <th>Pet ID</th>
          <th>Pet Name</th>
          <th>Pet Age</th>
          <th>Pet Breed</th>
          <th>Pet Gender</th>
          <th>Pet Description</th>
          </tr>";
  while ($rowTwo = pg_fetch_row($resultTwo)){
    echo "<tr>";
    echo "<td>" . $rowTwo[0] . "</td>";
    echo "<td>" . $rowTwo[1] . "</td>";
    echo "<td>" . $rowTwo[2] . "</td>";
    echo "<td>" . $rowTwo[3] . "</td>";
    echo "<td>" . $rowTwo[4] . "</td>";
    echo "<td>" . $rowTwo[5] . "</td>";
    echo "</tr>";
  }
  echo "</table></div>";

  if($_GET['user'] == $_SESSION['login_user'])
  {
  echo "
  <p><a href='createPet.php' class='btn btn-default btn-md'>Create a new pet</a></p>";
  }


  echo "</div></div>";

  /**HIGHEST BID **/
  $today = date("Y-m-d");
  $query = "SELECT price FROM Bids WHERE fromDate>='$today' AND caretakerid='$userid' AND price >= ALL(SELECT price FROM Bids WHERE fromDate>='$today' AND caretakerid='$userid')";

  $result = pg_query($query) or die('Query failed: ' . pg_last_error());
  if (pg_num_rows($result) > 0) {
    $row = pg_fetch_row($result);
    $highestbid = $row[0];
    if ($_GET['user'] != $_SESSION['login_user']) { //not looking at your own profile
    echo "<h2>Place Bid</h2><hr><h4>The highest bid that " . $_GET['user'] . " has from today onwards is <strong>$" . $highestbid . "</strong>.</h4>
    <h4>Bid a higher price to secure your petkeeper!</h4><hr>";
    }
  }

  /** BIDDING FORM **/
    if($_GET['user'] != $_SESSION['login_user'])
    {

    echo"
    <div class='panel panel-default'>
    <div class='panel-heading'>Place your bid for ". $userid . " to take care of your pet!</div>
    <div class='panel-body'>";

    echo"
    <form action=\"profile.php\" method=\"get\">
      Your pet's PetID and Name: <select name=\"PetID\" class='form-control' style='max-width:40%; margin-bottom:12px;'> <option class='form-control' value=\"\">--Your pet's ID and Name--</option>";

      $query = "SELECT petid, name FROM Pets WHERE owner='".$_SESSION['login_user']."'";
      $result = pg_query($query) or die('Query failed: ' . pg_last_error());
      while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){
        echo "<option class='form-control' value=\"" . $line["petid"] . "\">" . $line["petid"] . " " . $line["name"] . "</option></select>";
      }

    echo"
      Start date: <input class='form-control' style='max-width:50%; margin-bottom:8px;' type=\"date\" name=\"startDate\" id=\"startDate\" required>
      End date: <input class='form-control' style='max-width:50%;margin-bottom:8px;' type=\"date\" name=\"endDate\" id=\"endDate\" required>
      Bid price: <input class='form-control' style='max-width:50%;margin-bottom:8px;' type=\"number\" name=\"price\" id=\"price\" step=0.01 min=0 required >
      <input type=\"submit\" name=\"submit\" value=\"Place bid\" class='btn btn-default btn-md'>
      <input type=\"text\" name=\"user\" value=".$_GET['user']." hidden>
    </form>
    </div>
    </div></div>";
  } else {  /** LOOKING AT YOUR OWN PROFILE **/

    /** DELETE BID if delete button pressed **/
    if(isset($_GET['removebid'])) {
      $petownderid = $_GET['petownerid'];
      $caretakerid = $_GET['caretakerid'];
      $petid = $_GET['petid'];
      $query = "DELETE FROM Bids b WHERE b.petownerid='$petownderid' AND b.caretakerid='$caretakerid' AND b.petid = $petid";

      $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    }

    /** TABLE OF BIDS PLACED **/
    echo "
    <h2>Your placed bids</h2>";

    $query = "SELECT b.caretakerid, p.name, b.fromDate, b.toDate, b.price, b.petownerid, b.petid FROM Bids b INNER JOIN Pets p ON b.petid = p.petid WHERE b.petownerid='$userid'";

    $result = pg_query($query) or die('Query failed: ' . pg_last_error());

    echo "<div class='panel panel-default'><table class='table table-striped table-hover table-bordered table-responsive'>
          <tr>
          <th>Caretaker</th>
          <th>Pet Name</th>
          <th>From</th>
          <th>To</th>
          <th>Price</th>
          <th>Actions</th>
          </tr>";
    while ($row = pg_fetch_row($result)){
          echo "<tr>";
          echo "<td><a href='/profile.php?user=" . $row[0] ."'>" . $row[0] . "</a></td>";
          echo "<td>" . $row[1] . "</td>";
          echo "<td>" . $row[2] . "</td>";
          echo "<td>" . $row[3] . "</td>";
          echo "<td>" . $row[4] . "</td>";
          echo "<td><a href='/editbid.php?petownerid=" . $row[5] . "&caretakerid=" . $row[0] . "&petid=" . $row[6] . "' class='btn btn-default btn-sm'>Edit</a>  <a href='/profile.php?removebid=true&petownerid=" . $row[5] . "&caretakerid=" . $row[0] . "&petid=" . $row[6] . "' class='btn btn-default btn-sm'>Delete</a></td>";
          echo "</tr>";
    }
    echo "</table></div>";

    echo "</div>";



    pg_free_result($result);
  }


    /** TABLE OF RECEIVED BIDS **/
		echo "<div class='col-md-5'>
    <h2>Received bids</h2>";

		$query = "SELECT b.petownerid, p.name, p.breed, b.fromDate, b.toDate, b.price FROM Bids b INNER JOIN Pets p ON p.owner = b.petownerid AND b.petid = p.petid WHERE b.caretakerid='$userid'";

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
		      echo "<td><a href='/profile.php?user=" . $row[0] ."'>" . $row[0] . "</a></td>";
		      echo "<td>" . $row[1] . "</td>";
		      echo "<td>" . $row[2] . "</td>";
		      echo "<td>" . $row[3] . "</td>";
		      echo "<td>" . $row[4] . "</td>";
		      echo "<td>$" . $row[5] . "</td>";
		      echo "</tr>";
		}
		echo "</table></div>";
    if($_GET['user'] == $_SESSION['login_user']) {//looking at your own profile
      echo "<h4>The highest bid placed for you from today onwards is <strong>$" . $highestbid . "</strong>.</h4>";
    }
    echo "</div>
    </div>";



		pg_free_result($result);

?>

</body>
</html>
