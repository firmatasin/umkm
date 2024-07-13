<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Navbar Search -->

    <li class="nav-item">
      <span><?php echo $_SESSION["hakakses"]; ?> </span><i class="fas fa-user"></i>
    </li>
     &nbsp; | &nbsp;

    <li class="nav-item">
      <a class="nav-link" href="../admin/logout.php" role="button">
        <span>Log Out</span> <i class="fas fa-key"></i>
      </a>
    </li>

  </ul>





</nav>
<!-- /.navbar -->