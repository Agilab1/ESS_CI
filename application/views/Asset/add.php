<?php $isView = ($action == "view"); ?>
<?php $disabled = $isView ? "disabled" : ""; ?>

<body class="p-4" style="background:#f5f7fa;">
<div class="d-flex justify-content-center align-items-center" style="min-height:100vh;">
<div class="container" style="width:75%; max-width:900px;">

<div class="card shadow-lg border-0 rounded-4 overflow-hidden">
    <div class="card-header py-3">
        <h4 class="m-0"><?= ucfirst($action) ?> Asset</h4>
    </div>

    <div class="card-body p-4">

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
        <?php endif; ?>

        <!-- ADD / EDIT FORM -->
        <?php if (!$isView): ?>
        <form method="post" action="<?= base_url('Asset/save'); ?>" autocomplete="off">
            <input type="hidden" name="action" value="<?= $action ?>">
            <input type="hidden" name="asset_id" value="<?= $asset->asset_id ?>">
        <?php endif; ?>

        <table class="table table-bordered">

            <tr>
    <td>
        <label>Asset ID</label>

        <?php if ($action == 'add'): ?>
            <input type="text" name="asset_id" class="form-control" required>
        <?php else: ?>
            <input type="text" class="form-control"
                   value="<?= $asset->asset_id ?>" readonly>
        <?php endif; ?>

    </td>

    <td>
        <label>Asset Number</label>
        <input type="text" name="asset_no" class="form-control"
               value="<?= $asset->asset_no ?>" <?= $disabled ?> required>
    </td>
</tr>


            <tr>
                <td>
                    <label>Asset Name</label>
                    <input type="text" name="asset_name" class="form-control"
                           value="<?= $asset->asset_name ?>" <?= $disabled ?> required>
                </td>
                <td>
                    <label>Net Value</label>
                    <input type="number" name="net_value" class="form-control"
                           value="<?= $asset->net_value ?>" <?= $disabled ?>>
                </td>
            </tr>

            <tr>
                <td>
                    <label>Status</label>
                    <select name="status" class="form-control" <?= $disabled ?>>
                        <option value="1" <?= $asset->status == 1 ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= $asset->status == 0 ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </td>
                <td>
                    <label>Category</label>
                    <select name="cat_id" class="form-control" <?= $disabled ?>>
                        <?php foreach ($categories as $c): ?>
                            <option value="<?= $c->cat_id ?>"
                                <?= $asset->cat_id == $c->cat_id ? 'selected' : '' ?>>
                                <?= $c->cat_no ?> - <?= $c->cat_name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>

            <!-- 🔥 STAFF & SITE (EDITABLE IN ADD/EDIT) -->
            <tr>
                <td>
                    <label>Staff</label>
                    <?php if ($isView): ?>
                        <input type="text" class="form-control"
                               value="<?= $asset->emp_name ?>" readonly>
                    <?php else: ?>
                        <select name="staff_id" class="form-control" required>
                            <option value="">Select Staff</option>
                            <?php foreach ($staffs as $s): ?>
                                <option value="<?= $s->staff_id ?>"
                                    <?= $asset->staff_id == $s->staff_id ? 'selected' : '' ?>>
                                    <?= $s->emp_name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </td>

                <td>
                    <label>Site</label>
                    <?php if ($isView): ?>
                        <input type="text" class="form-control"
                               value="<?= $asset->site_no ?> - <?= $asset->site_name ?>" readonly>
                    <?php else: ?>
                        <select name="site_id" class="form-control" required>
                            <option value="">Select Site</option>
                            <?php foreach ($sites as $s): ?>
                                <option value="<?= $s->site_id ?>"
                                    <?= $asset->site_id == $s->site_id ? 'selected' : '' ?>>
                                    <?= $s->site_no ?> - <?= $s->site_name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </td>
            </tr>

            <!-- BUTTONS -->
            <tr>
                <td colspan="2" class="text-center pt-4">

                    <?php if ($isView): ?>

                        <form method="post" action="<?= base_url('Asset/updateStaff'); ?>" class="d-inline">
                            <input type="hidden" name="asset_id" value="<?= $asset->asset_id ?>">
                            <select name="staff_id" class="form-control d-inline w-50 me-2" required>
                                <?php foreach ($staffs as $s): ?>
                                    <option value="<?= $s->staff_id ?>"
                                        <?= $asset->staff_id == $s->staff_id ? 'selected' : '' ?>>
                                        <?= $s->emp_name ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button class="btn btn-warning">Update Staff</button>
                        </form>

                        <br><br>

                        <form method="post" action="<?= base_url('Asset/updateSite'); ?>" class="d-inline">
                            <input type="hidden" name="asset_id" value="<?= $asset->asset_id ?>">
                            <select name="site_id" class="form-control d-inline w-50 me-2" required>
                                <?php foreach ($sites as $s): ?>
                                    <option value="<?= $s->site_id ?>"
                                        <?= $asset->site_id == $s->site_id ? 'selected' : '' ?>>
                                        <?= $s->site_no ?> - <?= $s->site_name ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button class="btn btn-info">Update Site</button>
                        </form>

                        <br><br>
                        <a href="<?= base_url('Asset/list'); ?>" class="btn btn-secondary">Back</a>

                    <?php else: ?>

                        <button type="submit" class="btn btn-primary px-5">Save</button>
                        <a href="<?= base_url('Asset/list'); ?>" class="btn btn-secondary ms-3">Back</a>

                    <?php endif; ?>

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
