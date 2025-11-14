<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow">
                    <div class="card-header">
                        <h5><?= $action ?>Role</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('Role/save'); ?>" method="post" autocomplete="off" >
                            <table class="table table-bordered">
                                <input type="hidden" name="action" value="<?= $action ?>">
                                <input type="hidden" name="old_staff_id" value="<?= $role->role_id ?? '' ?>">

                                <tr>
                                    <td colspan="2">
                                        <label class="form-label">Role ID</label>
                                        <input type="text" name="role_id" id="" class="form-control" value="<?= $role->role_id ?? '' ?>" <?= ($action =='edit' ||$action =='view')? 'readonly': '' ?>>
                                        <small class="text-danger"><?= form_error('role_id'); ?></small>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-control">User Role</label>
                                        <input type="text" name="usr_role" class="form-control" value="<?= $role->usr_role ?? '' ?>" id="">
                                        <small class="text-danger"><?= form_error('usr_role'); ?></small>
                                    </td>
                                    <td>
                                        <label class="forn-control">Role Status</label>
                                        <input type="checkbox" name="role_st" id="" value="<?= $role->role_st ?>" >
                                        <small class="text-danger"><?= base_url('role_st') ?></small>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-center">
                                        <button type="submit" class="btn btn-primary">Submit</button>
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