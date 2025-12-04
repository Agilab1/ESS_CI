<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Admin Dashboard</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <!-- <a href="<?= base_url('user/list'); ?>"> <button class="btn btn-primary float-right"> UserList</button></a> -->
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Admin</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">

        </div>
      </div>
      <div class="row">
        <div class="col-lg-2 col-6">
          <div class="small-box bg-secondary">
            <div class="inner">
              <h3><?= $counts->cnt1 ?></h3>

              <p>Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="<?= base_url('user/list') ?>" class="small-box-footer">More Info <i class="fas fa-arrow-circle-right"></i></a>
            <!-- <a href="list_users.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <div class="col-lg-2 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?= $counts->cnt2 ?></h3>

              <p>User Roles</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="<?= base_url('role/role_dash'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-2 col-6">
          <div class="small-box bg-primary">
            <div class="inner">
              <h3><?= $counts->cnt3 ?></h3>

              <p>Staff</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?= base_url('staff/list'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>


            <!-- <a href="list_staff" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <div class="col-lg-2 col-6">
          <div class="small-box bg-warning ">
            <div class="inner">
              <h3><?= $counts->cnt4 ?></h3>

              <p>Holiday</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="<?= base_url('holiday/list'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-2 col-6">
          <div class="small-box bg-success ">
            <div class="inner">
              <h3>0</h3>

              <p>Assets</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="list_plants.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-2 col-6">
          <div class="small-box bg-dark">
            <div class="inner">
              <h3>0</h3>

              <p>Locations</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="list_strloc.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
    </div>
  </section>