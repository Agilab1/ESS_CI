<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow">

                    <div class="card-header">
                        <h5><?= ucfirst($action) ?> Staff</h5>
                    </div>

                    <!-- Flash Error -->
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="card-body">
                        <form method="post" action="<?= base_url('Staff/save'); ?>" autocomplete="off">

                            <?php $readonly = ($action == 'view') ? 'readonly disabled' : ''; ?>

                            <input type="hidden" name="action" value="<?= $action ?>">
                            <input type="hidden" name="old_staff_id" value="<?= $staff->staff_id ?? '' ?>">

                            <table class="table table-bordered">

                                <!-- Staff ID -->
                                <tr>
                                    <td colspan="2">
                                        <label class="form-label">Staff ID</label>
                                        <input class="form-control" type="text" name="staff_id"
                                               value="<?= set_value('staff_id', $staff->staff_id ?? '') ?>"
                                            <?= ($action == 'edit' || $action == 'view') ? 'readonly' : '' ?>>
                                        <small class="text-danger"><?= form_error('staff_id'); ?></small>
                                    </td>
                                </tr>

                                <!-- Employee + NFC -->
                                <tr>
                                    <td>
                                        <label>Employee Name</label>
                                        <input class="form-control" type="text" name="emp_name"
                                            value="<?= set_value('emp_name', $staff->emp_name ?? '') ?>"
                                            <?= $readonly ?>>
                                        <small class="text-danger"><?= form_error('emp_name'); ?></small>
                                    </td>

                                    <td>
                                        <label>NFC Card</label>
                                        <input class="form-control" type="text" name="nfc_card"
                                            value="<?= set_value('nfc_card', $staff->nfc_card ?? '') ?>"
                                            <?= $readonly ?>>
                                        <small class="text-danger"><?= form_error('nfc_card'); ?></small>
                                    </td>
                                </tr>

                                <!-- Desig + Join Date -->
                                <tr>
                                    <td>
                                        <label>Designation</label>
                                        <input class="form-control" type="text" name="desig"
                                            value="<?= set_value('desig', $staff->desig ?? '') ?>"
                                            <?= $readonly ?>>
                                    </td>

                                    <td>
                                        <label>Join Date</label>
                                        <input class="form-control" type="date" name="join_dt"
                                            value="<?= set_value('join_dt', $staff->join_dt ?? '') ?>"
                                            <?= $readonly ?>>
                                    </td>
                                </tr>

                                <!-- Phone + Birth -->
                                <tr>
                                    <td>
                                        <label>Phone No</label>
                                        <input class="form-control" type="text" name="phn_no"
                                            value="<?= set_value('phn_no', $staff->phn_no ?? '') ?>"
                                            <?= $readonly ?>>
                                    </td>

                                    <td>
                                        <label>Birth Date</label>
                                        <input class="form-control" type="date" name="birth_dt"
                                            value="<?= set_value('birth_dt', $staff->birth_dt ?? '') ?>"
                                            <?= $readonly ?>>
                                    </td>
                                </tr>

                                <!-- Status -->
                                <tr>
                                    <td colspan="2">
                                        <label>Status</label>
                                        <select class="form-control" name="staff_st" <?= $readonly ?>>
                                            <option value="">Select Status</option>
                                            <option value="Inactive" 
                                                <?= set_select('staff_st', 'Inactive', ($staff->staff_st ?? '') == 'Inactive') ?>>
                                                Inactive
                                            </option>
                                            <option value="Active" 
                                                <?= set_select('staff_st', 'Active', ($staff->staff_st ?? '') == 'Active') ?>>
                                                Active
                                            </option>
                                        </select>
                                    </td>
                                </tr>

                                <!-- Save Button -->
                                <?php if ($action != 'view'): ?>
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <button class="btn btn-primary px-5" type="submit">Save</button>
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
