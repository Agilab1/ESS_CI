<style>
    /* ===== MOBILE VIEW FIX FOR ASSET FORM ===== */
    @media (max-width: 767px) {

        .container {
            width: 100% !important;
            padding: 0 10px;
        }

        .card-body {
            padding: 1rem !important;
        }

        table.table {
            border: 0;
        }

        table.table tr {
            display: block;
            margin-bottom: 12px;
            border-bottom: 1px solid #dee2e6;
        }

        table.table td {
            display: block;
            width: 100%;
            border: none;
            padding: 6px 0;
        }

        table.table td label {
            font-size: 14px;
            margin-bottom: 4px;
        }

        input.form-control,
        select.form-control {
            width: 100%;
        }

        /* Buttons */
        .btn {
            width: 100%;
            margin-bottom: 8px;
        }

        .btn.me-3 {
            margin-right: 0 !important;
        }

        td.text-center {
            text-align: center !important;
        }
    }
</style>

<?php
$isView = ($action === 'view');
$disabled = $isView ? 'disabled' : '';
?>

<body class="p-4" style="background:#f5f7fa;">
    <div class="d-flex justify-content-center align-items-center" style="min-height:100vh;">
        <div class="container" style="width:75%; max-width:900px;">

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h4 class="m-0"><?= ucfirst($action) ?> Asset</h4>
                </div>

                <div class="card-body p-4">

                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                    <?php endif; ?>

                    <?php if (!$isView): ?>
                        <form method="post" action="<?= base_url('Asset/save'); ?>" autocomplete="off">
                            <input type="hidden" name="action" value="<?= $action ?>">

                            <?php if ($action === 'edit'): ?>
                                <input type="hidden" name="asset_id" value="<?= $asset->asset_id ?>">
                            <?php endif; ?>
                        <?php endif; ?>

                        <table class="table table-bordered">

                            <tr>
                                <td>
                                    <label class="fw-semibold">Asset Number</label>
                                    <input type="text" name="asset_no" class="form-control"
                                        value="<?= isset($asset->asset_no) ? $asset->asset_no : '' ?>" <?= $disabled ?> required>
                                </td>

                                <td>
                                    <label class="fw-semibold">Asset Name</label>
                                    <input type="text" name="asset_name" class="form-control"
                                        value="<?= isset($asset->asset_name) ? $asset->asset_name : '' ?>" <?= $disabled ?> required>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="1">
                                    <label class="fw-semibold">Category</label>
                                    <select name="type_id" class="form-control" <?= $disabled ?> required>
                                        <option value="">Select Category</option>

                                        <?php foreach ($categories as $c): ?>
                                            <option value="<?= $c->cat_id ?>"
                                                <?= (!empty($asset->type_id) && $asset->type_id == $c->cat_id) ? 'selected' : '' ?>>
                                                <?= $c->cat_no ?> - <?= $c->cat_name ?>
                                            </option>
                                        <?php endforeach; ?>

                                    </select>
                                </td>

                            </tr>

                            <tr>
                                <td colspan="2" class="text-center pt-3">

                                    <?php if (!$isView): ?>
                                        <button type="submit" class="btn btn-primary me-3">
                                            <i class="fas fa-save me-1"></i> Save
                                        </button>
                                    <?php endif; ?>

                                    <a href="<?= base_url('Asset/list'); ?>" class="btn btn-secondary">Back</a>

                                </td>
                            </tr>

                        </table>

                        <?php if (!$isView): ?>
                        </form>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</body>