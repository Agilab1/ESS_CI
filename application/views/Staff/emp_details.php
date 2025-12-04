<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Punching Details</h4>
                    <!-- <a href="<?= base_url('Staff/status/' . $staff->staff_id . '?date=' . date('Y-m-d') . '&mode=edit') ?>"
                        class="btn btn-primary btn-sm"
                        style="margin-right:-78%;">
                        <i class="fa fa-plus"></i> Add Status
                    </a> -->
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Punch Date</th>
                            <th>Staff ID</th>
                            <th>Employee Name</th>
                            <th>Status</th>
                            <th>Remark</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($works as $item): ?>
                            <?php
                            $formatDate = $item->punch_date;
                            $dbHoliday = $holiday_model->getHolidayByDate($formatDate);
                            $dayName = date('l', strtotime($formatDate));
                            $isHoliday = (!empty($dbHoliday) || $dayName == 'Saturday' || $dayName == 'Sunday');
                            $status = !empty($item->staff_st) ? $item->staff_st : "No Punch";
                            if (!empty($dbHoliday)) {
                                $status = $dbHoliday->day_txt;
                            } elseif ($dayName == 'Saturday') {
                                $status = "Saturday Off";
                            } elseif ($dayName == 'Sunday') {
                                $status = "Sunday Off";
                            }
                            $statusClass = '';
                            if ($status == "Saturday Off" || $status == "Sunday Off") {
                                $statusClass = 'text-danger font-weight-bold';
                            } elseif ($isHoliday && !empty($dbHoliday)) {
                                $statusClass = 'text-danger';
                            }
                            ?>
                            <tr class="<?= $isHoliday ? 'table-danger' : '' ?>">
                                <td><?= $item->punch_date ?></td>
                                <td><?= $item->staff_id ?></td>
                                <td><?= $item->emp_name ?></td>
                                <td class="<?= $statusClass ?>"><?= $status ?></td>
                                <td><?= !empty($item->remark) ? $item->remark : '-' ?></td>
                                <td class="text-center">
                                    <?php if (!$isHoliday): ?>
                                        <a href="<?= base_url('Staff/status/' . $staff->staff_id . '?date=' .$item->punch_date . '&mode=edit') ?>"
                                            style="color:#007bff; font-size:16px; margin-right:8px;">
                                            <i class="fa fa-plus"></i> 
                                        </a>

                                        <!-- VIEW -->
                                        <a href="<?= base_url('Staff/status/' . $item->staff_id . '?date=' . $item->punch_date . '&mode=view') ?>"
                                            style="color:#007bff; font-size:16px; margin-right:8px;">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <!-- EDIT -->
                                        <a href="<?= base_url('Staff/status/' . $item->staff_id . '?date=' . $item->punch_date . '&mode=edit') ?>"
                                            style="color:#007bff; font-size:16px; margin-right:8px;">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <!-- DELETE -->
                                        <a href="<?= base_url('Staff/delete_status/' . $item->staff_id . '/' . $item->punch_date) ?>"
                                            onclick="return confirm('Delete this record?');"
                                            style="color:#dc3545; font-size:16px;">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>