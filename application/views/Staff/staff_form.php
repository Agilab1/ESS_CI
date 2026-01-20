<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow">

                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="m-0 fw-bold">
                            <i class="fa fa-th-large me-2"></i>
                            <?= ucfirst($action) ?> Staff
                        </h5>
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
                                        <label class="form-label">Staff ID<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="staff_id"
                                            value="<?= set_value('staff_id', $staff->staff_id ?? '') ?>"
                                            <?= ($action == 'edit' || $action == 'view') ? 'readonly' : '' ?>>
                                        <small class="text-danger"><?= form_error('staff_id'); ?></small>
                                    </td>
                                </tr>

                                <!-- Employee + NFC -->
                                <tr>
                                    <td>
                                        <label>Employee Name<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="emp_name"
                                            value="<?= set_value('emp_name', $staff->emp_name ?? '') ?>"
                                            <?= $readonly ?>>
                                        <small class="text-danger"><?= form_error('emp_name'); ?></small>
                                    </td>

                                    <td>
                                        <label>NFC Card<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="nfc_card"
                                            value="<?= set_value('nfc_card', $staff->nfc_card ?? '') ?>"
                                            <?= $readonly ?>>
                                        <small class="text-danger"><?= form_error('nfc_card'); ?></small>
                                    </td>
                                </tr>

                                <!-- Desig + Join Date -->
                                <tr>
                                    <td>
                                        <label>Designation<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="desig"
                                            value="<?= set_value('desig', $staff->desig ?? '') ?>"
                                            <?= $readonly ?>>
                                        <small class="text-danger"><?= form_error('desig'); ?></small>
                                    </td>

                                    <td>
                                        <label>Join Date<span class="text-danger">*</span></label>
                                        <input class="form-control" type="date" name="join_dt"
                                            value="<?= set_value('join_dt', $staff->join_dt ?? '') ?>"
                                            <?= $readonly ?>>
                                        <small class="text-danger"><?= form_error('join_dt'); ?></small>
                                    </td>
                                </tr>

                                <!-- Phone + Birth -->
                                <tr>
                                    <td>
                                        <label>Phone No<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="phn_no"
                                            value="<?= set_value('phn_no', $staff->phn_no ?? '') ?>"
                                            <?= $readonly ?>>
                                        <small class="text-danger"><?= form_error('phn_no'); ?></small>
                                    </td>

                                    <td>
                                        <label>Birth Date<span class="text-danger">*</span></label>
                                        <input class="form-control" type="date" name="birth_dt"
                                            value="<?= set_value('birth_dt', $staff->birth_dt ?? '') ?>"
                                            <?= $readonly ?>>
                                        <small class="text-danger"><?= form_error('birth_dt'); ?></small>
                                    </td>
                                </tr>

                                <!-- Status -->
                                <tr>
                                    <td colspan="2">
                                        <label>Status <span class="text-danger">*</span></label>

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

                                        <small class="text-danger"><?= form_error('staff_st'); ?></small>
                                    </td>
                                </tr>

                                <!-- Buttons -->
                                <tr>
                                    <td colspan="2" class="text-center">

                                        <?php if ($action != 'view'): ?>
                                            <button class="btn btn-primary px-5 me-2" type="submit">
                                                Save
                                            </button>
                                        <?php endif; ?>

                                        <a href="<?= base_url('Staff/list'); ?>" class="btn btn-secondary px-5">
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