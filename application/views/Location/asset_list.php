<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<style>
    .big-checkbox {
        width: 22px;
        height: 22px;
        transform: scale(1.2);
        cursor: not-allowed;

        /* remove native checkbox */
        appearance: none;
        -webkit-appearance: none;

        border-radius: 4px;
        border: 1px solid grey;
        background-color: #ffffff;
        position: relative;
    }

    /*  Checked state = blue box */
    .big-checkbox:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    /* white tick */
    .big-checkbox:checked::after {
        content: "";
        position: absolute;
        left: 6px;
        top: 2px;
        width: 6px;
        height: 12px;
        border: solid #ffffff;
        border-width: 0 3px 3px 0;
        transform: rotate(45deg);
    }

    /* Disabled but still visible */
    .big-checkbox:disabled {
        opacity: 1 !important;
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
                            Verified Assets <i class="bi bi-check-square-fill text-primary"></i> : <?= $verify_count['verified'] ?? 0 ?>
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
                                <th style="width:100px;">Asset ID</th>
                                <th>Serial No</th>
                                <th>Asset Name</th>

                                <th>Staff Name</th>
                                <th style="width:100px;">Assdet ID</th>

                                <!-- <th style="width:100px;">Staff ID</th> -->


                                <th style="width:100px;">Verify</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($assets)): ?>
                                <?php $i = 1;
                                foreach ($assets as $asset): ?>
                                    <tr>
                                        <td class="text-center"><?= $i++; ?></td>
                                        <td><?= $asset->asset_id ?? '-' ?></td>
                                        <td><?= $asset->serial_no ?? '-' ?></td>
                                        <td><?= $asset->asset_name ?? '-' ?></td>

                                        <td><?= $asset->emp_name ?? '-' ?></td>
                                        <td><?= $asset->assdet_id ?? '-' ?></td>

                                        <!-- <td><?= $asset->staff_id ?? '-' ?></td> -->



                                        <!-- VERIFIED FLAG -->
                                        <td class="text-center">
                                            <input type="checkbox"
                                                class="big-checkbox"
                                                id="verify_<?= $asset->assdet_id ?>"
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

<script>
    function checkVerification(assdetId) {
        fetch("<?= base_url('Asset/check_verify_ajax/') ?>" + assdetId)
            .then(r => r.json())
            .then(d => {
                if (d.verified === 1) {
                    let cb = document.getElementById("verify_" + assdetId);
                    if (cb && !cb.checked) {
                        cb.checked = true;
                        cb.closest("tr").style.background = "#e6fffa";
                    }
                }
            });
    }

    // 
    setInterval(function() {
        <?php foreach ($assets as $a): ?>
            checkVerification(<?= $a->assdet_id ?>);
        <?php endforeach; ?>
    }, 3000);
</script>