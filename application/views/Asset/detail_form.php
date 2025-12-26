<?php
$isView = ($action === 'view');
$isEdit = ($action === 'edit');

$disabledView   = $isView ? 'disabled' : '';
$readonlySerial = ($isView || $isEdit) ? 'readonly' : '';

// Safe default object (prevents null warnings)
$detail = $detail ?? (object)[
    'assdet_id' => '',
    'serial_no' => '',
    'site_id'   => '',
    'staff_id'  => '',
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

<?php if($isEdit): ?>
<input type="hidden" name="assdet_id" value="<?= $detail->assdet_id ?>">
<?php endif; ?>

<table class="table table-bordered">

<tr>
<td>
<label class="fw-semibold">Serial No</label>
<input type="text" name="serial_no" class="form-control"
value="<?= $detail->serial_no ?>"
<?= $readonlySerial ?> required>
</td>


<td >
    <label class="fw-semibold">Asset ID</label>
    <input type="text" class="form-control"
           value="<?= $asset->asset_id ?? 'Auto Generated' ?>" readonly>
</td>
</tr>



<tr>

    

<td>
<label class="fw-semibold">Net Value</label>
<input type="number" name="net_val" class="form-control"
value="<?= $detail->net_val ?>" <?= $disabledView ?>>
</td>

<td>
<label class="fw-semibold">Staff</label>
<select name="staff_id" class="form-control" <?= $disabledView ?>>
<?php foreach($staffs as $st): ?>
<option value="<?= $st->staff_id ?>" <?= $st->staff_id == $detail->staff_id ? 'selected' : '' ?>>
<?= $st->emp_name ?>
</option>
<?php endforeach; ?>
</select>
</td>
</tr>

<tr>
<td colspan="1">
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
