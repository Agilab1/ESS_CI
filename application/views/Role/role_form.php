<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="m-0 fw-bold">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <?= ucfirst($action) ?> Role
                        </h4>
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

                                        <input type="hidden" name="role_st" value="Inactive">

                                        <input type="checkbox"
                                            name="role_st"
                                            value="Active"
                                            class="form-control"
                                            <?= ($role->role_st == "Active") ? 'checked' : '' ?>
                                            <?= ($action == 'view') ? 'disabled' : '' ?>>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2" class="text-center">

                                        <?php if ($action != 'view'): ?>
                                            <button type="submit" class="btn btn-primary me-2">
                                                Submit
                                            </button>
                                        <?php endif; ?>

                                        <a href="<?= base_url('Role/role_dash'); ?>" class="btn btn-secondary">
                                            Back
                                        </a>

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