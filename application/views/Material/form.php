<?php
$is_edit = isset($material);
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">

                <!-- Header -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <?= $is_edit ? 'Edit Material' : 'Add Material' ?>
                    </h4>
                </div>

                <!-- Card -->
                <div class="card shadow">
                    <div class="card-body">

                        <form method="post"
                            action="<?= $is_edit
                                        ? base_url('material/update/' . $material->material_id)
                                        : base_url('material/store') ?>">

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
                                            required
                                            value="<?= $material->material_code ?? '' ?>">
                                    </td>

                                    <td>
                                        <label>UOM</label>
                                        <input class="form-control"
                                            type="text"
                                            name="uom"
                                            value="<?= $material->uom ?? 'Nos' ?>">
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
                                            value="<?= $material->unit_price ?? '' ?>">
                                    </td>

                                    <td>
                                        <label>Quantity</label>
                                        <input class="form-control"
                                            type="number"
                                            name="quantity"
                                            value="<?= $material->quantity ?? '' ?>">
                                    </td>
                                </tr>

                                <!-- STATUS -->
                                <tr>
                                    <td colspan="2">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="">Select Status</option>
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
                                        <button type="submit" class="btn btn-primary ml-2">
                                            Save
                                        </button>
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