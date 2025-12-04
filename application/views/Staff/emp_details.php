<style>
    th,
    td {
        white-space: nowrap;
    }

    th {
        writing-mode: horizontal-tb !important;
        transform: rotate(0deg) !important;
    }

    table {
        table-layout: auto !important;
    }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">

        <div class="col-md-12">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Punching Details</h4>
            </div>

            <!-- ⭐ MONTH FILTER + NAVIGATION -->
            <?php
            $curMonth = $month;
            $curYear  = $year;
            ?>
            <div class="d-flex justify-content-between mt-3">

                <!-- FILTER -->
                <form method="get"
                    action="<?= base_url('Staff/emp_list/' . $staff->staff_id); ?>"
                    class="d-flex gap-2">

                    <input type="hidden" name="staff_id" value="<?= $staff->staff_id ?>">

                    <select name="month" class="form-control" style="max-width:140px;">
                        <?php for ($m = 1; $m <= 12; $m++): ?>
                            <option value="<?= $m ?>" <?= ($m == $curMonth ? 'selected' : '') ?>>
                                <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                            </option>
                        <?php endfor; ?>
                    </select>

                    <select name="year" class="form-control" style="max-width:120px;">
                        <?php for ($y = date('Y') - 2; $y <= date('Y') + 2; $y++): ?>
                            <option value="<?= $y ?>" <?= ($y == $curYear ? 'selected' : '') ?>>
                                <?= $y ?>
                            </option>
                        <?php endfor; ?>
                    </select>

                    <button class="btn btn-outline-primary">Filter</button>
                </form>

                <!-- MONTH NAVIGATION -->
                <div class="d-flex gap-2">

                    <!-- PREVIOUS -->
                    <a class="btn btn-outline-primary"
                        href="<?= base_url('Staff/emp_list/' . $staff->staff_id . '?month=' . $prevM . '&year=' . $prevY) ?>">
                        ⬅ Previous Month
                    </a>

                    <!-- CURRENT MONTH -->
                    <a class="btn btn-outline-primary"
                        href="<?= base_url('Staff/emp_list/' . $staff->staff_id . '?month=' . date('m') . '&year=' . date('Y')) ?>">
                        📅 Current Month
                    </a>

                    <!-- NEXT -->
                    <a class="btn btn-outline-primary"
                        href="<?= base_url('Staff/emp_list/' . $staff->staff_id . '?month=' . $nextM . '&year=' . $nextY) ?>">
                        Next Month ➜
                    </a>

                </div>

            </div>
            <!-- ⭐ END FILTER -->

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
                            $dbHoliday  = $holiday_model->getHolidayByDate($formatDate);
                            $dayName    = date('l', strtotime($formatDate));

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

                                        <!-- ADD -->
                                        <a href="<?= base_url('Staff/status/' . $item->staff_id . '?date=' . $item->punch_date . '&mode=edit') ?>"
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