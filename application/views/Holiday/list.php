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

    /* Move Add button right */
    .card-header a.btn {
        margin-left: auto !important;
    }
</style>


<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Holiday Details</h4>
        <a href="<?= base_url('Holiday/add'); ?>" class="btn btn-primary">
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

        <div class="table-responsive">
            <table id="dtbl" class="table table-bordered table-striped">

                <thead class="btn-primary text-white">
                    <tr>
                        <th style="width:4vw;">#</th>
                        <th>Holiday Date</th>
                        <th>Day Category</th>
                        <th>Description</th>
                        <th style="width:6vw;" class="text-center">Action</th>
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

                                <!-- ACTION BUTTONS (Single TD like User Table) -->
                                <td class="text-center" style="white-space: nowrap;">

                                    <a href="<?= base_url('Holiday/view/' . $h->date_id); ?>" class="mx-1">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <a href="<?= base_url('Holiday/edit/' . $h->date_id); ?>" class="mx-1">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a href="<?= base_url('Holiday/delete/' . $h->date_id); ?>"
                                        onclick="return confirm('Delete holiday on <?= $h->date_id ?> ?');"
                                        class="mx-1">
                                        <i class="fa fa-trash text-danger"></i>
                                    </a>

                                </td>
                            </tr>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-danger">No Holidays Found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>

    </div>
</div>