<style>
    .asset-image-box {
        display: inline-block;
        padding: 8px;
        border-radius: 12px;
        background: #f8f9fa;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }



    .file-input-fixed {
        height: 40px !important;
        /* normal bootstrap input height */
    }

    .asset-thumb {
        width: 320px;
        height: 150px;
        object-fit: cover;
        border-radius: 10px;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .asset-thumb:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.15);
    }

    @media (max-width: 576px) {
        .asset-thumb {
            width: 100%;
            height: auto;
            max-width: 220px;
        }

        .asset-image-box {
            padding: 6px;
        }
    }
</style>

<?php

$isView = ($action === 'view');
$isEdit = ($action === 'edit');

$disabledView   = $isView ? 'readonly' : '';
$disabledSelect = $isView ? 'disabled' : '';
$readonlySerial = ($isView || $isEdit) ? 'readonly' : '';

$detail = $detail ?? (object)[
    'assdet_id' => '',
    'serial_no' => '',
    'site_id'   => '',
    'staff_id'  => '',
    'department_id' => '',
    'model_no'  => '',
    'descr'     => '',
    'net_val'   => '',
    'status'    => 1,
    'image'     => '',
];

if (!isset($loginUser)) {
    $loginUser = (object)[
        'staff_id' => null,
        'site_no'  => null
    ];
}
// === NEW: Auto-fill logged-in user's staff & site in View mode ===
if ($isView) {

    // ===== Resolve logged-in user's STAFF =====
    if (empty($detail->staff_id) && !empty($loginUser->staff_id)) {

        foreach ($staffs as $st) {
            if (strpos($loginUser->staff_id, $st->emp_name) !== false) {
                $detail->staff_id = $st->staff_id;
                break;
            }
        }
    }

    // ===== Resolve logged-in user's SITE =====
    if (empty($detail->site_id) && !empty($loginUser->site_no)) {

        foreach ($sites as $s) {
            if ($s->site_no == $loginUser->site_no || $s->site_name == $loginUser->site_no) {
                $detail->site_id = $s->site_id;
                break;
            }
        }
    }
}

if ($isView && empty($detail->site_id) && !empty($loginUser->site_no)) {
    foreach ($sites as $s) {
        if ($s->site_name == $loginUser->site_no || $s->site_id == $loginUser->site_no) {
            $detail->site_id = $s->site_id;
            break;
        }
    }
}
?>

