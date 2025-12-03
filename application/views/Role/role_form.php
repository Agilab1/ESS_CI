<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow">
                    <div class="card-header">
                        <h5><?= ucfirst($action) ?> Role</h5>
                    </div>

                    <div class="card-body">

                        <form action="<?= base_url('Role/save'); ?>" method="post">

                            <input type="hidden" name="action" value="<?= $action ?>">
                            <input type="hidden" name="old_role_id" value="<?= $role->role_id ?>">

                            <table class="table table-bordered">

                                <tr>
                                    <td colspan="2">
                                        <label>Role ID</label>
                                        <input type="text"
                                            name="role_id"
                                            class="form-control"
                                            value="<?= set_value('role_id', $role->role_id) ?>"
                                            <?= ($action == 'edit' || $action == 'view') ? 'readonly' : '' ?>>






                                        <small class="text-danger"><?= form_error('role_id'); ?></small>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label>User Role</label>
                                        <input type="text"
                                            name="usr_role"
                                            class="form-control"
                                            value="<?= $role->usr_role ?>"
                                            <?= ($action == 'view') ? 'readonly' : '' ?>>

                                        <small class="text-danger"><?= form_error('usr_role'); ?></small>
                                    </td>

                                    <td>
                                        <label>Status</label>

                                        <!-- Hidden field will send Inactive if checkbox not checked -->
                                        <input type="hidden" name="role_st" value="Inactive">

                                        <input type="checkbox"
                                            name="role_st"
                                            value="Active"
                                            class="form-control"
                                            <?= ($role->role_st == "Active") ? 'checked' : '' ?>
                                            <?= ($action == 'view') ? 'disabled' : '' ?>>


                                    </td>

                                </tr>

                                <?php if ($action != 'view'): ?>
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                            </table>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>