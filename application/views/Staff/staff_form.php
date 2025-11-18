<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow">
                    <div class="card-header">
                        <h5><?= $action ?> Staff</h5>
                    </div>

                    <div class="card-body">

                        <form method="post" action="<?=base_url('Staff/save'); ?>" autocomplete="off">

                            <table class="table table-bordered">

                                <input type="hidden" name="action" value="<?= $action ?>">
                                <input type="hidden" name="old_staff_id" value="<?= $staff->staff_id ?? '' ?>">

                                <tr>
                                    <td colspan="2">
                                        <label class="form-label">Staff ID</label>
                                        <input class="form-control" type="text" name="staff_id"
                                            value="<?= $staff->staff_id ?? '' ?>"
                                            <?= ($action == 'edit' || $action == 'view') ? 'readonly' : '' ?>>
                                        <small class="text-danger"><?= form_error('staff_id'); ?></small>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label>Employee Name</label>
                                        <input class="form-control" type="text" name="emp_name"
                                            value="<?= $staff->emp_name ?? '' ?>">
                                        <small class="text-danger"><?= form_error('emp_name'); ?></small>
                                    </td>

                                    <td>
                                        <label>NFC Card</label>
                                        <input class="form-control" type="text" name="nfc_card"
                                            value="<?= $staff->nfc_card ?? '' ?>">
                                        <small class="text-danger"><?= form_error('nfc_card'); ?></small>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label>Designation</label>
                                        <input class="form-control" type="text" name="desig"
                                            value="<?= $staff->desig ?? '' ?>">
                                    </td>

                                    <td>
                                        <label>Join Date</label>
                                        <input class="form-control" type="date" name="join_dt"
                                            value="<?= $staff->join_dt ?? '' ?>">
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label>Phone No</label>
                                        <input class="form-control" type="text" name="phn_no"
                                            value="<?= $staff->phn_no ?? '' ?>">
                                    </td>

                                    <td>
                                        <label>Birth Date</label>
                                        <input class="form-control" type="date" name="birth_dt"
                                            value="<?= $staff->birth_dt ?? '' ?>">
                                    </td>


                                </tr>
                                <tr>
                                    <td>
                                        <label>Status</label>
                                        <select class="form-control" name="staff_st">
                                            <option value="">Select Status</option>
                                            <option value="Inactive" <?= isset($staff->staff_st) && $staff->staff_st == 'Inactive' ? 'selected' : '' ?>>
                                                Inactive
                                            </option>
                                            <option value="Active" <?= isset($staff->staff_st) && $staff->staff_st == 'Active' ? 'selected' : '' ?>>
                                                Active
                                            </option>
                                        </select>
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