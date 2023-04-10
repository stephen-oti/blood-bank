  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4 bg-navy">
    <!-- Brand Logo -->
    <a href="index.html" class="brand-link">
      <img src="../dist/img/Obbs logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-heavy text-glow"><b>OBBS</b></span>
    </a>


    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="index.php" class="nav-link active bg-info">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                 Dashboard
                </p>
            </a>
          </li>
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active bg-info" >
              <i class="nav-icon fas fa-hand-holding-heart"></i>
              <p>
                Appeal
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="background-color: #003366;">
              <li class="nav-item">
                <a href="appeals.php" class="nav-link">
                  <i class="fas fa-hands-helping text-danger"></i>
                  <p>Make Appeals
                    <span class="right badge badge-danger">1</span>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="history.php" class="nav-link">
                  <i class="fas fa-history text-danger"></i>
                  <p>History</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- <li class="nav-item ">
            <a href="emergency.html" class="nav-link active bg-danger emergencybtn">
                <i class="nav-icon fas fa-ambulance "></i>
                <p>Emergency</p>
            </a>
        </li> -->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>