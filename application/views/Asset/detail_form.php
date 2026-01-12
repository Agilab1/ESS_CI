<?php

$isView = ($action === 'view');
$isEdit = ($action === 'edit');

$disabledView   = $isView ? 'disabled' : '';
$readonlySerial = ($isView || $isEdit) ? 'readonly' : '';

$detail = $detail ?? (object)[
    'assdet_id' => '',
    'serial_no' => '',
    'site_id'   => '',
    'staff_id'  => '',
    'net_val'   => '',
    'status'    => 1
];

if (!isset($loginUser)) {
    $loginUser = (object)[
        'staff_id' => null,
        'site_no'  => null
    ];
}

if ($isView && empty($detail->site_id) && !empty($loginUser->site_no)) {
    foreach ($sites as $s) {
        if ($s->site_name == $loginUser->site_no || $s->site_id == $loginUser->site_no) {
            $detail->site_id = $s->site_id;
            break;
        }
    }
}

?>

<div class="d-flex justify-content-center align-items-center" style="min-height:100vh;">
<div class="container" style="max-width:900px;">
<div class="card shadow-lg border-0 rounded-4 overflow-hidden">

<div class="card-header py-3 d-flex align-items-center justify-content-between">
    <h4 class="m-0">
        <?= ucfirst($action) ?> Asset Detail — <?= $asset->asset_name ?>
    </h4>

    <?php if ($isView): ?>
    <div class="d-flex align-items-center">

        <form method="post" action="<?= base_url('Asset/updateStaff'); ?>" class="d-flex align-items-center">
            <input type="hidden" name="assdet_id" value="<?= $detail->assdet_id ?>">

            <select name="staff_id" id="staffSelect" class="form-control form-control-sm" disabled>
                <?php foreach ($staffs as $s): ?>
                    <option value="<?= $s->staff_id ?>" <?= $loginUser->staff_id == $s->staff_id ? 'selected' : '' ?>>
                        <?= $s->emp_name ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="button" id="staffBtn" class="btn btn-primary btn-sm ms-2">
                <i class="fas fa-user-edit"></i>
            </button>
        </form>

        <div style="width:15px;"></div>

        <form method="post" action="<?= base_url('Asset/updateSite'); ?>" class="d-flex align-items-center">
            <input type="hidden" name="assdet_id" value="<?= $detail->assdet_id ?>">

            <select name="site_id" id="siteSelect" class="form-control form-control-sm" disabled>
                <?php foreach ($sites as $s): ?>
                    <option value="<?= $s->site_id ?>"
                        <?= (!empty($loginUser->site_no) && $loginUser->site_no == $s->site_no) ? 'selected' : '' ?>>
                        <?= $s->site_name ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="button" id="siteBtn" class="btn btn-primary btn-sm ms-2">
                <i class="fas fa-map-marker-alt"></i>
            </button>
        </form>

    </div>
    <?php endif; ?>
</div>

<div class="card-body p-4">

<form method="post" action="<?= base_url('asset/save_detail') ?>">

<input type="hidden" name="action" value="<?= $action ?>">
<input type="hidden" name="asset_id" value="<?= $asset->asset_id ?>">
<input type="hidden" name="assdet_id" value="<?= $detail->assdet_id ?>">

<table class="table table-bordered">

<tr>
    <td>
        <label class="fw-semibold">Serial No</label>
        <input type="text" name="serial_no" class="form-control"
               value="<?= $detail->serial_no ?>" <?= $readonlySerial ?> required>
    </td>

    <td>
        <label class="fw-semibold">Asset ID</label>
        <input type="text" class="form-control"
               value="<?= $asset->asset_id ?>" readonly>
    </td>
</tr>

<tr>
    <td>
        <label class="fw-semibold">Net Value</label>
        <input type="number" name="net_val" class="form-control"
               value="<?= $detail->net_val ?>" <?= $disabledView ?>>
    </td>

    <td>
        <?php if ($ownership_type === 'staff'): ?>

            <label class="fw-semibold">Staff</label>
            <select name="staff_id" class="form-control" <?= $disabledView ?>>
                <?php foreach($staffs as $st): ?>
                    <option value="<?= $st->staff_id ?>" <?= $st->staff_id == $detail->staff_id ? 'selected' : '' ?>>
                        <?= $st->emp_name ?>
                    </option>
                <?php endforeach; ?>
            </select>

        <?php else: ?>

            <label class="fw-semibold">Department</label>
            <select name="department_id" class="form-control" <?= $disabledView ?>>
                <?php foreach($departments as $d): ?>
                    <option value="<?= $d->department_id ?>"
                        <?= $d->department_id == ($detail->department_id ?? '') ? 'selected' : '' ?>>
                        <?= $d->department_name ?>
                    </option>
                <?php endforeach; ?>
            </select>

        <?php endif; ?>
    </td>
</tr>

<tr>
    <td>
        <label class="fw-semibold">Status</label>
        <select name="status" class="form-control" <?= $disabledView ?>>
            <option value="1" <?= $detail->status == 1 ? 'selected' : '' ?>>Active</option>
            <option value="0" <?= $detail->status == 0 ? 'selected' : '' ?>>Inactive</option>
        </select>
    </td>

    <td>
        <label class="fw-semibold">Site</label>
        <select name="site_id" class="form-control" <?= $disabledView ?>>
            <?php foreach($sites as $s): ?>
                <option value="<?= $s->site_id ?>" <?= $s->site_id == $detail->site_id ? 'selected' : '' ?>>
                    <?= $s->site_name ?>
                </option>
            <?php endforeach; ?>
        </select>
    </td>
</tr>

<tr>
    <td colspan="2" class="text-center pt-3">
        <?php if(!$isView): ?>
            <button class="btn btn-primary me-3">
                <i class="fas fa-save me-1"></i> Save
            </button>
        <?php endif; ?>

        <a href="<?= base_url('asset/serials/'.$asset->asset_id) ?>" class="btn btn-secondary">Back</a>
    </td>
</tr>

</table>

</form>
</div>
</div>
</div>
</div>

<script>
document.getElementById('staffBtn')?.addEventListener('click', function () {
    const select = document.querySelector('#staffSelect');
    if (!select) return;

    if (select.disabled) {
        select.disabled = false;
        select.focus();
    } else {
        select.form.submit();
    }
});

document.getElementById('siteBtn')?.addEventListener('click', function () {
    const select = document.querySelector('#siteSelect');
    if (!select) return;

    if (select.disabled) {
        select.disabled = false;
        select.focus();
    } else {
        select.form.submit();
    }
});
</script>
