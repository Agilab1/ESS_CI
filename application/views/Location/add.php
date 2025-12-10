<body class="p-4" style="background:#f5f7fa;">
    <div class="d-flex justify-content-center align-items-center" style="height:100vh;">

        <div class="container" style="width:75%; max-width:900px;">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden"
                style="box-shadow: 0 12px 50px rgba(0,0,0,0.22); min-height:350px;">

                <div class="card-header border-5 py-3">
                    <h4 class="m-0"><?= ucfirst($action) ?> Location</h4>
                </div>

                <div class="card-body p-4">

                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= base_url('Location/save'); ?>" autocomplete="off">

                        <!-- Hidden fields -->
                        <input type="hidden" name="action" value="<?= $action ?>">
                        <input type="hidden" name="old_site_id" value="<?= $location->site_id ?? '' ?>">

                        <?php $readonly = ($action == 'view') ? 'readonly disabled' : ''; ?>

                        <table class="table table-bordered">

                            <!-- Site Number + Site Name -->
                            <tr>
                                <td class="p-3 w-50">
                                    <label class="form-label">Site Number</label>
                                    <input type="text" name="site_no" class="form-control" required
                                        placeholder="OFFICE_001"
                                        value="<?= $location->site_no ?? '' ?>" <?= $readonly ?>>
                                </td>

                                <td class="p-3 w-50">
                                    <label class="form-label">Site Name</label>
                                    <input type="text" name="site_name" class="form-control" required
                                        placeholder="Agilab Office Room"
                                        value="<?= $location->site_name ?? '' ?>" <?= $readonly ?>>
                                </td>
                            </tr>

                            <!-- Last Visit + Verify Asset -->
                            <tr>
                                <td class="p-3">
                                    <label class="form-label">Last Visit</label>
                                    <input type="datetime-local" name="last_visit" class="form-control"
                                        value="<?= isset($location->last_visit) ? date('Y-m-d\TH:i', strtotime($location->last_visit)) : '' ?>"
                                        <?= $readonly ?>>
                                </td>

                                <td class="p-3">
                                    <label class="form-label">Verify Asset</label>
                                    <input type="number" name="verify_asset" class="form-control" placeholder="0 or 1"
                                        value="<?= $location->verify_asset ?? '' ?>" <?= $readonly ?>>
                                </td>
                            </tr>

                            <!-- Status + Access Flag -->
                            <tr>
                                <td class="p-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control" required <?= $readonly ?>>
                                        <option value="">Select Status</option>
                                        <option value="1" <?= (isset($location->status) && $location->status == 1) ? 'selected' : '' ?>>Active</option>
                                        <option value="0" <?= (isset($location->status) && $location->status == 0) ? 'selected' : '' ?>>Inactive</option>
                                    </select>
                                </td>

                                <td class="p-3">
                                    <label class="form-label">Access Flag</label>
                                    <input type="text" name="access_flag" class="form-control"
                                        placeholder="NULL / Yes / No"
                                        value="<?= $location->access_flag ?? '' ?>" <?= $readonly ?>>
                                </td>
                            </tr>

                            <!-- Access By -->
                            <tr>
                                <td class="p-3">
                                    <label class="form-label">Access By</label>
                                    <input type="text" name="access_by" class="form-control"
                                        placeholder="User name"
                                        value="<?= $location->access_by ?? '' ?>" <?= $readonly ?>>
                                </td>

                                <td class="p-3"></td>
                            </tr>

                            <!-- Buttons -->
                            <?php if ($action != 'view'): ?>
                                <tr>
                                    <td colspan="2" class="text-center pt-4 pb-3">
                                        <button class="btn btn-primary px-5 py-2 rounded-3">Save</button>
                                        <a href="<?= base_url('Location/list'); ?>" class="btn btn-secondary px-4 py-2 rounded-3 ms-3">Back</a>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2" class="text-center pt-4 pb-3">
                                        <a href="<?= base_url('Location/list'); ?>" class="btn btn-primary px-4 py-2 rounded-3">Back</a>
                                    </td>
                                </tr>
                            <?php endif; ?>

                        </table>

                    </form>

                </div>
            </div>
        </div>

    </div>
</body>

