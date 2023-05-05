  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-info navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav" >
      <li class="nav-item">
        <a class="nav-link text-white"  data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../index.php" class="nav-link text-white">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
          <div class="user-panel  d-flex">
            <div class="info">
                <a href="#" class="d-block text-white"><?php echo strtoupper($patient_details['lname']).", ".$patient_details['fname'];?></a>
              </div>
            <div class="image">
              <img src="../dist/img/avatar-patient.png" class="img-circle" alt="User Image">
            </div>
            
          </div>

      </li>
      <li class="nav-item">
        <a class="nav-link text-white" data-toggle="modal" data-target="#modal-logout" href="#" role="button"><i
            class="fas fa-power-off"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->