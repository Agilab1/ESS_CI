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
                                    <th>Holiday</th>
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
                                    $isHoliday = (!empty($dbHoliday) || $dayName == 'Saturday' || $dayName == 'Sunday');
                                    ?>
                                    <tr class="<?= $isHoliday ? 'table-danger' : '' ?>">

                                        <td><?= $item->punch_date ?></td>
                                        <td><?= $staff->staff_id ?></td>
                                        <td><?= $staff->emp_name ?></td>


                                        <!-- Holiday Column -->
                                        <td>
                                            <?php
                                            if (!empty($dbHoliday)) {
                                                echo "<span class='text-danger font-weight-bold'>{$dbHoliday->day_txt}</span>";
                                            } elseif ($dayName == 'Saturday') {
                                                echo "<span class='text-danger font-weight-bold'>Saturday Off</span>";
                                            } elseif ($dayName == 'Sunday') {
                                                echo "<span class='text-danger font-weight-bold'>Sunday Off</span>";
                                            } else {
                                                echo "<span class='text-success font-weight-bold'>Working Day</span>";
                                            }
                                            ?>
                                        </td>

                                        <!-- Action Column (Right Side) -->
                                        <td><?= $item->staff_st ?></td>
                                        <td>

                                            <?php if ($isHoliday): ?>
                                                <span class="text-danger font-weight-bold">
                                                    <?= !empty($item->staff_st) ? $item->staff_st : ($dayName == 'Saturday' ? 'Saturday Off' : ($dayName == 'Sunday' ? 'Sunday Off' : 'Holiday')) ?>
                                                </span>
                                            <?php else: ?>
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