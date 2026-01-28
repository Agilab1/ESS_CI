<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
    /* ===== TABLE COLUMN WIDTH EXTRA COMPACT ===== */
    .col-num {
        width: 55px !important;
        padding-left: 4px !important;
        padding-right: 4px !important;
    }

    .col-id {
        width: 125px !important;
        padding-left: 6px !important;
        padding-right: 6px !important;
    }

    .col-verify {
        width: 95px !important;
        padding-left: 4px !important;
        padding-right: 4px !important;
    }

    /* checkbox bilkul tight */
    .col-verify input {
        margin: 0;
    }

    #dtbl td:nth-child(2),
    #dtbl th:nth-child(2) {
        text-align: center !important;
    }

    /* ===== CHECKBOX ===== */
    .big-checkbox {
        width: 22px;
        height: 22px;
        transform: scale(1.2);
        cursor: not-allowed;
        appearance: none;
        -webkit-appearance: none;
        border-radius: 4px;
        border: 1px solid grey;
        background-color: #ffffff;
        position: relative;
    }

    .big-checkbox:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

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

    .big-checkbox:disabled {
        opacity: 1 !important;
    }

    /* ===== HEADER FLEX ===== */
    .header-flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }

    /* ===== INPUT FIELD TYPE (COUNT AT END) ===== */
    .verify-input-wrap {
        display: flex;
        gap: 18px;
    }

    .verify-input {
        display: flex;
        align-items: center;
        background: #ffffff;
        border-radius: 6px;
        border: 1px solid #ced4da;
        height: 36px;
        min-width: 220px;
        overflow: hidden;
    }

    .verify-input .label {
        padding: 0 12px;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        flex: 1;
    }

    .verify-input .count {
        height: 100%;
        min-width: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #fff;
        border-left: 1px solid #ced4da;
    }

    .verify-input.total .count {
        background: #6c757d;
    }

    .verify-input.verified .count {
        background: #0d6efd;
    }

    .verify-input.unverified .count {
        background: #dc3545;
    }

    @media (max-width: 768px) {
        .verify-input {
            min-width: 100%;
        }
    }
</style>

<div class="d-flex justify-content-center align-items-center" style="min-height:100vh; background:#f4f6f9;">
    <div class="container" style="max-width:1100px;">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

            <!-- ================= HEADER ================= -->
            <div class="card-header bg-primary text-white py-3">
                <div class="header-flex">

                    <h4 class="m-0">
                        <i class="fa fa-th-large me-2"></i>
                        Site Asset Verification
                    </h4>

                    <!-- TOTAL / VERIFIED / UNVERIFIED -->
                    <div class="verify-input-wrap d-flex flex-wrap gap-2">

                        <!-- TOTAL -->
                        <div class="verify-input total">
                            <span class="label text-dark">
                                <i class="bi bi-collection-fill"></i>
                                Total
                            </span>
                            <span class="count" id="total_count">
                                <?= ($verify_count['verified'] ?? 0) + ($verify_count['unverified'] ?? 0) ?>
                            </span>
                        </div>

                        <!-- VERIFIED -->
                        <div class="verify-input verified">
                            <span class="label text-success">
                                <i class="bi bi-check-circle-fill"></i>
                                Verified
                            </span>
                            <span class="count" id="verified_count">
                                <?= $verify_count['verified'] ?? 0 ?>
                            </span>
                        </div>

                        <!-- UNVERIFIED -->
                        <div class="verify-input unverified">
                            <span class="label text-danger">
                                <i class="bi bi-x-circle-fill"></i>
                                Unverified
                            </span>
                            <span class="count" id="unverified_count">
                                <?= $verify_count['unverified'] ?? 0 ?>
                            </span>
                        </div>

                    </div>
                </div>
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

                <!-- ================= ASSET TABLE ================= -->
                <div class="table-responsive">
                    <table id="dtbl" class="table table-bordered table-striped">
                        <thead style="background:#bcdcff;">
                            <tr class="text-center">
                                <th class="col-num">#</th>
                                <th class="col-id">Assdet ID</th>
                                <th>Serial No</th>
                                <th>Asset Name</th>
                                <th>Staff Name</th>
                                <th class="col-verify">Verify</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($assets)): ?>
                                <?php $i = 1;
                                foreach ($assets as $asset): ?>
                                    <tr>
                                        <td class="text-center"><?= $i++; ?></td>
                                        <td><?= $asset->assdet_id ?? '-' ?></td>
                                        <td><?= $asset->serial_no ?? '-' ?></td>
                                        <td><?= $asset->asset_name ?? '-' ?></td>
                                        <td><?= $asset->emp_name ?? '-' ?></td>
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
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No assets found for this site
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                


                <!-- BACK -->
                <div class="text-center mt-4">
                    <a href="<?= base_url('Location/list'); ?>" class="btn btn-secondary px-4 py-2">
                        <i class="fa fa-arrow-left me-1"></i> Back to Location List
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    function checkVerification(id) {
        fetch("<?= base_url('Asset/check_verify_ajax/') ?>" + id)
            .then(r => r.json())
            .then(d => {
                if (d.verified === 1) {
                    let cb = document.getElementById("verify_" + id);
                    if (cb && !cb.checked) cb.checked = true;
                }
            });
    }

    function updateCounts() {
        fetch("<?= base_url('Location/get_verify_count_ajax/' . $site->site_id) ?>")
            .then(r => r.json())
            .then(d => {
                document.getElementById("verified_count").innerText = d.verified;
                document.getElementById("unverified_count").innerText = d.unverified;
                document.getElementById("total_count").innerText =
                    parseInt(d.verified) + parseInt(d.unverified);
            });
    }

    setInterval(function() {
        <?php foreach ($assets as $a): ?>
            checkVerification(<?= $a->assdet_id ?>);
        <?php endforeach; ?>
        updateCounts();
    }, 3000);
</script>