<div class="d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="container" style="max-width:900px;">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

            <div class="card-header py-3 d-flex align-items-center justify-content-between bg-primary text-white ">
                <!-- <div class="card-header bg-primary text-white py-3"> -->
                <h4 class="m-0 fw-bold">
                    <i class="fa fa-th-large me-2"></i>
                    <?= ucfirst($action) ?> Asset Detail — <?= $asset->asset_name ?>
                </h4>

                <!-- <h4 class="m-0">
                    <?= ucfirst($action) ?> Asset Detail — <?= $asset->asset_name ?>
                </h4> -->

                <?php if ($isView): ?>
                    <div class="d-flex align-items-center">

                        <form method="post" action="<?= base_url('Asset/updateStaff'); ?>" class="d-flex align-items-center">
                            <input type="hidden" name="assdet_id" value="<?= $detail->assdet_id ?>">

                            <select name="staff_id" id="staffSelect" class="form-control form-control-sm" disabled>
                                <?php foreach ($staffs as $s): ?>
                                    <option value="<?= $s->staff_id ?>" <?= $loginUser->staff_id == $s->staff_id ? 'selected' : '' ?>>
                                        <?= $s->emp_name ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <button type="button" id="staffBtn" class="btn btn-primary border-white  btn-sm ms-2">
                                <i class="fas fa-user-edit"></i>
                            </button>
                        </form>

                        <div style="width:15px;"></div>

                        <form method="post" action="<?= base_url('Asset/updateSite'); ?>" class="d-flex align-items-center">
                            <input type="hidden" name="assdet_id" value="<?= $detail->assdet_id ?>">

                            <select name="site_id" id="siteSelect" class="form-control form-control-sm" disabled>
                                <?php foreach ($sites as $s): ?>
                                    <option value="<?= $s->site_id ?>"
                                        <?= (!empty($loginUser->site_no) && $loginUser->site_no == $s->site_no) ? 'selected' : '' ?>>
                                        <?= $s->site_name ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <button type="button" id="siteBtn" class="btn btn-primary border-white btn-sm ms-2">
                                <i class="fas fa-map-marker-alt"></i>
                            </button>
                        </form>

                    </div>
                <?php endif; ?>
            </div>



            <div class="card-body p-4">
                                <!-- FLASH MESSAGES -->
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success auto-hide">
                        <?= $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger auto-hide">
                        <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>


                <form method="post" id="assetForm" action="<?= base_url('asset/save_detail') ?>" enctype="multipart/form-data">

                    <input type="hidden" name="action" value="<?= $action ?>">
                    <input type="hidden" name="asset_id" value="<?= $asset->asset_id ?>">
                    <input type="hidden" name="assdet_id" value="<?= $detail->assdet_id ?>">
                    <div class="table-responsive">
                        <table class="table table-bordered">

                            <tr>
                                <!-- RIGHT TD : FILE INPUT -->
                                <td class="align-middle">
                                    <label class="fw-bold d-block mb-2">Upload Image</label>

                                    <input type="file" name="asset_image"
                                        class="form-control file-input-fixed"
                                        accept="image/*"
                                        <?= $isView ? 'disabled' : '' ?>>
                                </td>
                                <!-- LEFT TD : IMAGE -->
                                <td class="text-center align-middle">
                                    <label class="fw-bold d-block mb-2 text-start">Asset Image</label>

                                    <?php if (!empty($detail->image)): ?>
                                        <div class="asset-image-box mx-auto">
                                            <img src="<?= base_url('uploads/assets/' . $detail->image) ?>"
                                                class="asset-thumb"
                                                data-toggle="modal"
                                                data-target="#imageModal">


                                        </div>

                                        <div class="fw-bold small mt-2" style="white-space:nowrap;">
                                            <?= $asset->asset_name ?>
                                            <?php if (!empty($detail->serial_no)): ?> - <?= $detail->serial_no ?> <?php endif; ?>
                                            <?php if (!empty($detail->model_no)): ?> - <?= $detail->model_no ?> <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-muted small mt-1">No Image</div>
                                    <?php endif; ?>
                                </td>


                            </tr>
                    </div>
                    <tr>
                        <td>
                            <label>Serial No</label>
                            <input type="text" name="serial_no" class="form-control"
                                value="<?= $detail->serial_no ?>" <?= $readonlySerial ?> required>
                        </td>

                        <td>
                            <label>Model No</label>
                            <input type="text" name="model_no" class="form-control"
                                value="<?= isset($detail->model_no) ? $detail->model_no : '' ?>" <?= $disabledView ?>>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label>Description</label>
                            <input type="text" name="descr" class="form-control"
                                value="<?= isset($detail->descr) ? $detail->descr : '' ?>" <?= $disabledView ?>>
                        </td>

                        <td>
                            <label>Site</label>
                            <select name="site_id" class="form-control" <?= $disabledSelect ?>>
                                <?php foreach ($sites as $s): ?>
                                    <option value="<?= $s->site_id ?>" <?= $detail->site_id == $s->site_id ? 'selected' : '' ?>>
                                        <?= $s->site_name ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label>Department</label>
                            <?php $currentDept = isset($detail->department_id) ? $detail->department_id : ''; ?>
                            <select name="department_id" class="form-control" <?= $disabledSelect ?>>
                                <?php foreach ($departments as $d): ?>
                                    <option value="<?= $d->department_id ?>" <?= $currentDept == $d->department_id ? 'selected' : '' ?>>
                                        <?= $d->department_name ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>

                        <td id="staffBox">
                            <label>Staff</label>
                            <select name="staff_id" id="staffMain" class="form-control" <?= $disabledSelect ?>>



                                <?php foreach ($staffs as $st): ?>
                                    <option value="<?= $st->staff_id ?>" <?= $detail->staff_id == $st->staff_id ? 'selected' : '' ?>>
                                        <?= $st->emp_name ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label>Net Value</label>
                            <input type="number" name="net_val" class="form-control"
                                value="<?= isset($detail->net_val) ? $detail->net_val : '' ?>" <?= $disabledView ?>>
                        </td>

                        <td>
                            <label>Status</label>
                            <select name="status" class="form-control" <?= $disabledSelect ?>>
                                <option value="1" <?= $detail->status == 1 ? 'selected' : '' ?>>Active</option>
                                <option value="0" <?= $detail->status == 0 ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" class="text-center pt-3">
                            <?php if (!$isView): ?>
                                <button class="btn btn-primary">Save</button>
                            <?php endif; ?>
                            <a href="<?= base_url('asset/serials/' . $asset->asset_id) ?>" class="btn btn-secondary">Back</a>
                        </td>
                    </tr>

                    </table>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- IMAGE PREVIEW MODAL -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <?php if (!empty($detail->image)): ?>
                    <img src="<?= base_url('uploads/assets/' . $detail->image) ?>" class="img-fluid">
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('staffBtn')?.addEventListener('click', function() {
        const s = document.getElementById('staffSelect');
        if (s.disabled) {
            s.disabled = false;
            s.focus();
        } else {
            this.closest('form').submit();
        }
    });

    document.getElementById('siteBtn')?.addEventListener('click', function() {
        const s = document.getElementById('siteSelect');
        if (s.disabled) {
            s.disabled = false;
            s.focus();
        } else {
            this.closest('form').submit();
        }
    });

    // ================== OWNERSHIP UI CONTROL ==================
    document.addEventListener('DOMContentLoaded', function() {

        const ownership = "<?= $asset->ownership_type ?>";

        const headerStaff = document.getElementById('headerStaffBox');
        const mainStaff = document.getElementById('staffBox');

        if (ownership === 'department') {
            if (headerStaff) headerStaff.style.display = 'none';
            if (mainStaff) mainStaff.style.display = 'none';
        }
    });
    document.getElementById('staffBtn')?.addEventListener('click', function() {
        const select = document.querySelector('#staffSelect');
        if (!select) return;

        if (select.disabled) {
            select.disabled = false;
            select.focus();
        } else {
            select.form.submit();
        }
    });

    document.getElementById('siteBtn')?.addEventListener('click', function() {
        const select = document.querySelector('#siteSelect');
        if (!select) return;

        if (select.disabled) {
            select.disabled = false;
            select.focus();
        } else {
            select.form.submit();
        }
    });
    setTimeout(function() {
    document.querySelectorAll('.auto-hide').forEach(function(el) {
        el.style.transition = '0.5s';
        el.style.opacity = '0';
        setTimeout(() => el.remove(), 500);
    });
}, 2500);
</script>
<!-- <script>

</script> -->