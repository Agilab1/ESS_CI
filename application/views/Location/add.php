 <div class="d-flex justify-content-center align-items-center" style="height:100vh;">

        <div class="container" style="width:75%; max-width:900px;">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden"
                 style="box-shadow:0 12px 50px rgba(0,0,0,0.22); min-height:350px;">

                <div class="card-header py-3">
                    <h4 class="m-0"><?= ucfirst($action) ?> Location</h4>
                </div>

                <div class="card-body p-4">

                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                    <?php endif; ?>

                    <form method="post" action="<?= base_url('Location/save'); ?>" autocomplete="off">

                        <input type="hidden" name="action" value="<?= $action ?>">
                        <input type="hidden" name="old_site_id" value="<?= $location->site_id ?? '' ?>">

                        <?php $readonly = ($action == 'view') ? 'readonly disabled' : ''; ?>

                        <!-- ---------------- ROW 1 ---------------- -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Site ID</label>
                                <input type="text" name="site_id" class="form-control" required
                                       value="<?= $location->site_id ?? '' ?>" <?= $readonly ?>>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Site Number</label>
                                <input type="text" name="site_no" class="form-control" required
                                       value="<?= $location->site_no ?? '' ?>" <?= $readonly ?>>
                            </div>
                        </div>

                        <!-- ---------------- ROW 2 ---------------- -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Site Name</label>
                                <input type="text" name="site_name" class="form-control" required
                                       value="<?= $location->site_name ?? '' ?>" <?= $readonly ?>>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Access By</label>
                                <input type="text" name="access_by" class="form-control"
                                       value="<?= $location->access_by ?? '' ?>" <?= $readonly ?>>
                            </div>
                        </div>

                        <!-- ---------------- ROW 3 ---------------- -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Last Visit</label>
                                <input type="datetime-local" name="last_visit" class="form-control"
                                       value="<?= isset($location->last_visit) ? date('Y-m-d\TH:i', strtotime($location->last_visit)) : '' ?>"
                                       <?= $readonly ?>>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Verify Asset</label>
                                <input type="number" name="verify_asset" class="form-control"
                                       value="<?= $location->verify_asset ?? '' ?>" <?= $readonly ?>>
                            </div>
                        </div>

                        <!-- ---------------- ROW 4 ---------------- -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control" required <?= $readonly ?>>
                                    <option value="">Select Status</option>
                                    <option value="1" <?= (isset($location->status) && $location->status == 1) ? 'selected' : '' ?>>Active</option>
                                    <option value="0" <?= (isset($location->status) && $location->status == 0) ? 'selected' : '' ?>>Inactive</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Access Flag</label>
                                <input type="text" name="access_flag" class="form-control"
                                       value="<?= $location->access_flag ?? '' ?>" <?= $readonly ?>>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="text-center mt-4">
                            <?php if ($action != 'view'): ?>
                                <button class="btn btn-primary px-5 py-2">Save</button>
                                <a href="<?= base_url('Location/list'); ?>" class="btn btn-secondary px-4 py-2 ms-2">Back</a>
                            <?php else: ?>
                                <a href="<?= base_url('Location/list'); ?>" class="btn btn-primary px-4 py-2">Back</a>
                            <?php endif; ?>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
</body>
