<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home.php">Pets Paradise <i class="fa fa-paw fa-fw"></i></a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a href="pet-portal.php">Search</a></li>
      </ul>
      <ul class="nav navbar-nav">
        <li><a href="home.php#contact">Contact</a></li>
      </ul>

      <ul class="nav navbar-nav">
        <li><a href="profile.php">Your Profile</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li><a>You are logged in as <?php echo $_SESSION['login_user']; ?>.</a></li>
         <li><a href="logout.php">Logout  <i class="fa fa-user"></i></a></li>
      </ul>
    </div>
  </div>
 </nav>
