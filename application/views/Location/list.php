<style>
  th, td { white-space: nowrap; }
  th { writing-mode: horizontal-tb !important; transform: rotate(0deg) !important; }
  table { table-layout: auto !important; }
  .card-header a.btn { margin-left: auto !important; }
</style>

<div class="card">

  <div class="card-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Location Details</h4>

    <a href="<?= base_url('Location/add'); ?>" class="btn btn-primary">
      <i class="fa fa-plus"></i> Add Location
    </a>
  </div>

  <div class="card-body">

    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
    <?php elseif ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
    <?php endif; ?>


    <!-- LOCATION TABLE -->
    <div class="table-responsive">
      <table id="dtbl" class="table table-bordered table-striped">

        <thead class="btn-primary text-white">
          <tr>
            <th style="width:4vw;">#</th>
            <th>Site Id</th>
            <th>Site No</th>
            <th>Site Name</th>
            <th>Asset List</th>
          
            <th style="width:7vw;" class="text-center">Action</th>
          </tr>
        </thead>

        <tbody>

        <?php if (!empty($locations)): ?>
          <?php foreach ($locations as $i => $loc): ?>
            <tr>
              <td><?= $i + 1 ?></td>
              <td><?= $loc->site_id ?></td>
              <td><?= $loc->site_no ?></td>
              <td><?= $loc->site_name ?></td>

              <!-- Asset List + QR -->
              <td>
                <?= $loc->asset_list_name ?? 'Assets' ?>
                &nbsp;
                <a href="<?= base_url('Location/asset_list/' . $loc->site_id ) ?>" title="Asset QR">
                  <i class="fas fa-qrcode"></i>
                </a>
              </td>

              <!-- Staff List + QR -->
              <td>
                <?= $loc->staff_list_name ?? 'Staffs' ?>
                &nbsp;
                <a href="<?= base_url('Location/staff_list/' . $loc->site_id) ?>" title="Staff QR">
                  <i class="fas fa-qrcode text-primary"></i>
                </a>
              </td>

              <td class="text-center" style="white-space:nowrap;">

                <a href="<?= base_url('Location/view/' . $loc->site_id); ?>" class="mx-1">
                  <i class="fa fa-eye"></i>
                </a>

                 <a href="<?= base_url('Location/edit/' . $loc->site_id); ?>" class="mx-1">
                  <i class="fa fa-edit"></i>
                </a>
              

                <a href="<?= base_url('Location/delete/' . $loc->site_id); ?>"
                  onclick="return confirm('Delete Location: <?= $loc->site_name ?> ?');"
                  class="mx-1">
                  <i class="fa fa-trash text-danger"></i>
                </a>

              </td>
            </tr>
          <?php endforeach; ?>

        <?php else: ?>
          <tr>
            <td colspan="5" class="text-center text-muted">No locations found.</td>
          </tr>
        <?php endif; ?>

        </tbody>

      </table>
    </div>

  </div>
</div>
