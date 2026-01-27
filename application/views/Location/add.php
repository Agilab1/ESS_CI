<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="d-flex justify-content-md-start justify-content-center align-items-center"
    style="min-height:100vh; background:#f4f6f9;">

    <div class="container" style="width:75%; max-width:900px;">

        <div class="card shadow-lg border-0 rounded-4 overflow-hidden"
            style="box-shadow:0 12px 50px rgba(0,0,0,0.22); min-height:350px;">

            <!-- HEADER -->
            <!-- <div class="card-header bg-primary text-white py-3">
                <h4 class="m-0 fw-bold">
                    <i class="fa fa-th-large me-2"></i>
                    Site Asset Verification
                </h4>
            </div> -->
            <div class="card-header bg-primary text-white py-3">
                <h4 class="m-0 fw-bold">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                    <?= ucfirst($action) ?> Location
                </h4>
            </div>

            <div class="card-body p-4">

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('Location/save'); ?>" autocomplete="off">

                    <input type="hidden" name="action" value="<?= $action ?>">
                    <input type="hidden" name="old_site_id" value="<?= $location->site_id ?? '' ?>">

                    <?php $readonly = ($action == 'view') ? 'readonly disabled' : ''; ?>

                    <!-- ROW 1 -->
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Site ID</label>
                            <input type="text" name="site_id" class="form-control" required
                                value="<?= $location->site_id ?? '' ?>" <?= $readonly ?>>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Site Number</label>
                            <input type="text" name="site_no" class="form-control" required
                                value="<?= $location->site_no ?? '' ?>" <?= $readonly ?>>
                        </div>
                    </div>

                    <!-- ROW 2 -->
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Site Name</label>
                            <input type="text" name="site_name" class="form-control" required
                                value="<?= $location->site_name ?? '' ?>" <?= $readonly ?>>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Access By</label>
                            <input type="text" name="access_by" class="form-control"
                                value="<?= $location->access_by ?? '' ?>" <?= $readonly ?>>
                        </div>
                    </div>

                    <!-- ROW 3 -->
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Last Visit</label>
                            <input type="datetime-local" name="last_visit" class="form-control"
                                value="<?= isset($location->last_visit)
                                            ? date('Y-m-d\TH:i', strtotime($location->last_visit))
                                            : '' ?>" <?= $readonly ?>>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Verify Asset</label>

                            <input type="hidden" name="verify_asset"
                                value="<?= $location->verify_asset ?? 1 ?>">

                            <input type="text" class="form-control" readonly
                                value="<?= (!empty($location->verify_asset) && $location->verify_asset == 1)
                                            ? 'Verified'
                                            : 'Not Verified' ?>">
                        </div>
                    </div>

                    <!-- ROW 4 -->
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-control" <?= $readonly ?>>
                                <option value="">Select Status</option>
                                <option value="1" <?= (!empty($location->status) && $location->status == 1) ? 'selected' : '' ?>>
                                    Active
                                </option>
                                <option value="0" <?= (!empty($location->status) && $location->status == 0) ? 'selected' : '' ?>>
                                    Inactive
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Access Flag</label>
                            <input type="text" name="access_flag" class="form-control"
                                value="<?= $location->access_flag ?? '' ?>" <?= $readonly ?>>
                        </div>
                    </div>

                    <!-- INVENTORY -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Inventory</label><br>

                            <input type="checkbox"
                                name="inventory_checked"
                                value="1"
                                <?= (!empty($location->inventory_checked) && $location->inventory_checked == 1)
                                    ? 'checked' : '' ?>
                                <?= ($action == 'view') ? 'disabled' : '' ?>>

                            <small class="text-muted d-block mt-1">
                                Checked = Assets will be marked as NOT verified
                            </small>
                        </div>
                    </div>

                    <!-- BUTTONS -->
                    <div class="text-center mt-4">
                        <?php if ($action != 'view'): ?>
                            <button class="btn btn-primary px-5 py-2 fw-semibold">
                                Save
                            </button>
                            <a href="<?= base_url('Location/list'); ?>"
                                class="btn btn-secondary px-4 py-2 ms-2">
                                Back
                            </a>
                        <?php else: ?>
                            <a href="<?= base_url('Location/list'); ?>"
                                class="btn btn-primary px-4 py-2 fw-semibold">
                                Back
                            </a>
                        <?php endif; ?>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>