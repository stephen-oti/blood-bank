  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-info navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav" >
      <li class="nav-item">
        <a class="nav-link text-white"  data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    
    <!-- Brand logo -->
    <a href="profile.php" class="text-white text-bold custom-font ml-3">
    <?php echo strtoupper($bank_details['bank_name']); ?>
    </a>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
          <div class="user-panel  d-flex">
            <div class="info">
                <a href="#" class="d-block text-white"><?php echo strtoupper($officer_details['lname']).", ".$officer_details['fname'];?></a>
              </div>
            <div class="image">
              <img src="../dist/img/officer-avatar.png" class="img-circle" alt="User Image">
            </div>
            
          </div>

      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-cogs text-white"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <!-- Widget: user widget style 1 -->
            <div class=" card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-navy">
                <h3 class="widget-user-username"><?php echo strtoupper($officer_details['lname']).", ".$officer_details['fname'];?></h3>
                <h5 class="widget-user-desc">Bank Officer</h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle elevation-2" src="../dist/img/officer-avatar.png" alt="User Avatar">
              </div>
              <div class="card-footer">
                <div class="row">

                  <div class="col-sm-6 border-right">
                    <div class="description-block">
                      <a href="#" class="btn btn-success update-officer" data-toggle="modal" data-target="#modal-acc" data-id='<?php echo $officer_details['id']; ?>'><i class="fas fa-cog"></i> Update</a>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-6">
                    <div class="description-block">
                      <a href="logout.php" class="btn btn-danger"><i class="fas fa-sign-out-alt" data></i> Logout</a>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.widget-user -->
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->