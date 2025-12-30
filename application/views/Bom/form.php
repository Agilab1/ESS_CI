<?php
$readonly = ($action == 'view') ? 'disabled' : '';
?>

<div class="container mt-4">
    <h4>
        <?= $action == 'add' ? 'Add BOM' : ($action == 'edit' ? 'Edit BOM' : 'View BOM') ?>
    </h4>

    <form method="post" action="<?= base_url('bom/save') ?>">
        <input type="hidden" name="action" value="<?= $action ?>">

        <?php if ($bom): ?>
            <input type="hidden" name="bom_id" value="<?= $bom->bom_id ?>">
        <?php endif; ?>

        <div class="mb-3">
            <label>Parent Material</label>
            <select name="parent_material_id" class="form-control" required <?= $readonly ?>>
                <option value="">Select</option>
                <?php foreach ($materials as $m): ?>
                    <option value="<?= $m->material_id ?>"
                        <?= ($bom && $bom->parent_material_id == $m->material_id) ? 'selected' : '' ?>>
                        <?= $m->material_code ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Child Material</label>
            <select name="child_material_id" class="form-control" required <?= $readonly ?>>
                <option value="">Select</option>
                <?php foreach ($materials as $m): ?>
                    <option value="<?= $m->material_id ?>"
                        <?= ($bom && $bom->child_material_id == $m->material_id) ? 'selected' : '' ?>>
                        <?= $m->material_code ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>UOM</label>
            <input type="text" name="uom" class="form-control"
                   value="<?= $bom->uom ?? '' ?>" required <?= $readonly ?>>
        </div>

        <div class="mb-3">
            <label>Quantity</label>
            <input type="number" name="qty" class="form-control"
                   value="<?= $bom->qty ?? '' ?>" required <?= $readonly ?>>
        </div>

        <?php if ($action != 'view'): ?>
            <button class="btn btn-success">Save</button>
        <?php endif; ?>

        <a href="<?= base_url('bom/bom_dash') ?>" class="btn btn-secondary">Back</a>
    </form>
</div>
