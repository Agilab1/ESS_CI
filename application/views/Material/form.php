<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
/* ===== A4 Portrait Page ===== */
.a4-portrait {
    max-width: 794px;        /* A4 width */
    min-height: 1123px;      /* A4 height */
    margin: 20px auto;
    background: #fff;
    padding: 30px;
    box-shadow: 0 0 15px rgba(0,0,0,.15);
}

/* Form spacing */
.form-group label {
    font-weight: 600;
}

/* Print optimization */
@media print {
    body {
        background: #fff !important;
    }
    .a4-portrait {
        box-shadow: none;
        margin: 0;
        padding: 20px;
    }
    .btn {
        display: none !important;
    }
}
</style>

<div class="content-wrapper">
    <section class="content">

        <div class="a4-portrait">

            <!-- Title -->
            <h3 class="mb-4 text-center">
                <?= isset($material) ? 'Edit Material' : 'Add Material' ?>
            </h3>

            <form method="post"
                  action="<?= isset($material)
                        ? base_url('material/update/'.$material->material_id)
                        : base_url('material/store') ?>">

                <div class="row">

                    <!-- Material ID -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Material ID</label>
                            <input type="text"
                                   class="form-control"
                                   value="<?= $material->material_id ?? 'Auto Generated' ?>"
                                   readonly>
                        </div>
                    </div>

                    <!-- Material Code -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Material Code</label>
                            <input type="text"
                                   name="material_code"
                                   class="form-control"
                                   required
                                   value="<?= $material->material_code ?? '' ?>">
                        </div>
                    </div>

                    <!-- UOM -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>UOM</label>
                            <input type="text"
                                   name="uom"
                                   class="form-control"
                                   value="<?= $material->uom ?? 'Nos' ?>">
                        </div>
                    </div>

                    <!-- Unit Price -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Unit Price</label>
                            <input type="number"
                                   step="0.01"
                                   name="unit_price"
                                   class="form-control"
                                   value="<?= $material->unit_price ?? '' ?>">
                        </div>
                    </div>

                    <!-- Quantity -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number"
                                   name="quantity"
                                   class="form-control"
                                   value="<?= $material->quantity ?? '' ?>">
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <div class="form-group">
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
                        </div>
                    </div>

                </div>

                <!-- Buttons -->
                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-primary px-5">
                        Save
                    </button>
                    <a href="<?= base_url('material') ?>"
                       class="btn btn-secondary px-5 ml-2">
                        Back
                    </a>
                </div>

            </form>

        </div>

    </section>
</div>
