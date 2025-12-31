<div class="container" style="max-width:700px;">
<div class="card shadow">

<div class="card-header bg-primary text-white">
    <h4>Add Child BOM</h4>
</div>

<div class="card-body">

<form method="post" action="<?= base_url('Bom/save_child') ?>">

<input type="hidden" name="parent_material_id"
       value="<?= $material->material_id ?>">

<div class="mb-3">
    <label class="fw-bold">Parent Material</label>
    <input type="text" class="form-control"
           value="<?= $material->material_code ?>" readonly>
</div>

<div class="mb-3">
    <label class="fw-bold">Child Material *</label>
    <select name="child_material_id" class="form-control" required>
        <option value="">Select</option>
        <?php foreach ($materials as $m): ?>
            <option value="<?= $m->material_id ?>">
                <?= $m->material_code ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<div class="mb-3">
    <label class="fw-bold">UOM *</label>
    <input type="text" name="uom" class="form-control" required>
</div>

<div class="mb-3">
    <label class="fw-bold">Quantity *</label>
    <input type="number" name="qty" class="form-control" required>
</div>

<div class="text-center">
    <button class="btn btn-primary">
        <i class="fa fa-save"></i> Save
    </button>

    <a href="<?= base_url('Bom/material/'.$material->material_id) ?>"
       class="btn btn-secondary">
       Back
    </a>
</div>

</form>

</div>
</div>
</div>
