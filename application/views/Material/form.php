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
                            action="<?= (!$is_view && $is_edit)
                                        ? base_url('material/update/' . $material->material_id)
                                        : (!$is_view ? base_url('material/store') : 'javascript:void(0)') ?>">

                            <table class="table table-bordered">

                                <!-- MATERIAL ID -->
                                <tr>
                                    <td colspan="2">
                                        <label>Material ID</label>
                                        <input class="form-control"
                                            type="text"
                                            value="<?= $material->material_id ?? 'Auto Generated' ?>"
                                            readonly>
                                    </td>
                                </tr>

                                <!-- MATERIAL CODE + UOM -->
                                <tr>
                                    <td>
                                        <label>Material Code</label>
                                        <input class="form-control"
                                            type="text"
                                            name="material_code"
                                            value="<?= $material->material_code ?? '' ?>"
                                            <?= $readonly ?>>
                                    </td>

                                    <td>
                                        <label>UOM</label>
                                        <input class="form-control"
                                            type="text"
                                            name="uom"
                                            value="<?= $material->uom ?? 'Nos' ?>"
                                            <?= $readonly ?>>
                                    </td>
                                </tr>

                                <!-- UNIT PRICE + QUANTITY -->
                                <tr>
                                    <td>
                                        <label>Unit Price</label>
                                        <input class="form-control"
                                            type="number"
                                            step="0.01"
                                            name="unit_price"
                                            value="<?= $material->unit_price ?? '' ?>"
                                            <?= $readonly ?>>
                                    </td>

                                    <td>
                                        <label>Quantity</label>
                                        <input class="form-control"
                                            type="number"
                                            name="quantity"
                                            value="<?= $material->quantity ?? '' ?>"
                                            <?= $readonly ?>>
                                    </td>
                                </tr>

                                <!-- STATUS -->
                                <tr>
                                    <td colspan="2">
                                        <label>Status</label>
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