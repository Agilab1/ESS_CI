<style>
    th, td { white-space: nowrap; }

    th {
        writing-mode: horizontal-tb !important;
        transform: rotate(0deg) !important;
    }

    table { table-layout: auto !important; }

    /* Move Add button right */
    .card-header a.btn {
        margin-left: auto !important;
    }

    /* Action icons spacing */
    .action-icons i {
        font-size: 16px;
        margin: 0 6px;
    }

    /* Smaller font table */
    .table td, .table th {
        font-size: 14px;
        vertical-align: middle;
    }

    /* Responsive filter row */
    .filter-row {
        gap: 10px;
        flex-wrap: wrap;
    }
</style>

<div class="card">

    <!-- HEADER -->
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
        <h4 class="mb-2 mb-md-0">Holiday Details</h4>
        <a href="<?= base_url('Holiday/add'); ?>" class="btn btn-primary mt-2 mt-md-0">
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

        <!-- FILTER FORM -->
        <div class="d-flex justify-content-between mb-3 filter-row">

            <!-- Filter Form -->
            <form method="get" action="<?= base_url('Holiday/list'); ?>" class="d-flex gap-2 flex-wrap">

                <select name="month" class="form-control" style="max-width:150px;">
                    <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?= $m ?>" <?= ($m == $month) ? 'selected' : '' ?>>
                            <?= date('F', mktime(0,0,0,$m,1)) ?>
                        </option>
                    <?php endfor; ?>
                </select>

                <select name="year" class="form-control" style="max-width:150px;">
                    <?php for ($y = date('Y') - 2; $y <= date('Y') + 2; $y++): ?>
                        <option value="<?= $y ?>" <?= ($y == $year) ? 'selected' : '' ?>>
                            <?= $y ?>
                        </option>
                    <?php endfor; ?>
                </select>

                <button class="btn btn-primary">Filter</button>
            </form>

            <!-- Prev / Next -->
            <div class="d-flex gap-2">
                <?php
                    $prevM = $month - 1; $prevY = $year;
                    if ($prevM < 1) { $prevM = 12; $prevY--; }

                    $nextM = $month + 1; $nextY = $year;
                    if ($nextM > 12) { $nextM = 1; $nextY++; }
                ?>
                <a class="btn btn-outline-primary" href="<?= base_url("Holiday/list/$prevM/$prevY") ?>">⬅ Previous</a>
                <a class="btn btn-outline-primary" href="<?= base_url("Holiday/list/$nextM/$nextY") ?>">Next ➜</a>
            </div>
        </div>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="btn-primary text-white">
                    <tr>
                        <th>#</th>
                        <th>Holiday Date</th>
                        <th>Day Category</th>
                        <th>Description</th>
                        <th class="text-center" colspan="3">Actions</th>
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

                                <td class="text-center action-icons">
                                    <a href="<?= base_url('Holiday/view/' . $h->date_id); ?>">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>

                                <td class="text-center action-icons">
                                    <a href="<?= base_url('Holiday/edit/' . $h->date_id); ?>">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>

                                <td class="text-center action-icons">
                                    <a href="<?= base_url('Holiday/delete/' . $h->date_id); ?>"
                                       onclick="return confirm('Delete holiday on <?= $h->date_id ?> ?');">
                                        <i class="fa fa-trash text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                No holidays found for this month.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>

        <!-- PAGINATION -->
        <?php if (!empty($pagination)): ?>
            <div class="d-flex justify-content-center mt-3"><?= $pagination ?></div>
        <?php endif; ?>

    </div>
</div>
