<style>
    /* ===== Card Header Right Align Fix ===== */
    .card-header {
        position: relative;
    }

    /* Desktop view */
    @media (min-width: 768px) {
        .card-header a.btn {
            margin-left: auto !important;
        }
    }

    /* Mobile view */
    @media (max-width: 767px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .card-header a.btn {
            width: 100%;
            text-align: center;
            margin-top: 10px;
        }
    }
</style>
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
        <h4 class="mb-0">Users Details</h4>
        <a href="<?= base_url('User/add'); ?>" class="btn btn-primary mt-2 mt-md-0">
            Add Users
        </a>
    </div>

    <div class="card-body">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success flash-msg"><?= $this->session->flashdata('success'); ?></div>
        <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger flash-msg"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>


        <div class="table-responsive w-100" style="overflow-x:auto; -webkit-overflow-scrolling: touch;">

            <table id="dtbl" class="table table-bordered table-striped mb-0 table-hover">

                <thead class="btn-primary sticky-top text-white">
                    <tr>
                        <th style="width: 6vh;" class="text-nowrap">UserID</th>
                        <th style="width: 6vh;" class="text-nowrap">Name</th>
                        <th style="width: 10vh;" class="text-nowrap">Email</th>
                        <th class="text-nowrap">Phone</th>
                        <th class="text-nowrap">Role</th>
                        <th class="text-nowrap">Type</th>
                        <th class="text-nowrap">Staff ID</th>
                        <th class="text-nowrap">Site No</th>
                        <th class="text-nowrap">Asset No</th>
                        <th style="width: 4vh;" class="text-nowrap">Status</th>
                        <th class="text-center text-nowrap">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($users)) : ?>
                        <?php foreach ($users as $count => $user): ?>
                            <tr>
                                <td><?= ++$count ?></td>
                                <td class="text-break"><?= $user->user_nm ?? '' ?></td>
                                <td class="text-break"><?= $user->mail_id ?? '' ?></td>
                                <td><?= $user->user_ph ?? '' ?></td>
                                <td>
                                    <?= ($user->role_id == 1 ? 'Admin' : ($user->role_id == 2 ? 'User' : '-')) ?>
                                </td>


                                <td><?= $user->user_ty ?? '' ?></td>
                                <td><?= $user->staff_id ?> - <?= $user->emp_name ?? '' ?></td>
                                <td><?= $user->site_no ?? '' ?></td>
                                <td><?= $user->asset_no ?? '' ?></td>

                                <!-- Checkbox Status -->
                                <td class="text-center">
                                    <input type="checkbox"
                                        <?= ($user->user_st ?? '') == 'Active' ? 'checked' : '' ?>
                                        class="form-check-input"
                                        style="transform:scale(1.4); cursor:not-allowed;">
                                </td>

                                <!-- Action Buttons -->
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
                            <td colspan="11" class="text-center text-danger">No Users Found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>


    </div>
</div>

<script>
    // Flash message auto hide after 6 seconds
    setTimeout(function() {
        const flash = document.querySelector('.flash-msg');
        if (flash) {
            flash.style.transition = "opacity 0.5s ease";
            flash.style.opacity = "0";
            setTimeout(() => flash.remove(), 500);
        }
    }, 6000);
</script>