<?php
$isAdmin = ((int)$this->session->userdata('role_id') === 1);
?>

<style>
    th {
        white-space: nowrap !important;
        writing-mode: horizontal-tb !important;
        transform: rotate(0deg) !important;
        text-orientation: mixed !important;
    }

    td {
        white-space: nowrap;
    }

    table {
        table-layout: auto !important;
    }

    /* 🔒 Disabled action icons (USER) */
    .disabled-action {
        pointer-events: none;
        opacity: 0.35;
        filter: grayscale(100%);
        cursor: not-allowed;
    }

    input[type="checkbox"][disabled] {
        cursor: not-allowed;
        opacity: 0.6;
    }

    .status-checkbox {
        pointer-events: none;
        opacity: 1;
    }

    .status-checkbox:disabled {
        opacity: 1;
    }

    .status-checkbox {
        transform: scale(1.05);
    }
</style>

<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
        <h4 class="mb-2 mb-md-0">Staff Details</h4>

        <!-- Add Staff sirf ADMIN ko -->
        <?php if ($isAdmin): ?>
            <a href="<?= base_url('Staff/add'); ?>" style="margin-right:-83%;" class="btn btn-primary mt-2 mt-md-0">
                Add Staff
            </a>
        <?php endif; ?>
    </div>

    <div class="card-body">

        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success flash-msg">
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger flash-msg">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table id="dtbl" class="table table-bordered table-striped align-middle" style="font-size: 14px;">
                <thead class="btn-primary">
                    <tr>
                        <th>Q</th>
                        <th>Staff ID</th>
                        <th>Emp Name</th>
                        <th>NFC CardNo</th>
                        <th>Job Role</th>
                        <th>Join Date</th>
                        <th>Phone NO</th>
                        <th>Birth Date</th>
                        <th>Asset list</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($staffs as $staff): ?>
                        <tr>

                            <td class="text-center">
                                <a href="<?= base_url('Staff/emp_list/' . $staff->staff_id . '?date=' . date('Y-m-d')) ?>">
                                    <i class="fas fa-qrcode"></i>
                                </a>
                            </td>

                            <td><?= $staff->staff_id ?></td>
                            <td><?= $staff->emp_name ?></td>
                            <td><?= $staff->nfc_card ?></td>
                            <td><?= $staff->desig ?></td>
                            <td><?= date('d-m-Y', strtotime($staff->join_dt)) ?></td>
                            <td><?= $staff->phn_no ?></td>
                            <td><?= date('d-m-Y', strtotime($staff->birth_dt)) ?></td>

                            <td class="text-center">
                                <a href="<?= base_url('Staff/asset_form/' . $staff->staff_id); ?>">
                                    <i class="fa fa-qrcode"></i>
                                </a>
                            </td>

                            <td class="text-center">
                                <input
                                    type="checkbox"
                                    class="form-check-input status-checkbox"
                                    <?= ($staff->staff_st === 'Active') ? 'checked' : '' ?>
                                    readonly
                                    tabindex="-1">
                            </td>



                            <!-- ACTION -->
                            <td class="text-center">

                                <!-- 👁 VIEW -->
                                <a href="<?= base_url('Staff/view/' . $staff->staff_id); ?>">
                                    <i class="fa fa-eye text-primary"></i>
                                </a>

                                &nbsp;&nbsp;

                                <!-- ✏️ EDIT -->
                                <a href="<?= base_url('Staff/edit/' . $staff->staff_id); ?>"
                                    class="<?= !$isAdmin ? 'disabled-action' : '' ?>"
                                    title="<?= !$isAdmin ? 'No permission' : '' ?>">
                                    <i class="fa fa-edit text-info"></i>
                                </a>

                                &nbsp;&nbsp;

                                <!-- 🗑 DELETE -->
                                <a href="<?= base_url('Staff/delete/' . $staff->staff_id); ?>"
                                    class="<?= !$isAdmin ? 'disabled-action' : '' ?>"
                                    <?= $isAdmin ? "onclick=\"return confirm('Delete this user?');\"" : '' ?>
                                    title="<?= !$isAdmin ? 'No permission' : '' ?>">
                                    <i class="fa fa-trash text-danger"></i>
                                </a>

                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>

    </div>
</div>

<script>
    setTimeout(function() {
        const flash = document.querySelector('.flash-msg');
        if (flash) {
            flash.style.transition = "opacity 0.5s ease";
            flash.style.opacity = "0";
            setTimeout(() => flash.remove(), 500);
        }
    }, 6000);
</script>