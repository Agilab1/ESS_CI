<style>
    th,
    td {
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
        font-size: 14px;
        font-weight: normal;
    }

    .card-portrait {
        max-width: 420px;
        margin: auto;
    }

    /* Saturday / Sunday */
    .week-off td {
        background: #f8cfd1 !important;
        font-weight: normal;
    }

    /* Employee info row  */
    .emp-info td {
        font-weight: 600;
        background: #f2f2f2;
    }

    /* Today highlight (NO BOLD, only background) */
    .today-row td {
        background: #d1e7dd !important;
        font-weight: normal;
    }
</style>

<div class="container-fluid mt-3">
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="card card-portrait shadow-sm">

                <!-- HEADER -->
                <div class="card-header bg-primary text-white text-center">
                    Employee Details
                </div>

                <div class="card-body p-0">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success text-center m-2">
                            <?= $this->session->flashdata('success'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger text-center m-2">
                            <?= $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif; ?>


                    <div id="punchTable">

                        <table class="table table-bordered mb-0">

                            <!-- EMPLOYEE INFO -->
                            <tr class="emp-info">
                                <td><?= $staff->staff_id ?></td>
                                <td colspan="3"><?= $staff->emp_name ?></td>
                            </tr>

                            <!-- TABLE HEADER -->
                            <tr>
                                <th>Date</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Duration</th>
                            </tr>

                            <?php $today = date('Y-m-d'); ?>

                            <?php for ($d = 1; $d <= $daysInMonth; $d++): ?>

                                <?php
                                $date = sprintf('%04d-%02d-%02d', $year, $month, $d);
                                $day  = date('l', strtotime($date));

                                $row = $attendance[$date] ?? null;

                                $isWeekOff = ($day === 'Saturday' || $day === 'Sunday');
                                $isToday   = ($date === $today);
                                ?>

                                <tr class="<?= $isWeekOff ? 'week-off' : '' ?> <?= $isToday ? 'today-row' : '' ?>">
                                    <td>
                                        <?= date('d-m-Y', strtotime($date)) ?>
                                    </td>

                                    <!-- IN TIME (12-hour format, never changes) -->
                                    <td>
                                        <?= !empty($row->cin_time)
                                            ? date('h:i A', strtotime($row->cin_time))
                                            : '-' ?>
                                    </td>

                                    <!-- OUT TIME (updates on every NFC tap) -->
                                    <td>
                                        <?= !empty($row->cout_time)
                                            ? date('h:i A', strtotime($row->cout_time))
                                            : '-' ?>
                                    </td>

                                    <!-- DURATION -->
                                    <td>
                                        <?php
                                        if (!empty($row->cin_time) && !empty($row->cout_time)) {
                                            $in  = new DateTime($row->cin_time);
                                            $out = new DateTime($row->cout_time);
                                            echo $out->diff($in)->format('%H:%I:%S');
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                </tr>

                            <?php endfor; ?>

                        </table>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>