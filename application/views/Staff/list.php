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
</style>

<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
        <h4 class="mb-2 mb-md-0">Staff Details</h4>

        <a style="margin-left: 80%;" href="<?= base_url('Staff/add'); ?>" class="btn btn-primary mt-2 mt-md-0">
            Add Staff
        </a>
    </div>

    <div class="card-body">

        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success flash-msg"><?= $this->session->flashdata('success'); ?></div>
        <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger flash-msg"><?= $this->session->flashdata('error'); ?></div>
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
                        <th>Asset List</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if ($staffs): ?>
                        <?php foreach ($staffs as $staff): ?>
                            <tr>

                                <!-- QR Code Button -->
                                <td class="text-center">
                                    <a href="<?= base_url('Staff/emp_list/' . $staff->staff_id . '?date=' . date('Y-m-d')) ?>">
                                        <i class="fas fa-qrcode"></i>
                                    </a>
                                </td>

                                <td><?= $staff->staff_id ?></td>
                                <td><?= $staff->emp_name ?></td>
                                <td><?= $staff->nfc_card ?></td>
                                <td><?= $staff->desig ?></td>
                                <td><?= $staff->join_dt ?></td>
                                <td><?= $staff->phn_no ?></td>
                                <td><?= $staff->birth_dt ?></td>
                                <td class="text-center">
                                <a href="<?= base_url('Staff/asset_form/' . $staff->staff_id); ?>" title="View Assets">
                                    <i class="fa fa-qrcode"></i>
                                </a>
                                </td>
                                <td><?= $staff->staff_st ?></td>

                                <td class="text-center">
                                    <a href="<?= base_url('Staff/view/' . $staff->staff_id); ?>">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    &nbsp;&nbsp;
                                    <a href="<?= base_url('Staff/edit/' . $staff->staff_id); ?>">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    &nbsp;&nbsp;
                                    <a href="<?= base_url('Staff/delete/' . $staff->staff_id); ?>"
                                        onclick="return confirm('Delete this user?');">
                                        <i class="fa fa-trash text-danger"></i>
                                    </a>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>

    </div>
</div>

<script>
    // Flash message auto hide after 6 seconds
    setTimeout(function () {
        const flash = document.querySelector('.flash-msg');
        if (flash) {
            flash.style.transition = "opacity 0.5s ease";
            flash.style.opacity = "0";

            setTimeout(() => {
                if (flash) flash.remove();
            }, 500);
        }
    }, 6000);
</script>