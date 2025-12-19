<style>
/* Space between Staff update button and Site update button */
.card-header .d-flex.align-items-center {
    gap: 12px; /* adjust spacing if needed */
}
</style>


<?php
$isView = ($action === 'view');
$disabled = $isView ? 'disabled' : '';
?>

<body class="p-4" style="background:#f5f7fa;">
<div class="d-flex justify-content-center align-items-center" style="min-height:100vh;">
<div class="container" style="width:75%; max-width:900px;">

<div class="card shadow-lg border-0 rounded-4 overflow-hidden">

   <!-- ================= HEADER ================= -->
<div class="card-header py-3 d-flex justify-content-between align-items-center">
    <h4 class="m-0"><?= ucfirst($action) ?> Asset</h4>

    <?php if ($isView): ?>
    <div class="d-flex align-items-center">

        <!-- UPDATE STAFF -->
        <form method="post"
              action="<?= base_url('Asset/updateStaff'); ?>"
              class="d-flex align-items-center me-3">

            <input type="hidden" name="asset_id" value="<?= $asset->asset_id ?>">

            <select name="staff_id"
                    id="staffSelect"
                    class="form-control form-control-sm"
                    readonly>
                <?php foreach ($staffs as $s): ?>
                    <option value="<?= $s->staff_id ?>"
                        <?= ($loginUser->staff_id == $s->staff_id) ? 'selected' : '' ?>>
                        <?= $s->staff_id ?> - <?= $s->emp_name ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="button"
                    id="staffBtn"
                    class="btn btn-primary btn-sm ms-2">
                <i class="fas fa-user-edit"></i>
            </button>
        </form>

        <!-- UPDATE SITE -->
        <form method="post"
              action="<?= base_url('Asset/updateSite'); ?>"
              class="d-flex align-items-center">

            <input type="hidden" name="asset_id" value="<?= $asset->asset_id ?>">

            <select name="site_no"
                    id="siteSelect"
                    class="form-control form-control-sm"
                    disabled
                    required>
                <?php foreach ($sites as $s): ?>
                    <option value="<?= $s->site_no ?>"
                        <?= ($loginUser->site_no == $s->site_no) ? 'selected' : '' ?>>
                        <?= $s->site_no ?> - <?= $s->site_name ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="button"
                    id="siteBtn"
                    class="btn btn-primary btn-sm ms-2">
                <i class="fas fa-map-marker-alt"></i>
            </button>
        </form>

    </div>
    <?php endif; ?>
</div>


    <!-- ================= BODY ================= -->
    <div class="card-body p-4">

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
        <?php endif; ?>

        <?php if (!$isView): ?>
        <form method="post" action="<?= base_url('Asset/save'); ?>" autocomplete="off">
            <input type="hidden" name="action" value="<?= $action ?>">
        <?php endif; ?>

        <table class="table table-bordered">

            <!-- ASSET ID / NUMBER -->
            <tr>
                <td>
                    <label class="fw-semibold">Asset ID</label>
                    <?php if ($action === 'add'): ?>
                        <input type="text" name="asset_id" class="form-control" required>
                    <?php else: ?>
                        <input type="text" class="form-control" value="<?= $asset->asset_id ?>" readonly>
                    <?php endif; ?>
                </td>
                <td>
                    <label class="fw-semibold">Asset Number</label>
                    <input type="text" name="asset_no" class="form-control"
                           value="<?= $asset->asset_no ?>" <?= $disabled ?> required>
                </td>
            </tr>

            <!-- NAME / VALUE -->
            <tr>
                <td>
                    <label class="fw-semibold">Asset Name</label>
                    <input type="text" name="asset_name" class="form-control"
                           value="<?= $asset->asset_name ?>" <?= $disabled ?> required>
                </td>
                <td>
                    <label class="fw-semibold">Net Value</label>
                    <input type="number" name="net_value" class="form-control"
                           value="<?= $asset->net_value ?>" <?= $disabled ?>>
                </td>
            </tr>

            <!-- STATUS / CATEGORY -->
            <tr>
                <td>
                    <label class="fw-semibold">Status</label>
                    <select name="status" class="form-control" <?= $disabled ?>>
                        <option value="1" <?= $asset->status == 1 ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= $asset->status == 0 ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </td>
                <td>
                    <label class="fw-semibold">Category</label>
                    <select name="cat_id" class="form-control" <?= $disabled ?>>
                        <?php foreach ($categories as $c): ?>
                            <option value="<?= $c->cat_id ?>"
                                <?= $asset->cat_id == $c->cat_id ? 'selected' : '' ?>>
                                <?= $c->cat_no ?> - <?= $c->cat_name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>

            <!-- STAFF / SITE -->
            <tr>
                <td>
                    <label class="fw-semibold">Staff</label>
                    <?php if ($isView): ?>
                        <input type="text" class="form-control" value="<?= $asset->emp_name ?>" readonly>
                    <?php else: ?>
                        <select name="staff_id" class="form-control" required>
                            <option value="">Select Staff</option>
                            <?php foreach ($staffs as $s): ?>
                                <option value="<?= $s->staff_id ?>"
                                    <?= $asset->staff_id == $s->staff_id ? 'selected' : '' ?>>
                                    <?= $s->emp_name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </td>

                <td>
                    <label class="fw-semibold">Site</label>
                    <?php if ($isView): ?>
                        <input type="text" class="form-control"
                               value="<?= $asset->site_no ?> - <?= $asset->site_name ?>" readonly>
                    <?php else: ?>
                        <select name="site_id" class="form-control" required>
                            <option value="">Select Site</option>
                            <?php foreach ($sites as $s): ?>
                                <option value="<?= $s->site_id ?>"
                                    <?= $asset->site_id == $s->site_id ? 'selected' : '' ?>>
                                    <?= $s->site_no ?> - <?= $s->site_name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </td>
            </tr>

            <!-- BUTTONS -->
            <tr>
                <td colspan="2" class="text-center pt-3">

                    <?php if (!$isView): ?>
                        <button type="submit" class="btn btn-primary me-3">
                            <i class="fas fa-save me-1"></i> Save
                        </button>
                    <?php endif; ?>

                    <a href="<?= base_url('Asset/list'); ?>" class="btn btn-secondary">
                        Back
                    </a>

                </td>
            </tr>

        </table>

        <?php if (!$isView): ?>
        </form>
        <?php endif; ?>

    </div>
</div>

</div>
</div>
</body>
<script>
document.getElementById('staffBtn').addEventListener('click', function () {
    const select = document.getElementById('staffSelect');

    if (select.disabled) {
        select.disabled = false;   // enable edit
        select.focus();
    } else {
        select.form.submit();      // save
    }
});

document.getElementById('siteBtn').addEventListener('click', function () {
    const select = document.getElementById('siteSelect');

    if (select.disabled) {
        select.disabled = false;   // enable edit
        select.focus();
    } else {
        select.form.submit();      // save
    }
});
</script>
