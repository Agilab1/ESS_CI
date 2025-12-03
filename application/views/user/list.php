<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Users Details</h4>
        <a style="margin-left: 80%;" href="<?= base_url('User/add'); ?>" class="btn btn-primary">Add Users</a>
    </div>

    <div class="card-body">

        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
        <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <div class="table-responsive">
            <table id="dtbl" class="table table-bordered table-striped">

                <thead class="btn-primary">
                    <tr>
                        <th style="width: 4vw;">UserID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th style="width: 5vw;" class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($users)) : ?>
                        <?php foreach ($users as $count => $user): ?>
                            <tr>

                                <td><?= ++$count ?></td>
                                <td><?= $user->user_nm ?? '' ?></td>
                                <td><?= $user->mail_id ?? '' ?></td>
                                <td><?= $user->user_ph ?? '' ?></td>
                                <td><?= $user->role_id ?? '' ?></td>
                                <td><?= $user->user_ty ?? '' ?></td>

                                <!-- Checkbox Status -->
                                <td class="text-center">
                                    <input type="checkbox"
                                        <?= ($user->user_st ?? '') == 'Active' ? 'checked' : '' ?>
                                        style="width:18px;height:10px;margin-top:10px;transform: scale(1.4);cursor: not-allowed;">
                                </td>

                                <!-- ACTION BUTTONS COMBINED IN ONE TD -->
                                <td class="text-center" style="white-space: nowrap;">

                                    <a href="<?= base_url('user/view/' . $user->user_id) ?>" class="mx-1">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <a href="<?= base_url('user/edit/' . $user->user_id) ?>" class="mx-1">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a href="<?= base_url('user/delete_user/' . $user->user_id) ?>"
                                        onclick="return confirm('Delete this user?');" class="mx-1">
                                        <i class="fa fa-trash text-danger"></i>
                                    </a>

                                </td>

                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center text-danger">No Users Found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>

    </div>
</div>