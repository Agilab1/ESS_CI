<?php
$is_edit = isset($material);
$is_view = isset($view_only);

$readonly = $is_view ? 'readonly' : '';
$disabled = $is_view ? 'disabled' : '';
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">

                <!-- Header -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <?= $is_view ? 'View Material' : ($is_edit ? 'Edit Material' : 'Add Material') ?>
                    </h4>
                </div>

                <!-- Card -->
                <div class="card shadow">
                    <div class="card-body">

                        <form method="post"
                            action="<?= (!$is_view && $is_edit && isset($material->material_id))
                                        ? base_url('material/update/' . $material->material_id)
                                        : (!$is_view ? base_url('material/store') : 'javascript:void(0)') ?>">

                            <table class="table table-bordered">

                                <!-- ROW 1 : MATERIAL ID -->
                                <tr>
                                    <td colspan="2">
                                        <label>Material ID</label>
                                        <input class="form-control"
                                            type="text"
                                            value="<?= isset($material) ? $material->material_id : 'Auto Generated' ?>"
                                            readonly>
                                    </td>
                                </tr>

                                <!-- ROW 2 : MATERIAL CODE | UOM -->
                                <tr>
                                    <td>
                                        <label>Material Code</label>
                                        <input class="form-control"
                                            type="text"
                                            name="material_code"
                                            value="<?= isset($material) ? $material->material_code : '' ?>"
                                            <?= $readonly ?>>
                                    </td>

                                    <td>
                                        <label>UOM</label>
                                        <select name="uom" class="form-control" <?= $disabled ?> required>
                                            <option value="">Select UOM</option>

                                            <?php foreach ($uoms as $u): ?>
                                                <option value="<?= $u->uom_code ?>"
                                                    <?= (isset($material) && $material->uom == $u->uom_code) ? 'selected' : '' ?>>
                                                    <?= $u->uom_name ?> (<?= $u->uom_code ?>)
                                                </option>
                                            <?php endforeach; ?>

                                        </select>
                                    </td>

                                </tr>

                                <!-- ROW 3 : ASSET NAME | QUANTITY -->
                                <tr>
                                    <td>
                                        <label>Asset ID</label>
                                        <input class="form-control"
                                            type="text"
                                            name="asset_id"
                                            value="<?= isset($material) ? $material->asset_id : '' ?>"
                                            <?= $readonly ?>>
                                    </td>


                                    <td>
                                        <label>Quantity</label>
                                        <input class="form-control"
                                            type="number"
                                            name="quantity"
                                            value="<?= isset($material) ? $material->quantity : '' ?>"
                                            <?= $readonly ?>>
                                    </td>
                                </tr>

                                <!-- ROW 4 : UNIT PRICE | STATUS -->
                                <tr>
                                    <td>
                                        <label>Unit Price</label>
                                        <input class="form-control"
                                            type="number"
                                            step="0.01"
                                            name="unit_price"
                                            value="<?= isset($material) ? $material->unit_price : '' ?>"
                                            <?= $readonly ?>>
                                    </td>

                                    <td>
                                        <label>Status</label>

                                        <?php if ($is_view): ?>
                                            <input type="hidden" name="status"
                                                value="<?= $material->status ?? 1 ?>">
                                        <?php endif; ?>

                                        <select name="status" class="form-control" <?= $disabled ?>>
                                            <option value="1"
                                                <?= (isset($material) && $material->status == 1) ? 'selected' : '' ?>>
                                                Active
                                            </option>
                                            <option value="0"
                                                <?= (isset($material) && $material->status == 0) ? 'selected' : '' ?>>
                                                Inactive
                                            </option>
                                        </select>
                                    </td>
                                </tr>

                                <!-- BUTTONS -->
                                <tr>
                                    <td colspan="2" class="text-center">
                                        <a href="<?= base_url('material') ?>" class="btn btn-secondary">
                                            Back
                                        </a>

                                        <?php if (!$is_view): ?>
                                            <button type="submit" class="btn btn-primary ml-2">
                                                Save
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                            </table>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>