<div class="card">
    <div class="card-header">
        <!-- Optional Add Button -->
        <!-- <a href="<?= base_url('Staff/add'); ?>" class="btn btn-primary float-right">Add Staff</a> -->
        <a href="<?= base_url('Staff/add'); ?>"> <button class="btn btn-primary float-right"> Add Staff</button></a>



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
                    <th style="width:2.3vw">SrNO</th>
                    <th style="width:4vw">Staff ID</th>
                    <th style="width:6.6vw">Employee Name</th>
                    <th style="width:4.8vw">NFC CardNo</th>
                    <th style="width:4vw">Job Role</th>
                    <th style="width:4vw">Join Date</th>
                    <th style="width:5vw">Phone NO</th>
                    <th style="width:5vw">Birth Date</th>
                    <th style="width: 3vw;">Status</th>
                    <th class="text-center">View</th>
                    <th class="text-center">Edit</th>
                    <th style="width:3vw" class="text-center">Delete</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($staffs): ?>
                    <?php foreach ($staffs as $count => $staff): ?>
                        <tr>
                            <td><?= ++$count ?></td>
                            <td><?= $staff->staff_id ?></td>
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