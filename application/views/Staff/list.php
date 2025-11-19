<div class="card">
   <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Staff Details</h4>
        <a style="margin-left: 80%;" href="<?= base_url('Staff/add'); ?>" class="btn btn-primary">Add Staff</a>
    </div>

    <div class="card-body">

        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
        <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <table id="dtbl" class="table table-bordered table-striped" style="font-size:14px; vertical-align:middle;">


            <thead>
                <tr>
                    <!-- <th style="width:2.3vw">SrNO</th> -->
                    <th style="width:4vw">Staff ID</th>
                    <th style="width:6.6vw">Emp Name</th>
                    <th style="width:4vw">NFC Card No</th>
                    <th style="width:3vw">Job Role</th>
                    <th style="width:3vw">Join Date</th>
                    <th style="width:4vw">Phone NO</th>
                    <th style="width:4vw">Birth Date</th>
                    <th style="width: 3vw;">Status</th>
                    <th colspan="3" class="text-center" style="width: 5vw;">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($staffs): ?>
                    <?php foreach ($staffs as $count => $staff): ?>
                        <tr>
                            <td><?= ++$count ?></td>
                            <!-- <td><?= $staff->staff_id ?></td> -->
                            <td><?= $staff->emp_name ?></td>
                            <td><?= $staff->nfc_card ?></td>
                            <td><?= $staff->desig ?></td>
                            <td><?= $staff->join_dt ?></td>
                            <td><?= $staff->phn_no ?></td>
                            <td><?= $staff->birth_dt ?></td>
                            <td><?= $staff->staff_st ?></td>

                            <!-- VIEW -->
                            <td class="text-center">
                                <a href="<?= base_url('Staff/view/' . $staff->staff_id); ?>">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>

                            <!-- EDIT -->
                            <td class="text-center">
                                <a href="<?= base_url('Staff/edit/' . $staff->staff_id); ?>">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>

                            <!-- DELETE -->
                            <td class="text-center">
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