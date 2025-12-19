<div class="container py-4">

    <div class="card shadow-lg rounded-4 border-0">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white rounded-top-4">
            <h5 class="mb-0">
                <i class="bi bi-building"></i> Staff Asset Verification
            </h5>
        </div>

        <div class="card-body">

            <!-- SITE DETAILS (LIKE IMAGE) -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Site ID</label>
                    <input type="text" class="form-control" value="<?= $site->site_id ?>" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Site No</label>
                    <input type="text" class="form-control" value="<?= $site->site_no ?>" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Site Name</label>
                    <input type="text" class="form-control" value="<?= $site->site_name ?>" readonly>
                </div>
            </div>

            <!-- STAFF + ASSETS TABLE -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead style="background:#cfe5ff;">
                        <tr class="text-center">
                            <th width="5%">#</th>
                            <th width="15%">Staff ID</th>
                            <th width="25%">Staff Name</th>
                            <th>Assigned Assets</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($staff_assets)): ?>
                            <?php foreach ($staff_assets as $i => $row): ?>
                                <tr>
                                    <td class="text-center"><?= $i + 1 ?></td>
                                    <td><?= $row->staff_id ?></td>
                                    <td><?= $row->emp_name ?></td>
                                    <td>
                                        <?= !empty($row->assets) ? $row->assets : '<span class="text-muted">-</span>' ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    No staff assigned to assets
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- BACK BUTTON -->
            <div class="text-center mt-4">
                <a href="<?= base_url('Location/list'); ?>" class="btn btn-secondary px-4">
                    ← Back to Location List
                </a>
            </div>

        </div>
    </div>

</div>
