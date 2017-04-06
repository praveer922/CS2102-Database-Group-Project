<?php
session_start();
?>

<!DOCTYPE html>
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

    <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img class="first-slide" src="https://images.unsplash.com/photo-1415369629372-26f2fe60c467?dpr=2&fit=crop&fm=jpg&h=775&q=50&w=1450" alt="First slide">
          <div class="container">
            <div class="carousel-caption">
                <div id="content">
                    <h1>Pets Paradise</h1>
                    <h3>The Number One Pet Caring Portal</h3>
                    <hr>
                    <button class="btn btn-default btn-lg" onclick="location.href = 'pet-portal.php'"><i class="fa fa-paw fa-fw"></i> Get Started!</button>
                </div>
            </div>
          </div>
        </div>
        <div class="item">
          <img class="second-slide" src="https://images.unsplash.com/photo-1452857297128-d9c29adba80b?dpr=1&auto=format&fit=crop&w=1500&h=1125&q=80&cs=tinysrgb&crop=" alt="Second slide">
          <div class="container">
            <div class="carousel-caption">
              <div id="content">
                    <h1>Are you a Pet Lover?</h1>
                    <h3>There are tons of cute pets in our portal!</h3>
                    <hr>
                    <button class="btn btn-default btn-lg" onclick="location.href = 'pet-portal.php'"><i class="fa fa-paw fa-fw"></i> Get Started!</button>
                </div>
            </div>
          </div>
        </div>
        <div class="item">
          <img class="third-slide" src="https://images.unsplash.com/photo-1475361723055-41c91bbff76f?dpr=1&auto=format&fit=crop&w=1500&h=1000&q=80&cs=tinysrgb&crop=" alt="Third slide">
          <div class="container">
            <div class="carousel-caption">
              <div id="content">
                    <h1>Register Now!</h1>
                    <h3>Find a pet today!</h3>
                    <hr>
                    <button class="btn btn-default btn-lg" onclick="location.href = 'pet-portal.php'"><i class="fa fa-paw fa-fw"></i> Get Started!</button>
                </div>
            </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div><!-- /.carousel -->




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

    </div><!-- /.container -->

     <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.js"></script>
 <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</body>
</html>
