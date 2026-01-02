<style>
   input[readonly],
input[disabled],
select[disabled] {
    background-color: #e9ecef !important;
    color: #495057 !important;
    border: 1px solid #ced4da !important;
    cursor: not-allowed;
    box-shadow: none;
}
.bom-form .row { margin: 0; }

.bom-form .row > div {
    border-right: 1px solid #dee2e6;
    border-bottom: 1px solid #dee2e6;
    padding-top: 8px;
    padding-bottom: 8px;
}

.bom-form .row > div:first-child {
    border-left: 1px solid #dee2e6;
}

.bom-form .header-row > div {
    background: #f8f9fa;
    font-weight: 600;
    border-top: 2px solid #ced4da;
    border-bottom: 2px solid #ced4da;
}

.bom-form {
    border: 1px solid #ced4da;
    border-radius: 6px;
    overflow: hidden;
}
</style>

<div class="d-flex justify-content-center align-items-center"
     style="min-height:100vh; background:#f4f6f9;">

<div class="container" style="max-width:1100px;">
<div class="card shadow-lg border-0 rounded-4 overflow-hidden">

<!-- HEADER -->
<div class="card-header bg-primary text-white py-3">
    <h4 class="m-0">BOM – Bill of Material</h4>
</div>

<!-- BODY -->
<div class="card-body p-4">

<!-- ================= PARENT MATERIAL ================= -->
<div class="row mb-4">
    <div class="col-md-6">
        <label class="fw-bold">Material ID</label>
        <input class="form-control bg-light"
               value="<?= $material->material_id ?>" readonly>
    </div>

    <div class="col-md-6">
        <label class="fw-bold">Material Code</label>
        <input class="form-control bg-light"
               value="<?= $material->material_code ?>" readonly>
    </div>
</div>

<!-- ================= BOM LIST ================= -->
<div class="border rounded p-3 bom-form">

<!-- TABLE HEADER -->
<div class="row g-2 align-items-center fw-bold bg-light text-center border-bottom pb-2 mb-3 header-row">
    <div class="col-md-1">#</div>
    <div class="col-md-2">BOM ID</div>
    <div class="col-md-3">Child Material</div>
    <div class="col-md-2">UOM</div>
    <div class="col-md-2">Qty</div>
    <div class="col-md-2">Action</div>
</div>

<?php
$usedMaterials = [];
if (!empty($boms)) {
    foreach ($boms as $b) {
        $usedMaterials[] = trim($b->child_name);
    }
}
?>

<form id="addForm" method="post" action="<?= base_url('Bom/save_child') ?>">
<div class="row g-2 align-items-center border-bottom pb-3 mb-3">

    <div class="col-md-1 text-center fw-bold text-primary">+</div>

    <div class="col-md-2">
        <input class="form-control" value="Auto" readonly>
        <input type="hidden" name="parent_material_id"
               value="<?= $material->material_id ?>">
    </div>

    <div class="col-md-3">
       <select name="child_material_id" class="form-control" required>
    <option value="">Select</option>
    <?php foreach ($materials as $m): ?>

        <?php
            // Exclude parent material & already used child materials
            if (
                $m->material_id == $material->material_id ||
                in_array(trim($m->material_code), $usedMaterials)
            ) {
                continue;
            }
        ?>

        <option value="<?= $m->material_id ?>">
            <?= $m->material_code ?>
        </option>

    <?php endforeach; ?>
</select>


    </div>

    <div class="col-md-2">
        <select name="uom_id" class="form-control" required>
            <option value="">Select UOM</option>
            <?php foreach ($uoms as $u): ?>
                <option value="<?= $u->uom_id ?>">
                    <?= $u->uom_name ?> (<?= $u->uom_code ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-2">
        <input type="number" name="qty"
               class="form-control" placeholder="Qty" required>
    </div>

    <div class="col-md-2 text-center">
        <button class="btn btn-primary">
            <i class="fa fa-plus"></i>
        </button>
    </div>

</div>
</form>

<?php if (!empty($boms)): ?>
<?php $i=1; foreach ($boms as $b): ?>

<div class="row g-2 align-items-center border-bottom py-2 text-center">

    <div class="col-md-1 fw-semibold"><?= $i++ ?></div>

    <div class="col-md-2">
        <input class="form-control bg-light" value="<?= $b->bom_id ?>" readonly>
    </div>

    <div class="col-md-3">
        <input class="form-control bg-light" value="<?= $b->child_name ?>" readonly>
    </div>

    <div class="col-md-2">
        <input class="form-control bg-light"
               value="<?= $b->uom_name ?> (<?= $b->uom_code ?>)" readonly>
    </div>

    <div class="col-md-2">
        <input class="form-control bg-light" value="<?= $b->qty ?>" readonly>
    </div>

    <div class="col-md-2">
        <a href="<?= base_url('bom/view/'.$b->bom_id) ?>" class="mx-1 text-secondary"><i class="fa fa-eye"></i></a>
        <a href="<?= base_url('bom/edit/'.$b->bom_id) ?>" class="mx-1 text-primary"><i class="fa fa-edit"></i></a>
        <a href="<?= base_url('bom/delete/'.$b->bom_id) ?>"
           onclick="return confirm('Delete BOM?')" class="mx-1 text-danger"><i class="fa fa-trash"></i></a>
    </div>

</div>

<?php endforeach; else: ?>

<div class="text-center text-muted py-4">No BOM found</div>

<?php endif; ?>

</div>

<div class="text-center mt-4">
    <a href="<?= base_url('Material'); ?>" class="btn btn-secondary px-4">
        ← Back to Material List
    </a>
</div>

</div>
</div>
</div>
</div>

<script>
document.getElementById('addForm').addEventListener('submit', function(){
    setTimeout(() => this.reset(), 200);
});
</script>
