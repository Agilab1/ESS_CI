<?php
// mode : view/edit
$is_view_only = isset($mode) && $mode === 'view';
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">

                <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                    <h4 style="margin-left: -50%;" class="mb-2 mb-md-0">Staff Details</h4>
                </div>

                <div class="card shadow">
                    <div class="card-body">

                        <!-- <form method="post" action="<?= base_url('Staff/emp_list/' . $staff->staff_id); ?>" autocomplete="off"> -->
                            <form method="post" action="<?= base_url('Staff/save_status') ?>">
                            <input type="hidden" name="staff_id" value="<?= $staff->staff_id ?>">
                            <input type="hidden" name="date" value="<?= $today ?>">


                            <table class="table table-bordered">

                                <!-- STAFF ID -->
                                <tr>
                                    <td colspan="2">
                                        <label class="form-label">Staff ID</label>
                                        <input class="form-control"
                                               type="text"
                                               name="staff_id"
                                               value="<?= $staff->staff_id ?>"
                                               readonly>
                                    </td>
                                </tr>

                                <!-- EMP NAME + WORK STATUS -->
                                <tr>
                                    <td>
                                        <label>Employee Name</label>
                                        <input class="form-control"
                                               type="text"
                                               name="emp_name"
                                               value="<?= $staff->emp_name ?>"
                                               readonly>
                                    </td>

                                    <td>
                                        <label>Work Status</label>
                                        <select class="form-control"
                                                name="staff_st"
                                                <?= $is_view_only ? 'disabled' : '' ?>>

                                            <option value="No Punch" <?= ($todayStatus == 'No Punch') ? 'selected' : '' ?>>No Punch</option>
                                            <option value="WFO" <?= ($todayStatus == 'WFO') ? 'selected' : '' ?>>WFO</option>
                                            <option value="WFH" <?= ($todayStatus == 'WFH') ? 'selected' : '' ?>>WFH</option>
                                            <option value="On Duty" <?= ($todayStatus == 'On Duty') ? 'selected' : '' ?>>On Duty</option>
                                            <option value="Leave" <?= ($todayStatus == 'Leave') ? 'selected' : '' ?>>Leave</option>

                                        </select>
                                    </td>
                                </tr>

                                <!-- DATE -->
                                <tr>
                                    <td>
                                        <label>Date</label>

                                        <!-- Hidden original date -->
                                        <input type="hidden" name="old_date" value="<?= $today ?>">

                                        <input class="form-control"
                                               type="date"
                                               value="<?= $today ?>"
                                               readonly>
                                    </td>
                                </tr>

                                <!-- REMARK FIELD -->
                                <tr>
                                    <td colspan="2">
                                        <label>Remark</label>
                                        <input class="form-control"
                                               type="text"
                                               name="remark"
                                               value="<?= isset($todayRemark) ? $todayRemark : '' ?>"
                                               placeholder="Enter remark (optional)"
                                               <?= $is_view_only ? 'disabled' : '' ?>>
                                    </td>
                                </tr>

                                <!-- SUBMIT BUTTON (Hide in view mode) -->
                                <?php if (!$is_view_only): ?>
                                <tr>
                                    <!-- <td></td> -->
                                    <td colspan="2" class="text-center">
                                        <a href="<?= base_url('/Staff/emp_list/'). $staff->staff_id . '?date=' . date('Y-m-d') ?>"  class="btn btn-secondary">Back</a>
                                        <button class="btn btn-primary" type="submit">Save</button>

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
