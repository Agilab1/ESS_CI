<style>
  th, td {
    white-space: nowrap;
  }

  th {
    writing-mode: horizontal-tb !important;
    transform: rotate(0deg) !important;
  }

  table {
    table-layout: auto !important;
  }

  .card-header a.btn {
    margin-left: auto !important;
  }
</style>


<div class="card">

  <div class="card-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Holiday Details</h4>
    <a href="<?= base_url('Holiday/add'); ?>" class="btn btn-primary">
      <i class="fa fa-plus"></i> Add Holiday
    </a>
  </div>

  <div class="card-body">

    <!-- Flash message -->
    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
    <?php elseif ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
    <?php endif; ?>


    <?php
      $curMonth = $month ?? date('m');
      $curYear  = $year ?? date('Y');

      // prev month
      $prevM = $curMonth - 1;
      $prevY = $curYear;
      if ($prevM < 1) { $prevM = 12; $prevY--; }

      // next month
      $nextM = $curMonth + 1;
      $nextY = $curYear;
      if ($nextM > 12) { $nextM = 1; $nextY++; }
    ?>


    <!-- FILTER + NAVIGATION -->
    <div class="d-flex justify-content-between mb-3">

      <!-- FILTER -->
      <form method="get" action="<?= base_url('Holiday/list'); ?>" class="d-flex gap-2">

        <select name="month" class="form-control" style="max-width:140px;">
          <?php for ($m = 1; $m <= 12; $m++): ?>
            <option value="<?= $m ?>" <?= ($m == $curMonth) ? 'selected' : '' ?>>
              <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
            </option>
          <?php endfor; ?>
        </select>

        <select name="year" class="form-control" style="max-width:120px;">
          <?php for ($y = date('Y') - 2; $y <= date('Y') + 2; $y++): ?>
            <option value="<?= $y ?>" <?= ($y == $curYear) ? 'selected' : '' ?>><?= $y ?></option>
          <?php endfor; ?>
        </select>

        <button class="btn btn-outline-primary">Filter</button>
      </form>


      <!-- MONTH NAVIGATION -->
      <div>
        <a class="btn btn-outline-primary" 
           href="<?= base_url('Holiday/list/' . $prevM . '/' . $prevY) ?>">⬅ Previous Month</a>

        <a class="btn btn-outline-primary"
           href="<?= base_url('Holiday/list/' . $nextM . '/' . $nextY) ?>">Next Month ➜</a>
      </div>

    </div>



    <!-- HOLIDAY TABLE -->
    <div class="table-responsive">
      <table id="dtbl" class="table table-bordered table-striped">

        <thead class="btn-primary text-white">
          <tr>
            <th style="width:4vw;">#</th>
            <th>Holiday Date</th>
            <th>Day Category</th>
            <th>Description</th>
            <th style="width:7vw;" class="text-center">Action</th>
          </tr>
        </thead>

        <tbody>

          <?php if (!empty($holidays)): ?>
            <?php foreach ($holidays as $i => $h): ?>
            <tr>
              <td><?= $i + 1 ?></td>
              <td><?= $h->date_id ?></td>
              <td><?= $h->day_cat ?></td>
              <td><?= $h->day_txt ?></td>

              <td class="text-center" style="white-space:nowrap;">

                <a href="<?= base_url('Holiday/view/' . $h->date_id); ?>" class="mx-1">
                  <i class="fa fa-eye"></i>
                </a>

                <a href="<?= base_url('Holiday/edit/' . $h->date_id); ?>" class="mx-1">
                  <i class="fa fa-edit"></i>
                </a>

                <a href="<?= base_url('Holiday/delete/' . $h->date_id); ?>"
                   onclick="return confirm('Delete holiday on <?= $h->date_id ?> ?');"
                   class="mx-1">
                  <i class="fa fa-trash text-danger"></i>
                </a>

              </td>

            </tr>
            <?php endforeach; ?>

          <?php else: ?>
            <tr>
              <td colspan="5" class="text-center text-muted">
                No holidays found for this month.
              </td>
            </tr>
          <?php endif; ?>

        </tbody>

      </table>
    </div>

  </div>
</div>
