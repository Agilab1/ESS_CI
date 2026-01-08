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
    'department_id' => '',
    'net_val'   => '',
    'status'    => 1
];
?>

<div class="d-flex justify-content-center align-items-center" style="min-height:100vh;">
<div class="container" style="max-width:900px;">
<div class="card shadow-lg border-0 rounded-4 overflow-hidden">

<div class="card-header py-3">
    <h4 class="m-0"><?= ucfirst($action) ?> Asset Detail — <?= $asset->asset_name ?></h4>
</div>

<div class="card-body p-4">

<form method="post" action="<?= base_url('asset/save_detail') ?>">

<input type="hidden" name="action" value="<?= $action ?>">
<input type="hidden" name="asset_id" value="<?= $asset->asset_id ?>">
<input type="hidden" name="assdet_id" value="<?= $detail->assdet_id ?>">

<table class="table table-bordered">

<tr>
<td>
<label>Serial No</label>
<input type="text" name="serial_no" class="form-control"
value="<?= $detail->serial_no ?>" <?= $readonlySerial ?> required>
</td>

<td>
<label>Asset ID</label>
<input type="text" class="form-control"
value="<?= $asset->asset_id ?>" readonly>
</td>
</tr>

<tr>
<td>
<label>Net Value</label>
<input type="number" name="net_val" class="form-control"
value="<?= $detail->net_val ?>" <?= $disabledView ?>>
</td>

<td>
<label>Status</label>
<select name="status" class="form-control" <?= $disabledView ?>>
<option value="1" <?= $detail->status == 1 ? 'selected' : '' ?>>Active</option>
<option value="0" <?= $detail->status == 0 ? 'selected' : '' ?>>Inactive</option>
</select>
</td>
</tr>

<tr>
<td>
<label>Site</label>
<select name="site_id" class="form-control" <?= $disabledView ?>>
<?php foreach($sites as $s): ?>
<option value="<?= $s->site_id ?>" <?= $s->site_id == $detail->site_id ? 'selected' : '' ?>>
<?= $s->site_name ?>
</option>
<?php endforeach; ?>
</select>
</td>

<td></td>
</tr>

<tr><td colspan="2"><strong>Allocated To</strong></td></tr>

<tr id="staffRow">
<td colspan="2">
<label>Staff</label>
<select name="staff_id" class="form-control" <?= $disabledView ?>>
<option value="">Select Staff</option>
<?php foreach($staffs as $s): ?>
<option value="<?= $s->staff_id ?>" <?= $detail->staff_id==$s->staff_id?'selected':'' ?>>
<?= $s->emp_name ?>
</option>
<?php endforeach; ?>
</select>
</td>
</tr>

<tr id="deptRow">
<td colspan="2">
<label>Department</label>
<select name="department_id" class="form-control" <?= $disabledView ?>>
<option value="">Select Department</option>
<?php foreach($departments as $d): ?>
<option value="<?= $d->department_id ?>" <?= $detail->department_id==$d->department_id?'selected':'' ?>>
<?= $d->department_name ?>
</option>
<?php endforeach; ?>
</select>
</td>
</tr>

<tr>
<td colspan="2" class="text-center pt-3">
<?php if(!$isView): ?>
<button class="btn btn-primary me-3">
<i class="fas fa-save"></i> Save
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
const ownership = "<?= $asset->ownership_type ?>";

if (ownership === 'department') {
    document.getElementById('staffRow').style.display = 'none';
    document.getElementById('deptRow').style.display  = '';
} else {
    document.getElementById('staffRow').style.display = '';
    document.getElementById('deptRow').style.display  = 'none';
}
</script>
