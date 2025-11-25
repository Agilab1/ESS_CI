<div class="container-fluid">
    <div class="row justify-content-center">

        <div class="col-md-12">
            <div class="card card-primary">

                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-8">
                            <h3 class="card-title">Punching Details</h3>
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
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($works as $item): ?>
                                    <?php
                                    $formatDate = $item->punch_date;
                                    $dbHoliday  = $holiday_model->getHolidayByDate($formatDate);
                                    $dayName = date('l', strtotime($formatDate));

                                    // Check Holiday / Saturday / Sunday
                                    $isHoliday = (!empty($dbHoliday) || $dayName == 'Saturday' || $dayName == 'Sunday');

                                    // Default Status
                                    $status = !empty($item->staff_st) ? $item->staff_st : "No Punch";

                                    // If holiday, overwrite status
                                    if (!empty($dbHoliday)) {
                                        $status = $dbHoliday->day_txt;
                                    } elseif ($dayName == 'Saturday') {
                                        $status = "Saturday Off";
                                    } elseif ($dayName == 'Sunday') {
                                        $status = "Sunday Off";
                                    }

                                    // CSS classes based on status
                                    $statusClass = '';
                                    if ($status == "Saturday Off" || $status == "Sunday Off") {
                                        $statusClass = 'text-danger font-weight-bold';   // bold + red (Sat & Sun only)
                                    } elseif ($isHoliday && !empty($dbHoliday)) {
                                        $statusClass = 'text-danger';                   // holiday red without bold
                                    } else {
                                        $statusClass = '';                              // working — normal black
                                    }
                                    ?>

                                    <tr class="<?= $isHoliday ? 'table-danger' : '' ?>">

                                        <td><?= $item->punch_date ?></td>
                                        <td><?= $staff->staff_id ?></td>
                                        <td><?= $staff->emp_name ?></td>

                                        <!-- Status -->
                                        <td class="<?= $statusClass ?>"><?= $status ?></td>

                                        <!-- Action -->
                                        <td>
                                            <?php if (!$isHoliday): ?>
                                                <a href="<?= base_url('Staff/status/' . $staff->staff_id . '?date=' . $item->punch_date) ?>"
                                                    class="btn btn-sm btn-primary">Update</a>
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