<style>
    .admin-wrap {
        gap: 20px;
    }

    .admin-check {
        width: 22px;
        height: 22px;
        cursor: pointer;
        vertical-align: middle;
    }

    .admin-check:disabled {
        cursor: not-allowed;
    }
</style>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="m-0 fw-bold">
                            <i class="fa fa-user-plus" aria-hidden="true"></i>
                            <?= isset($action) ? ucfirst($action) : 'Add' ?> User
                        </h4>
                    </div>

                    <div class="card-body">
                        <form method="post" action="<?= base_url('user/save') ?>" id="userform" autocomplete="off">

                            <table class="table table-bordered">

                                <!-- hidden -->
                                <input type="hidden" name="action" value="<?= isset($action) ? strtolower($action) : 'add' ?>">
                                <input type="hidden" name="user_id" value="<?= isset($user->user_id) ? $user->user_id : '' ?>">

                                <!-- Email -->
                                <tr>
                                    <td colspan="2">
                                        <label class="form-label">Email ID</label>
                                        <input class="form-control" type="email" name="mail_id"
                                            value="<?= set_value('mail_id', isset($user->mail_id) ? $user->mail_id : '') ?>"
                                            <?= ($action == 'view') ? 'readonly' : 'required' ?>>
                                        <small class="text-danger"><?= form_error('mail_id'); ?></small>
                                    </td>
                                </tr>

                                <!-- Name / Phone -->
                                <tr>
                                    <td>
                                        <label class="form-label">User Name</label>
                                        <input class="form-control" type="text" name="user_nm"
                                            value="<?= set_value('user_nm', isset($user->user_nm) ? $user->user_nm : '') ?>"
                                            <?= ($action == 'view') ? 'readonly' : 'required' ?>>
                                        <small class="text-danger"><?= form_error('user_nm'); ?></small>
                                    </td>

                                    <td>
                                        <label class="form-label">Phone No</label>
                                        <input class="form-control" type="text" name="user_ph"
                                            value="<?= set_value('user_ph', isset($user->user_ph) ? $user->user_ph : '') ?>"
                                            <?= ($action == 'view') ? 'readonly' : 'required' ?>>
                                        <small class="text-danger"><?= form_error('user_ph'); ?></small>
                                    </td>
                                </tr>

                                <!-- Password -->
                                <?php if ($action != 'view'): ?>
                                    <tr>
                                        <td>
                                            <label class="form-label">Password</label>
                                            <input class="form-control" type="password" name="pass_wd" required>
                                            <small class="text-danger"><?= form_error('pass_wd'); ?></small>
                                        </td>

                                        <td>
                                            <label class="form-label">Confirm Password</label>
                                            <input class="form-control" type="password" name="cpas_wd" required>
                                            <small class="text-danger"><?= form_error('cpas_wd'); ?></small>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                                <!-- Role / Status -->
                                <tr>
                                    <td>
                                        <label class="form-label">User Role</label>
                                        <select name="role_id" class="form-control"
                                            <?= ($action == 'view') ? 'disabled' : 'required' ?>>
                                            <option value="">Select Role</option>
                                            <option value="1" <?= (isset($user) && $user->role_id == 1) ? 'selected' : '' ?>>Admin</option>
                                            <option value="2" <?= (isset($user) && $user->role_id == 2) ? 'selected' : '' ?>>User</option>
                                        </select>
                                        <small class="text-danger"><?= form_error('role_id'); ?></small>
                                    </td>

                                    <td>
                                        <label class="form-label">User Status</label>
                                        <select class="form-control" name="user_st"
                                            <?= ($action == 'view') ? 'disabled' : 'required' ?>>
                                            <option value="">Select Status</option>
                                            <option value="Active" <?= (isset($user->user_st) && $user->user_st == "Active") ? 'selected' : '' ?>>Active</option>
                                            <option value="Inactive" <?= (isset($user->user_st) && $user->user_st == "Inactive") ? 'selected' : '' ?>>Inactive</option>
                                        </select>
                                        <small class="text-danger"><?= form_error('user_st'); ?></small>
                                    </td>
                                </tr>

                                <!-- Type / Admin -->
                                <tr>
                                    <td>
                                        <label class="form-label">User Type</label>
                                        <select class="form-control" name="user_ty"
                                            <?= ($action == 'view') ? 'disabled' : 'required' ?>>
                                            <option value="">Select Type</option>
                                            <option value="User" <?= (isset($user->user_ty) && $user->user_ty == "User") ? 'selected' : '' ?>>User</option>
                                            <option value="Manager" <?= (isset($user->user_ty) && $user->user_ty == "Manager") ? 'selected' : '' ?>>Manager</option>
                                        </select>
                                        <small class="text-danger"><?= form_error('user_ty'); ?></small>
                                    </td>

                                    <td class="align-middle">
                                        <div class="d-flex align-items-center admin-wrap">
                                            <label class="form-label mb-0">Is Admin</label>
                                            <input type="checkbox"
                                                class="admin-check"
                                                <?= (isset($user->user_ad) && $user->user_ad == "1") ? 'checked' : '' ?>
                                                <?= ($action == 'view') ? 'disabled' : '' ?>>
                                        </div>
                                    </td>







                                </tr>

                                <!-- READ ONLY FIELDS (ADD / EDIT / VIEW) -->
                                <tr>
                                    <td>
                                        <label class="form-label">Staff ID</label>
                                        <input type="text" class="form-control"
                                            value="<?= $user->staff_id ?? '' ?><?= isset($user->emp_name) ? ' - ' . $user->emp_name : '' ?>"
                                            readonly>
                                    </td>

                                    <td>
                                        <label class="form-label">Site No</label>
                                        <input type="text" class="form-control"
                                            value="<?= $user->site_no ?? '' ?>"
                                            readonly>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label class="form-label">Serial No</label>
                                        <input type="text" class="form-control"
                                            value="<?= $user->serial_no ?? '' ?>"
                                            readonly>
                                    </td>

                                    <td>
                                        <label class="form-label">Department Name</label>
                                        <input type="text" class="form-control"
                                            value="<?= $user->department_name ?? '' ?>"
                                            readonly>
                                    </td>
                                </tr>

                                <!-- Buttons -->
                                <tr>
                                    <td colspan="2" class="text-center">
                                        <?php if ($action != 'view'): ?>
                                            <button class="btn btn-primary" type="submit">Save</button>
                                        <?php endif; ?>
                                        <a href="<?= base_url('user/list'); ?>" class="btn btn-secondary">Back</a>
                                    </td>
                                </tr>

                            </table>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>