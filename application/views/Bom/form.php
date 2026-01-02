<?php
$readonly = ($action === 'view') ? 'disabled' : '';
?>

<div class="d-flex justify-content-center align-items-center"
    style="min-height:100vh; background:#f4f6f9;">

    <div class="container" style="max-width:800px;">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

            <!-- HEADER -->
            <div class="card-header bg-primary text-white py-3">
                <h4 class="m-0">
                    <?= ucfirst($action) ?> BOM
                </h4>
            </div>

            <!-- BODY -->
            <div class="card-body p-4">

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>

                <?php if ($action !== 'view'): ?>
                    <form method="post" action="<?= base_url('Bom/save'); ?>">
                        <input type="hidden" name="parent_material_id"
                            value="<?= $bom->parent_material_id ?? '' ?>">

                        <input type="hidden" name="action" value="<?= $action ?>">

                        <?php if ($action === 'edit'): ?>
                            <input type="hidden" name="bom_id" value="<?= $bom->bom_id ?>">
                        <?php endif; ?>
                    <?php endif; ?>

                    <!-- PARENT MATERIAL -->
                    <div class="mb-3">
                        <label class="fw-bold">Parent Material *</label>
                        <select name="parent_material_id"
                            class="form-control"
                            required <?= $readonly ?>>
                            <option value="">Select</option>
                            <?php foreach ($materials as $m): ?>
                                <option value="<?= $m->material_id ?>"
                                    <?= (!empty($bom->parent_material_id)
                                        && $bom->parent_material_id == $m->material_id)
                                        ? 'selected' : '' ?>>
                                    <?= $m->material_code ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- CHILD MATERIAL -->
                    <div class="mb-3">
                        <label class="fw-bold">Child Material *</label>
                        <select name="child_material_id"
                            class="form-control"
                            required <?= $readonly ?>>
                            <option value="">Select</option>
                            <?php foreach ($materials as $m): ?>
                                <option value="<?= $m->material_id ?>"
                                    <?= (!empty($bom->child_material_id)
                                        && $bom->child_material_id == $m->material_id)
                                        ? 'selected' : '' ?>>
                                    <?= $m->material_code ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- UOM -->
                    <div class="mb-3">
                        <label class="fw-bold">UOM *</label>
                        <!-- <label>UOM *</label> -->
                        <select name="uom" class="form-control" required <?= ($action == 'view') ? 'disabled' : '' ?>>
                            <option value="">Select UOM</option>
                            <?php foreach ($uoms as $u): ?>
                                <option value="<?= $u->uom_code ?>"
                                    <?= ($bom->uom == $u->uom_code) ? 'selected' : '' ?>>
                                    <?= $u->uom_name ?> (<?= $u->uom_code ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>

                    </div>

                    <!-- QUANTITY -->
                    <div class="mb-4">
                        <label class="fw-bold">Quantity *</label>
                        <input type="number"
                            name="qty"
                            class="form-control"
                            value="<?= $bom->qty ?? '' ?>"
                            required <?= $readonly ?>>
                    </div>

                    <!-- BUTTONS -->
                    <div class="text-center">
                        <?php if ($action !== 'view'): ?>
                            <button type="submit" class="btn btn-primary px-4 me-2">
                                <i class="fa fa-save"></i> Save
                            </button>
                        <?php endif; ?>

                        <a href="<?= base_url('Bom/material/' . $bom->parent_material_id) ?>"
                            class="btn btn-secondary">
                            Back
                        </a>

                    </div>

                    <?php if ($action !== 'view'): ?>
                    </form>
                <?php endif; ?>

            </div>
        </div>
    </div>

</div>