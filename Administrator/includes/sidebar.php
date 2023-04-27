  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4 bg-navy">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
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
          <li class="nav-item" >
            <a href="bloodbank.php" class="nav-link bg-info">
                <i class="nav-icon  fas fa-university"></i>
                <p>
                 Blood Bank
                </p>
            </a>
          </li>

          <li class="nav-item" <?php echo ($admin_details['a_role'] != "approval")? "style='display: none;';" : "" ; ?>>
            <a href="approval.php" class="nav-link bg-info">
                <i class="nav-icon  fas fa-inbox"></i>
                <p>
                 Approval Service
                </p>
            </a>
          </li>
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active bg-info" >
              <i class="nav-icon  fas fa-users"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="background-color: #003366;">
              <li class="nav-item">
                <a href="admin.php" class="nav-link">
                    <i class="fas fa-tv text-danger"></i>
                    <p>Administrators
                    </p>
              </a>
              </li>
              <li class="nav-item">
                <a href="bankofficer.php" class="nav-link">
                    <i class="fas fa-user text-danger"></i>
                    <p>Bank Officer
                    </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="donor.php" class="nav-link">
                  <i class="fas fa-hands text-danger"></i>
                  <p>Donors
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="patient.php" class="nav-link">
                  <i class="fas fa-stethoscope text-danger"></i>
                  <p>Patients
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="quickstats.php" class="nav-link">
              <i class="fas fa-chart-bar text-danger"></i>
              <p>Quick Statistics</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="blood.php" class="nav-link">
              <i class="fas fa-tint text-danger"></i>
              <p>Blood</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="transactions.php" class="nav-link">
              <i class=" fas fa-history text-danger"></i>
              <p>Transactions</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>