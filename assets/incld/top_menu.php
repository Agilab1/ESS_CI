<?php 
    include('../incld/autoload.php'); 
    date_default_timezone_set('Asia/Kolkata');
    $util = new Model\Util();
    if(isset($_POST['action'])) {
      $rqst = json_decode(json_encode($_POST));
      switch($rqst->action) {
        case 'setDFilter' :
          $_SESSION['from_dt'] = $rqst->from_dt;
          $_SESSION['upto_dt'] = $rqst->upto_dt;
          break;
      }
    }
    if(!isset($_SESSION['from_dt'])) {
      $_SESSION['from_dt'] = date('Y-m-d', strtotime('-15 days'));
      $_SESSION['upto_dt'] = date('Y-m-d');
    }
    $sess = json_decode(json_encode($_SESSION));
    $util->writeLog(json_encode($sess));
    if(isset($sess->plnt_id)) {
      $query = "select * from usr_role where role_nm = ?";
      $param = array($sess->role_nm);
      $roles  = $util->execQuery($query,$param,1);

      $query = "select * from obj_type where objty = ? ";
      $param = array($roles->aobj_ty);
      $objt  = $util->execQuery($query,$param,1);
      
      $query = "select objky,objnm from {$objt->table} where objky = ?";
      $param = array($sess->plnt_id);
      $plnt  = $util->execQuery($query,$param,1); 

    }
  
?>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo "{$sess->home_pg}"; ?>" class="nav-link">
            Home
        </a>
      </li>
      <li class="nav-item">
          <input type="hidden" class="form-control" name="plnt_id" id="plnt_id" value="<?php echo "{$plnt->objky}"; ?>">
          <input type="text"   class="form-control" name="plnt_nm" id="plnt_nm" value="<?php echo "{$plnt->objky} : {$plnt->objnm}"; ?>" readonly>
      </li>
    <li class="nav-item">
      <form method="post">
        <input type="date" class="form-control ml-3" name="from_dt" value="<?php echo $sess->from_dt; ?>">
    </li>
    <li class="nav-item">  
        <input type="date" class="form-control ml-3" name="upto_dt" value="<?php echo $sess->upto_dt; ?>">
    </li>
    <li class="nav-item">
        <button type="submit" class="form-control ml-3" name="action" value="setDFilter"><i class="fa fa-filter"></i></button>
        </form>
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
                <form method="POST" action="../admin/logout.php">
                    <button type="submit" name="logout" class="dropdown-item">Logout</button>
                </form>
              </div>
            </div>
        </li>
    </ul>
  </nav>
  <!-- /.navbar -->