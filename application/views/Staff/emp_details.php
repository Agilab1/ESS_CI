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

    form select.form-control {
        min-width: 160px;
        
    }
    form select[name="year"] {
    min-width: 100px;
}

    form {
        gap: 10px;

    }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">

        <div class="col-md-12">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Punching Details</h4>
            </div>

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

                    <select name="month" class="form-control" style="max-width:150px;">
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

                    <a class="btn btn-outline-primary"
                        href="<?= base_url('Staff/emp_list/' . $staff->staff_id . '?month=' . $prevM . '&year=' . $prevY) ?>">
                        ⬅ Previous Month
                    </a>

                    <a class="btn btn-outline-primary"
                        href="<?= base_url('Staff/emp_list/' . $staff->staff_id . '?month=' . date('m') . '&year=' . date('Y')) ?>">
                        📅 Current Month
                    </a>

                    <a class="btn btn-outline-primary"
                        href="<?= base_url('Staff/emp_list/' . $staff->staff_id . '?month=' . $nextM . '&year=' . $nextY) ?>">
                        Next Month ➡
                    </a>

                </div>

            </div>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table id="dtbl" class="table table-bordered table-striped align-middle" style="font-size: 14px;">
                    <thead class="btn-primary">
                        <tr>
                            <th>Punch Date</th>
                            <th>Staff ID</th>
                            <th>Employee Name</th>
                            <th>Status</th>
                            <th>Remark</th>
                            <th>C-IN Time</th>
                            <th>C-OUT Time</th>
                            <th>Duration</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($works as $item): ?>

                            <?php
                            $formatDate = $item->punch_date;
                            $dbHoliday  = $holiday_model->getHolidayByDate($formatDate);
                            $dayName    = date('l', strtotime($formatDate));

                            $isHoliday = !empty($dbHoliday);

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
                            } elseif ($isHoliday) {
                                $statusClass = 'text-danger';
                            }
                            ?>

                            <tr class="<?= ($isHoliday ? 'table-danger' : '') ?>">

                                <td><?= $item->punch_date ?></td>
                                <td><?= $item->staff_id ?></td>
                                <td><?= $item->emp_name ?></td>

                                <td class="<?= $statusClass ?>"><?= $status ?></td>

                                <td><?= $item->remark ?: '-' ?></td>

                                <!-- ✅ 12-HOUR C-IN -->
                                <td>
                                    <?= !empty($item->cin_time)
                                        ? date('h:i A', strtotime($item->cin_time))
                                        : '-' ?>
                                </td>

                                <!-- ✅ 12-HOUR C-OUT -->
                                <td>
                                    <?= !empty($item->cout_time)
                                        ? date('h:i A', strtotime($item->cout_time))
                                        : '-' ?>
                                </td>

                                <!-- DURATION -->
                                <td><?= $item->duration ?: '-' ?></td>

                                <td class="text-center">

                                    <?php if (!in_array(strtolower($status), ['saturday off', 'sunday off'])): ?>

                                        <a href="<?= base_url('Staff/status/' . $item->staff_id . '?date=' . $item->punch_date . '&mode=view') ?>">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        &nbsp;

                                        <?php if (!$isHoliday): ?>

                                            <?php if ($status == "No Punch"): ?>
                                                <a href="<?= base_url('Staff/status/' . $item->staff_id . '?date=' . $item->punch_date . '&mode=create') ?>">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            <?php else: ?>
                                                <a href="<?= base_url('Staff/status/' . $item->staff_id . '?date=' . $item->punch_date . '&mode=edit') ?>">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            <?php endif; ?>

                                        <?php endif; ?>

                                        <a href="<?= base_url('Staff/delete_status/' . $item->staff_id . '/' . $item->punch_date) ?>"
                                            onclick="return confirm('Delete this record?');">
                                            <i class="fa fa-trash text-danger"></i>
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