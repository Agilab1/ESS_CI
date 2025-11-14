 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        
            Home
        </a>
</li>
    <li class="nav-item d-none d-sm-inline-block">
    </li>
    
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" name="dropd" type="button" data-toggle="dropdown" aria-expanded="false">
                <?php if(isset($_SESSION['user_nm'])) {
                        echo $_SESSION['user_nm'];
                      } else {
                          echo 'Not Logged In';
                      }
                ?>
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="#">User Profile</a>
                <a class="dropdown-item" href="#">Messages</a>
                <form method="POST" action="<?= base_url('login/logout') ?>">
                    <button type="submit" name="logout" class="dropdown-item">Logout</button>
                </form>
              </div>
            </div>
        </li>
    </ul>
  </nav>
  <!-- /.navbar -->