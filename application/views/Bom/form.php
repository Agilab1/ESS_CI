<?php
$readonly = ($action == 'view') ? 'disabled' : '';
$is_view  = ($action == 'view');
?>

<style>
    /* Same look as Add Staff */
    .bom-card {
        max-width: 700px;
        margin: 40px auto;
    }

    .bom-card .card {
        box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
        border-radius: 6px;
    }

    .bom-card .card-header {
        background: #fff;
        font-weight: 600;
        font-size: 18px;
    }

    .form-group label {
        font-weight: 600;
    }
</style>

<div class="bom-card">

    <div class="card">

        <!-- Header -->
        <div class="card-header">
            <?= $action == 'add' ? 'Add BOM' : ($action == 'edit' ? 'Edit BOM' : 'View BOM') ?>
        </div>

        <!-- Body -->
        <div class="card-body">

            <form method="post" action="<?= base_url('bom/save') ?>">
                <input type="hidden" name="action" value="<?= $action ?>">

                <?php if ($bom): ?>
                    <input type="hidden" name="bom_id" value="<?= $bom->bom_id ?>">
                <?php endif; ?>

                <!-- Parent Material -->
                <div class="form-group mb-3">
                    <label>Parent Material *</label>
                    <select name="parent_material_id"
                        class="form-control"
                        required <?= $readonly ?>>
                        <option value="">Select</option>
                        <?php foreach ($materials as $m): ?>
                            <option value="<?= $m->material_id ?>"
                                <?= ($bom && $bom->parent_material_id == $m->material_id) ? 'selected' : '' ?>>
                                <?= $m->material_code ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Child Material -->
                <div class="form-group mb-3">
                    <label>Child Material *</label>
                    <select name="child_material_id"
                        class="form-control"
                        required <?= $readonly ?>>
                        <option value="">Select</option>
                        <?php foreach ($materials as $m): ?>
                            <option value="<?= $m->material_id ?>"
                                <?= ($bom && $bom->child_material_id == $m->material_id) ? 'selected' : '' ?>>
                                <?= $m->material_code ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- UOM -->
                <div class="form-group mb-3">
                    <label>UOM *</label>
                    <input type="text"
                        name="uom"
                        class="form-control"
                        value="<?= $bom->uom ?? '' ?>"
                        required <?= $readonly ?>>
                </div>

                <!-- Quantity -->
                <div class="form-group mb-4">
                    <label>Quantity *</label>
                    <input type="number"
                        name="qty"
                        class="form-control"
                        value="<?= $bom->qty ?? '' ?>"
                        required <?= $readonly ?>>
                </div>

                <!-- Buttons -->
                <div class="text-center">
                    <?php if (!$is_view): ?>
                        <button type="submit" class="btn btn-primary px-5">
                            Save
                        </button>
                    <?php endif; ?>

                    <a href="<?= base_url('bom/bom_dash') ?>"
                        class="btn btn-secondary px-5 ml-2">
                        Back
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>