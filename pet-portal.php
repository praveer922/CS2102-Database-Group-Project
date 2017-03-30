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

<table>
<tr> <td colspan="2" style="background-color:#FFA500;">2
<h1>Welcome to Pets Paradise - Singapore's No. 1 Pet Caring portal!</h1>
</td> </tr>

<?php
$dbconn = pg_connect("postgres://plwneqlk:-2HZ6tyCgzUN7vQTK8m0FBkUlQOZ6brW@babar.elephantsql.com:5432/plwneqlk")
    or die('Could not connect: ' . pg_last_error());

$query = "SELECT price FROM Bids WHERE price >= ALL(SELECT price FROM Bids)";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$row = pg_fetch_row($result);
$highestBid = $row[0];

$query = "SELECT AVG(price) FROM Bids";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$row = pg_fetch_row($result);
$averageBid = $row[0];

echo "<td>" . "The highest bid is currently $" . $highestBid . ", and the average bid is $" . number_format((float)$averageBid, 2, '.', '')  . "! Join us and earn a quick buck now!" . "</td>";
?>

<tr>
<td style="background-color:#eeeeee;">
<form>
        Caretaker's name: <input type="text" name="name" id="name">
        Pet breed: <input type="text" name="breed" id="breed">
        Location: <input type="text" name="location" id="location">
        Quick Location filter: <select name="quicklocation" onchange="this.form.submit()">
        <option value="">-Select Location-</option>
        <option value="Bishan">Bishan</option>
        <option value="Toa Payoh">Toa Payoh</option>
		<option value="Kent Ridge">Kent Ridge</option>
		<option value="Jurong">Jurong</option>
		<option value="Woodlands">Woodlands</option>
		<option value="Pasir Ris">Pasir Ris</option>
        <input type="submit" name="formSubmit" value="Search" >
</form>
<?php

if(isset($_GET['formSubmit'])) 
{
    $query = "SELECT userid, name, email, description FROM USERS WHERE (name LIKE UPPER('%".$_GET['name']."%') AND UPPER(description) LIKE UPPER('%".$_GET['breed']."%') AND UPPER(address) LIKE UPPER('%".$_GET['location']."%')) AND (isA = 'caretaker' OR isA = 'both')";
    echo "<b>SQL:   </b>".$query."<br><br>";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    echo "<table border=\"1\" >
    <col width=\"15%\">
    <col width=\"15%\">
    <col width=\"15%\">
    <col width=\"55%\">
    <tr>
    <th>Username</th>
    <th>Name</th>
    <th>Email</th>
    <th>Description</th>
    </tr>";

    while ($row = pg_fetch_row($result)){
      echo "<tr>";
      echo "<td><a href=profile.php?user=" . $row[0] . ">".$row[0]."</a></td>";
      echo "<td>" . $row[1] . "</td>";
      echo "<td>" . $row[2] . "</td>";
        echo "<td>" . $row[3] . "</td>";
      echo "</tr>";
    }
    echo "</table>";
    
    pg_free_result($result);

} elseif(isset($_GET['quicklocation']))
{
  if ($_GET['quicklocation'] == 'Bishan') 
  {
    $query = "SELECT * from Bishan_caretakers";
  } elseif ($_GET['quicklocation'] == 'Toa Payoh') 
  { 
     $query = "SELECT * from Toa_payoh_caretakers";
  } elseif ($_GET['quicklocation'] == 'Kent Ridge') 
  {
    $query = "SELECT * from Kent_ridge_caretakers";
  } elseif ($_GET['quicklocation'] == 'Jurong') 
  {
    $query = "SELECT * from Jurong_caretakers";
  } elseif ($_GET['quicklocation'] == 'Woodlands') 
  {
    $query = "SELECT * from Woodlands_caretakers";
  } elseif ($_GET['quicklocation'] == 'Pasir Ris') 
  {
    $query = "SELECT * from Pasir_ris_caretakers";
  } else 
  {
    $query = "SELECT userid, name, email, description FROM USERS WHERE (name LIKE UPPER('%".$_GET['name']."%') AND UPPER(description) LIKE UPPER('%".$_GET['breed']."%') AND UPPER(address) LIKE UPPER('%".$_GET['quicklocation']."%')) AND (isA = 'caretaker' OR isA = 'both')";
  }
    echo "<b>SQL:   </b>".$query."<br><br>";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    echo "<table border=\"1\" >
    <col width=\"15%\">
    <col width=\"15%\">
    <col width=\"15%\">
    <col width=\"55%\">
    <tr>
    <th>Username</th>
    <th>Name</th>
    <th>Email</th>
    <th>Description</th>
    </tr>";

    while ($row = pg_fetch_row($result)){
      echo "<tr>";
      echo "<td><a href=profile.php?user=" . $row[0] . ">".$row[0]."</a></td>";
      echo "<td>" . $row[1] . "</td>";
      echo "<td>" . $row[2] . "</td>";
        echo "<td>" . $row[3] . "</td>";
      echo "</tr>";
    }
    echo "</table>";
    
    pg_free_result($result);
  }
?>

</td> </tr>
<?php
pg_close($dbconn);
?>
<tr>
<td colspan="2" style="background-color:#FFA500; text-align:center;"> Copyright &#169; CS2102
</td> </tr>
</table>

</body>
</html>