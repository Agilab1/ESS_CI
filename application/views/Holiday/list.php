<style>
    /* FIX HEADER TEXT ROTATION / VERTICAL STACKING */
    th {
        white-space: nowrap !important;
        writing-mode: horizontal-tb !important;
        transform: rotate(0deg) !important;
        text-orientation: mixed !important;
    }

    td {
        white-space: nowrap;
    }

    table {
        table-layout: auto !important;
    }
    .card-header a.btn {
    margin-left: auto !important; /* push button to right */
}
</style>


<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
        <h4 class="mb-2 mb-md-0">Holiday Details</h4>

        <a href="<?= base_url('holiday/add'); ?>" class="btn btn-primary mt-2 mt-md-0">
            <i class="fa fa-plus"></i> Add Holiday
        </a>
    </div>

    <div class="card-body">

        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
        <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <!-- RESPONSIVE WRAPPER -->
        <div class="table-responsive">
            <table id="holidayTable" class="table table-bordered table-striped align-middle" style="font-size: 14px;">

                <thead class="btn-primary text-white">
                    <tr>
                        <th>#</th>
                        <th>Holiday Date</th>
                        <th>Day Category</th>
                        <th>Description</th>
                        <th class="text-center" colspan="3">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($holidays)): ?>
                        <?php foreach ($holidays as $index => $h): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $h->date_id ?></td>
                                <td><?= $h->day_cat ?></td>
                                <td><?= $h->day_txt ?></td>

                                <!-- VIEW -->
                                <td class="text-center">
                                    <a href="<?= base_url('holiday/view/' . $h->date_id); ?>">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>

                                <!-- EDIT -->
                                <td class="text-center">
                                    <a href="<?= base_url('holiday/edit/' . $h->date_id); ?>">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>

                                <!-- DELETE -->
                                <td class="text-center">
                                    <a href="<?= base_url('holiday/delete/' . $h->date_id); ?>"
                                        onclick="return confirm('Delete holiday on date: <?= $h->date_id ?> ?');">
                                        <i class="fa fa-trash text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                No holidays found.
                            </td>
                        </tr>

                    <?php endif; ?>
                </tbody>

            </table>
        </div>

    </div>
</div>
