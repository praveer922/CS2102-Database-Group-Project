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

<!-- PAGE HEADER -->
<div class="jumbotron text-center" style="background-image: url('https://static.pexels.com/photos/89775/dog-hovawart-black-pet-89775.jpeg'); background-position: 0px -200px;">
  <h1>Welcome to Pets Paradise.</h1>
  <p>Find a trusted pet sitter near you!</p>
  <br>
  <!-- SEARCH FORM -->


  <form class="search-form" action="/pet-portal.php#results">
    <div class="col-md-12 text-center">
      <input type="text" name="location" id="location" placeholder="Location">
      <select name="quicklocation" onchange="this.form.submit()" style="color:black;">
      <option value="" >-Quick Location Filter-</option>
      <option value="Bishan">Bishan</option>
      <option value="Toa Payoh">Toa Payoh</option>
  <option value="Kent Ridge">Kent Ridge</option>
  <option value="Jurong">Jurong</option>
  <option value="Woodlands">Woodlands</option>
  <option value="Pasir Ris">Pasir Ris</option>



      <input type="text" name="breed" id="breed" placeholder="Pet Breed">
          <input type="text" name="name" id="name" placeholder="Caretaker's name">
        </div>
        <div class="row">
          <input type="submit" name="formSubmit" value="Find a Sitter" class="btn btn-default btn-lg" id="input-submit">
        </div>
  </form>

<hr style="max-width:50%;">



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

?>
<div class="row text-center" style="padding-top:10px;">
  <p style="font-size:18px;">
<?php echo "The highest bid is currently <strong>$" . $highestBid . "</strong>, and the average bid is <strong>$" . number_format((float)$averageBid, 2, '.', '')."</strong>.";
?></p>
<p style="font-size:16px;">Join us and earn a quick buck now!</p>
<a href="/register.php" class="btn btn-default btn-lg sitter-btn">Become a Sitter</a>

</div>
</div>


<div class="row"  id='results'>
  <div class="col-md-10 col-md-offset-1">

<?php
if(isset($_GET['formSubmit']) ||  isset($_GET['quicklocation'])) {
  
    if ($_GET['quicklocation'] == 'Bishan')
    {
      echo "<h2>Showing Results in Bishan</h2>";
      $query = "SELECT userid, name, email, description FROM Bishan_caretakers";
    } elseif ($_GET['quicklocation'] == 'Toa Payoh')
    {
      echo "<h2>Showing Results in Toa Payoh</h2>";
       $query = "SELECT userid, name, email, description FROM Toa_payoh_caretakers";
    } elseif ($_GET['quicklocation'] == 'Kent Ridge')
    {
      echo "<h2>Showing Results in Kent Ridge</h2>";
      $query = "SELECT userid, name, email, description FROM Kent_ridge_caretakers";
    } elseif ($_GET['quicklocation'] == 'Jurong')
    {
      echo "<h2>Showing Results in Jurong</h2>";
      $query = "SELECT userid, name, email, description FROM Jurong_caretakers";
    } elseif ($_GET['quicklocation'] == 'Woodlands')
    {
      echo "<h2>Showing Results in Woodlands</h2>";
      $query = "SELECT userid, name, email, description FROM Woodlands_caretakers";
    } elseif ($_GET['quicklocation'] == 'Pasir Ris')
    {
      echo "<h2>Showing Results in Pasir Ris</h2>";
      $query = "SELECT userid, name, email, description FROM Pasir_ris_caretakers";
    } else {
      echo "<h2>Showing Results";
      if(isset($_GET['name']) && $_GET['name'] !== '' && isset($_GET['breed']) && $_GET['breed'] !== '') {
        echo " for " . $_GET['name']. " and " . $_GET['breed'];
      } elseif (isset($_GET['name']) && $_GET['name'] !== '') {
        echo " for " . $_GET['name'];
      } elseif (isset($_GET['breed']) && $_GET['breed'] !== '') {
        echo " for " . $_GET['breed'];
      }
      if(isset($_GET['location']) && $_GET['location'] !== '') {
        echo " in ". $_GET['location'];
      }
      echo "</h2>";
    $query = "SELECT userid, name, email, description FROM USERS WHERE ((name LIKE UPPER('%".$_GET['name']."%')OR UPPER (userid) LIKE UPPER('%".$_GET['name']."%')) AND UPPER(description) LIKE UPPER('%".$_GET['breed']."%') AND UPPER(address) LIKE UPPER('%".$_GET['location']."%')) AND (isA = 'caretaker' OR isA = 'both')";
  }
      /** Debug mode
      echo "<b>SQL:   </b>".$query."<br><br>";
      **/
      $result = pg_query($query) or die('Query failed: ' . pg_last_error());
      echo "<div class='panel panel-default'><table class='table table-striped table-hover table-bordered table-responsive'>
      <thead class='thead-inverse'>
      <tr>
      <th>Username</th>
      <th>Name</th>
      <th>Email</th>
      <th>Description</th>
      </tr>
      </thead><tbody>";
      while ($row = pg_fetch_row($result)){
        echo "<tr>";
        echo "<td><a href=profile.php?user=" . $row[0] . ">".$row[0]."</a></td>";
        echo "<td>" . $row[1] . "</td>";
        echo "<td>" . $row[2] . "</td>";
          echo "<td>" . $row[3] . "</td>";
        echo "</tr>";
      }
      echo "</tbody></table></div>";
      pg_free_result($result);

}
?>
</div>
</div>


<?php
pg_close($dbconn);
?>




<!-- FOOTER -->
<section id="contact">
  <div class="container">
      <div class="row">
          <div class="col-lg-8 col-lg-offset-2 text-center">
              <h2 class="section-heading">A CS2102 Project</h2>
              <hr class="primary">
          </div>
          <div class="col-lg-12 text-center">
              <i class="fa fa-envelope-o fa-3x sr-contact"></i>
              <p><a href="mailto:yongzhiyuan@u.nus.edu">Contact our group leader.</a></p>
          </div>
      </div>
  </div>
</section>

</body>
</html>
