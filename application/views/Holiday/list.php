<style>
/* FIX HEADER TEXT ROTATION / VERTICAL STACKING */
th { white-space: nowrap !important; writing-mode: horizontal-tb !important;
     transform: rotate(0deg) !important; text-orientation: mixed !important; }
td { white-space: nowrap; }
table { table-layout: auto !important; }
.card-header a.btn { margin-left: auto !important; /* push button to right */ }
</style>

<div class="card">
  <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
    <h4 class="mb-2 mb-md-0">Holiday Details</h4>
    <a href="<?= base_url('Holiday/add'); ?>" class="btn btn-primary mt-2 mt-md-0">
      <i class="fa fa-plus"></i> Add Holiday
    </a>
  </div>

  <div class="card-body">

    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
    <?php elseif ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
    <?php endif; ?>

    <!-- FILTER / NAV BUTTONS -->
    <div class="d-flex justify-content-between mb-3">
      <!-- left: optional filter form -->
      <form method="get" action="<?= base_url('Holiday/list'); ?>" class="d-flex gap-2">
        <select name="month" class="form-control" style="max-width:140px;">
          <?php for ($m = 1; $m <= 12; $m++): ?>
            <option value="<?= $m ?>" <?= ($m == ($month ?? date('m'))) ? 'selected' : '' ?>>
              <?= date('F', mktime(0,0,0,$m,1)) ?>
            </option>
          <?php endfor; ?>
        </select>

        <select name="year" class="form-control" style="max-width:120px;">
          <?php for ($y = date('Y') - 2; $y <= date('Y') + 2; $y++): ?>
            <option value="<?= $y ?>" <?= ($y == ($year ?? date('Y'))) ? 'selected' : '' ?>><?= $y ?></option>
          <?php endfor; ?>
        </select>

        <button class="btn btn-primary">Filter</button>

      </form>

      <!-- right: prev/next -->
      <div>
        <?php
          $curMonth = isset($month) ? (int)$month : (int)date('m');
          $curYear  = isset($year)  ? (int)$year  : (int)date('Y');

          $prevM = $curMonth - 1; $prevY = $curYear;
          if ($prevM < 1) { $prevM = 12; $prevY--; }

          $nextM = $curMonth + 1; $nextY = $curYear;
          if ($nextM > 12) { $nextM = 1; $nextY++; }
        ?>
        <a class="btn btn-outline-primary" href="<?= base_url("Holiday/list/$prevM/$prevY") ?>">⬅ Previous Month</a>
        <a class="btn btn-outline-primary" href="<?= base_url("Holiday/list/$nextM/$nextY") ?>">Next Month ➜</a>
      </div>
    </div>

    <!-- TABLE -->
    <div class="table-responsive">
      <table id="holidayTable" class="table table-bordered table-striped align-middle" style="font-size:14px;">
        <thead class="btn-primary text-white">
          <tr>
            <th style="width: 50px">#</th>
            <th>Holiday Date</th>
            <th>Day Category</th>
            <th>Description</th>
            <th class="text-center" colspan="3">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php if (!empty($holidays)): ?>
            <?php foreach ($holidays as $index => $h): ?>
              <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $h->date_id ?></td>
                <td><?= $h->day_cat ?></td>
                <td><?= $h->day_txt ?></td>

                <td class="text-center">
                  <a href="<?= base_url('Holiday/view/' . $h->date_id); ?>"><i class="fa fa-eye"></i></a>
                </td>
                <td class="text-center">
                  <a href="<?= base_url('Holiday/edit/' . $h->date_id); ?>"><i class="fa fa-edit"></i></a>
                </td>
                <td class="text-center">
                  <a href="<?= base_url('Holiday/delete/' . $h->date_id); ?>"
                    onclick="return confirm('Delete holiday on date: <?= $h->date_id ?> ?');">
                    <i class="fa fa-trash text-danger"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <!-- total columns = 1(#) + 1(date) + 1(cat) + 1(desc) + 3(actions) = 7 -->
            <tr>
              <td colspan="7" class="text-center text-muted">No holidays found for this month.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- PAGINATION (MUST BE OUTSIDE TABLE) -->
    <?php if (!empty($pagination)): ?>
      <div class="d-flex justify-content-center mt-3"><?= $pagination ?></div>
    <?php endif; ?>

  </div>
</div>
