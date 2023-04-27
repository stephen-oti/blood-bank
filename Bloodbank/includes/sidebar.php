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
          <li class="nav-item">
            <a href="profile.php" class="nav-link bg-info">
                <i class="nav-icon  fas fa-th-large"></i>
                <p>
                 Profile
                </p>
            </a>
          </li>
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active bg-info" >
              <i class="nav-icon  fas fa-exchange-alt"></i>
              <p>
                Inter Bank
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="background-color: #003366;">
              <li class="nav-item">
                <a href="inter-request.php" class="nav-link">
                  <i class="fas fa-tint text-danger"></i>
                  <p>Request</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="inter-approve.php" class="nav-link">
                  <i class="fas fa-check text-danger"></i>
                  <p>Approve</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active bg-info" >
              <i class="nav-icon  fas fa-hand-holding"></i>
              <p>
                Requests
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="background-color: #003366;">
              <li class="nav-item">
                <a href="bank-appeals.php" class="nav-link">
                    <i class="fas fa-hand-holding text-danger"></i>
                    <p>Make Appeal
                    </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="appeals.php" class="nav-link">
                  <i class="fas fa-heartbeat text-danger"></i>
                  <p>Blood Appeals
                    <span class="right badge badge-danger">1</span>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="donations-req.php" class="nav-link">
                  <i class="fas fa-hand-holding-heart text-danger"></i>
                  <p>Donation Requests
                    <span class="right badge badge-danger">1</span>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pending-app.php" class="nav-link">
                  <i class="fas fa-check-circle text-danger"></i>
                  <p>Pending Appeals</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pending-don.php" class="nav-link">
                  <i class="fas fa-check-square text-danger"></i>
                  <p>Pending Donation</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active bg-info" >
              <i class="nav-icon  fas fa-clipboard-list"></i>
              <p>
                Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="background-color: #003366;">
              <li class="nav-item">
                <a href="blood.php" class="nav-link">
                  <i class="fas fa-tint text-danger"></i>
                  <p>Blood</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="donors.php" class="nav-link">
                  <i class="fas fa-users text-danger"></i>
                  <p>Donors</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="transactions.php" class="nav-link">
                  <i class=" fas fa-history text-danger"></i>
                  <p>Transactions</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>