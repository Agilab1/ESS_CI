<?php $disabled = ($action == "view") ? "disabled" : ""; ?>

<body class="p-4" style="background:#f5f7fa;">
    <div class="d-flex justify-content-center align-items-center" style="min-height:100vh;">

        <div class="container" style="width:75%; max-width:900px;">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden"
                style="box-shadow: 0 12px 50px rgba(0,0,0,0.22); min-height:350px;">

                <div class="card-header border-5 py-3">
                    <h4 class="m-0"><?= ucfirst($action) ?> Asset</h4>
                </div>

                <div class="card-body p-4">

                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                    <?php endif; ?>

                    <form method="post" action="<?= base_url('Asset/save'); ?>" autocomplete="off">

                        <input type="hidden" name="action" value="<?= $action ?>">
                        <input type="hidden" name="asset_id_old" value="<?= $asset->asset_id ?>">

                        <table class="table table-bordered">

                            <tr>
                                <td class="p-3 w-50">
                                    <label class="form-label">Asset Number</label>
                                    <input type="text" name="asset_no" class="form-control" required
                                        value="<?= $asset->asset_no ?>" <?= $disabled ?>>
                                </td>
                                <td class="p-3 w-50">
                                    <label class="form-label">Asset Name</label>
                                    <input type="text" name="asset_name" class="form-control" required
                                        value="<?= $asset->asset_name ?>" <?= $disabled ?>>
                                </td>
                            </tr>

                            <tr>
                                <td class="p-3 w-50">
                                    <label class="form-label">Net Value</label>
                                    <input type="number" name="net_value" class="form-control"
                                        value="<?= $asset->net_value ?>" <?= $disabled ?>>
                                </td>
                                <td class="p-3 w-50">
                                    <label class="form-label">Site</label>
                                    <select name="site_id" class="form-control" <?= $disabled ?> required>
                                        <option value="">Select Site</option>
                                        <?php foreach ($sites as $s): ?>
                                            <option value="<?= $s->site_id ?>" <?= ($asset->site_id == $s->site_id) ? 'selected' : '' ?>>
                                                <?= $s->site_no ?> – <?= $s->site_name ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td class="p-3 w-50">
                                    <label class="form-label">Staff</label>
                                    <select name="staff_id" class="form-control" <?= $disabled ?>>
                                        <option value="">Select Staff</option>
                                        <?php foreach ($staffs as $s): ?>
                                            <option value="<?= $s->staff_id ?>" <?= ($asset->staff_id == $s->staff_id) ? 'selected' : '' ?>>
                                                <?= $s->emp_name ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td class="p-3 w-50">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control" <?= $disabled ?>>
                                        <option value="1" <?= $asset->status == 1 ? 'selected' : '' ?>>Active</option>
                                        <option value="0" <?= $asset->status == 0 ? 'selected' : '' ?>>Inactive</option>
                                    </select>
                                </td>
                            </tr>

                            <!-- CATEGORY DROPDOWN (Correct Position) -->
                            <tr>
                                <td class="p-3 w-50">
                                    <label class="form-label">Category</label>
                                    <select name="cat_id" class="form-control" <?= $disabled ?> required>
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $c): ?>
                                            <option value="<?= $c->cat_id ?>"
                                                <?= ($asset->cat_id == $c->cat_id) ? 'selected' : '' ?>>
                                                <?= $c->cat_no ?> – <?= $c->cat_name ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" class="text-center pt-4 pb-3">
                                    <?php if ($action != "view"): ?>
                                        <button type="submit" class="btn btn-primary px-5 py-2 rounded-3">Save</button>
                                        <a href="<?= base_url('Asset/list'); ?>" class="btn btn-secondary px-4 py-2 rounded-3 ms-3">Back</a>
                                    <?php else: ?>
                                        <a href="<?= base_url('Asset/list'); ?>" class="btn btn-primary px-4 py-2 rounded-3">Back</a>
                                    <?php endif; ?>
                                </td>
                            </tr>

                        </table>

                    </form>

                </div>
            </div>
        </div>

    </div>
</body>
