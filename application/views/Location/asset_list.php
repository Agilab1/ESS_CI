<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<style>
    .big-checkbox {
        width: 22px;
        height: 22px;
        transform: scale(1.3);
        cursor: not-allowed;
    }

    .verify-status {
        font-size: 18px;
        font-weight: 600;
    }
    .verify-ok {
        color: #0b0e0bff; /* green */
    }
    .verify-no {
        color: #0f0d0dff; /* red */
    }
</style>

<div class="d-flex justify-content-center align-items-center" style="min-height:100vh; background:#f4f6f9;">
    <div class="container" style="max-width:1100px;">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

            <!-- HEADER -->
            <div class="card-header bg-primary text-white py-3">
                <h4 class="m-0">
                    <i class="fa fa-th-large me-2"></i>
                    Site Asset Verification
                </h4>
            </div>

            <div class="card-body p-4">

                <!-- ================= SITE DETAILS ================= -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Site ID</label>
                        <input type="text" class="form-control"
                               value="<?= $site->site_id ?? '-' ?>" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Site No</label>
                        <input type="text" class="form-control"
                               value="<?= $site->site_no ?? '-' ?>" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Site Name</label>
                        <input type="text" class="form-control"
                               value="<?= $site->site_name ?? '-' ?>" readonly>
                    </div>
                </div>

                <!-- ================= VERIFIED / UNVERIFIED COUNT ================= -->
                <div class="row mb-4">
                    <div class="col-md-6 text-center">
                        <span class="verify-status verify-ok">
                            Verified Assets ✅ : <?= $verify_count['verified'] ?? 0 ?>
                        </span>
                    </div>

                    <div class="col-md-6 text-center">
                        <span class="verify-status verify-no">
                             Unverified Assets ❌ : <?= $verify_count['unverified'] ?? 0 ?>
                        </span>
                    </div>
                </div>

                <!-- ================= ASSET TABLE ================= -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">

                        <thead style="background:#bcdcff;">
                            <tr class="text-center">
                                <th style="width:60px;">#</th>
                                <th>Asset ID</th>
                                <th>Assdet ID</th>
                                <th>Serial No</th>
                                <th>Staff ID</th>
                                <th>Staff Name</th>
                                <th>Asset Name</th>
                                <th style="width:120px;">Verify</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php if (!empty($assets)): ?>
                            <?php $i = 1; foreach ($assets as $asset): ?>
                                <tr>
                                    <td class="text-center"><?= $i++; ?></td>
                                    <td><?= $asset->asset_id ?? '-' ?></td>
                                    <td><?= $asset->assdet_id ?? '-' ?></td>
                                    <td><?= $asset->serial_no ?? '-' ?></td>
                                    <td><?= $asset->staff_id ?? '-' ?></td>
                                    <td><?= $asset->emp_name ?? '-' ?></td>
                                    <td><?= $asset->asset_name ?? '-' ?></td>

                                    <!-- VERIFIED FLAG -->
                                    <td class="text-center">
                                        <input type="checkbox"
                                               class="big-checkbox"
                                               <?= ((int)($asset->verified ?? 0) === 1) ? 'checked' : '' ?>
                                               disabled>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No assets found for this site
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>

                    </table>
                </div>

                <!-- ================= BACK BUTTON ================= -->
                <div class="text-center mt-4">
                    <a href="<?= base_url('Location/list'); ?>"
                       class="btn btn-secondary px-4 py-2">
                        <i class="fa fa-arrow-left me-1"></i>
                        Back to Location List
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
