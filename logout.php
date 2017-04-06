<?php
session_start();
session_destroy();
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
    include_once("navbarloggedout.php");
  ?>
<div class="container">
  <div class="row">
    <div class="col-md-10">

  		<h2>You have logged out.</h2>
    </div>
  </div>
</div>

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
