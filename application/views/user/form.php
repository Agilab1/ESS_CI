<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow">
                    <div class="card-header">
                        <h5><?= isset($action) ? ucfirst($action) : 'Add' ?> User</h5>
                    </div>

                    <div class="card-body">
                        <form method="post" action="<?= base_url('user/save') ?>" id="userform" autocomplete="off">

                            <table class="table table-bordered">

                                <tr>
                                    <td colspan="2">

                                        <input type="hidden" name="action" value="<?= isset($action) ? strtolower($action) : 'add' ?>">
                                        <input type="hidden" name="user_id" value="<?= isset($user->user_id) ? $user->user_id : '' ?>">

                                        <label class="form-label">Email ID</label>
                                        <input class="form-control" type="email" name="mail_id"
                                            value="<?= set_value('mail_id', isset($user->mail_id) ? $user->mail_id : '') ?>"
                                            required>
                                        <small class="text-danger"><?= form_error('mail_id'); ?></small>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-label">User Name</label>
                                        <input class="form-control" type="text" name="user_nm"
                                            value="<?= set_value('user_nm', isset($user->user_nm) ? $user->user_nm : '') ?>"
                                            required>
                                        <small class="text-danger"><?= form_error('user_nm'); ?></small>
                                    </td>

                                    <td>
                                        <label class="form-label">Phone No</label>
                                        <input class="form-control" type="text" name="user_ph"
                                            value="<?= set_value('user_ph', isset($user->user_ph) ? $user->user_ph : '') ?>"
                                            required>
                                        <small class="text-danger"><?= form_error('user_ph'); ?></small>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label class="form-label">Password</label>
                                        <input class="form-control" type="password" name="pass_wd"
                                            value="<?= set_value('pass_wd', isset($user->pass_wd) ? $user->pass_wd : '') ?>"
                                            autocomplete="new-password" required>
                                        <small class="text-danger"><?= form_error('pass_wd'); ?></small>
                                    </td>

                                    <td>
                                        <label class="form-label">Confirm Password</label>
                                        <input class="form-control" type="password" name="cpas_wd"
                                            value="<?= set_value('cpas_wd', isset($user->pass_wd) ? $user->pass_wd : '') ?>"
                                            required>
                                        <small class="text-danger"><?= form_error('cpas_wd'); ?></small>
                                    </td>
                                </tr>

                                <!-- Corrected Dropdowns -->

                                <tr>
                                    <td>
                                        <label class="form-label">User Role</label>
                                        <select class="form-control" name="role_id" required>
                                            <option value="">Select Role</option>

                                            <option value="Admin"
                                                <?= (isset($user->role_id) && $user->role_id == "Admin") ? 'selected' : '' ?>>
                                                Admin
                                            </option>

                                            <option value="User"
                                                <?= (isset($user->role_id) && $user->role_id == "User") ? 'selected' : '' ?>>
                                                User
                                            </option>
                                        </select>
                                        <small class="text-danger"><?= form_error('role_id'); ?></small>
                                    </td>

                                    <td>
                                        <label class="form-label">User Status</label>
                                        <select class="form-control" name="user_st" required>
                                            <option value="">Select Status</option>

                                            <option value="Active"
                                                <?= (isset($user->user_st) && $user->user_st == "Active") ? 'selected' : '' ?>>
                                                Active
                                            </option>

                                            <option value="Inactive"
                                                <?= (isset($user->user_st) && $user->user_st == "Inactive") ? 'selected' : '' ?>>
                                                Inactive
                                            </option>
                                        </select>
                                        <small class="text-danger"><?= form_error('user_st'); ?></small>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label class="form-label">User Type</label>
                                        <select class="form-control" name="user_ty" required>
                                            <option value="">Select Type</option>

                                            <option value="User"
                                                <?= (isset($user->user_ty) && $user->user_ty == "User") ? 'selected' : '' ?>>
                                                User
                                            </option>

                                            <option value="Manager"
                                                <?= (isset($user->user_ty) && $user->user_ty == "Manager") ? 'selected' : '' ?>>
                                                Manager
                                            </option>

                                        </select>
                                        <small class="text-danger"><?= form_error('user_ty'); ?></small>
                                    </td>

                                    <td>

                                        <label class="form-label">Is Admin?</label>
                                        <input type="checkbox" class="form-control" name="user_ad" value="1"
                                            <?= (isset($user->user_ad) && $user->user_ad == "1") ? 'checked' : '' ?> class="form-control">
                                        <small class="text-danger"><?= form_error('user_ad'); ?></small>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-center">
                                        <button class="btn btn-primary" type="submit">Save</button>
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