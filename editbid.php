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

   <body>
   <div class="container">
  <?php

  if(isset($_GET['submitedit'])) /** PLACES BID if edit bid button is pressed **/
{
  $petownerid = $_GET['petownerid'];
  $caretakerid = $_GET['caretakerid'];
  $petid = $_GET['petid'];
  $startDate = $_GET['startDate'];
  $endDate = $_GET['endDate'];
  $price = $_GET['price'];

  echo $startDate . " " . $endDate . " " . $price . " " . $petownerid . " " . $caretakerid . " " . $petid;

  $query = "UPDATE Bids SET fromDate='$startDate', toDate='$endDate', price='$price' 
  WHERE petownerid='$petownerid' AND caretakerid='$caretakerid' AND petid='$petid'";

  $result = pg_query($query);
    if (!$result) {
      $errormessage = pg_last_error();
      echo "<script> alert('You have failed to update your bid')</script>";
    } else {
      echo "<script> alert('You have successfully updated your bid.');
      window.location.href='profile.php'; </script>";
      pg_close();
    }
}

  $petownerid = $_GET['petownerid'];
  $caretakerid = $_GET['caretakerid'];
  $petid = $_GET['petid'];
  echo $petownerid . " " . $caretakerid . " " . $petid;
  echo "<h2>Edit your bid</h2><hr>

  <div class='panel panel-default'>

  <div class='panel-body'>";

  echo"
  <form action='editbid.php' method=\"get\">
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
    <input type=\"submit\" name=\"submitedit\" value=\"Edit bid\" class='btn btn-default btn-md'>
    <input type=\"text\" name=\"user\" value=".$_SESSION['login_user']." hidden>
    <input type=\"text\" name=\"petownerid\" value=".$_GET['petownerid']." hidden>
    <input type=\"text\" name=\"caretakerid\" value=".$_GET['caretakerid']." hidden>
    <input type=\"text\" name=\"petid\" value=".$_GET['petid']." hidden>
  </form>
  </div>
  </div>";


  ?>

</div>
</body>
</html>
