<style>
    th,
    td {
        white-space: nowrap;
    }

    table {
        table-layout: auto !important;
    }

    .card-body {
        overflow: visible !important;
    }

    .main-footer {
        width: 100% !important;
        margin-left: 0 !important;
    }

    .main-footer .container,
    .main-footer .container-fluid {
        max-width: 100% !important;
        width: 100% !important;
    }

    /* Footer content spacing match table */
    .main-footer .float-left,
    .main-footer .float-right {
        padding-left: 15px;
        padding-right: 15px;
    }
</style>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Material Details</h4>

        <a href="<?= base_url('material/create'); ?>"
            class="btn btn-primary ml-auto">
            <i class="fa fa-plus"></i> Add Material
        </a>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table id="materialTable"
                class="table table-bordered table-striped text-center">

                <thead class="btn-primary text-white">
                    <tr>
                        <th>ID</th>
                        <th>Material Code</th>
                        <th>UOM</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($materials as $m): ?>
                        <tr>
                            <td><?= $m->material_id ?></td>
                            <td><?= $m->material_code ?></td>
                            <td><?= $m->uom ?></td>
                            <td><?= number_format($m->unit_price, 2) ?></td>
                            <td><?= $m->quantity ?></td>
                            <td>
                                <span class="badge <?= $m->status ? 'badge-success' : 'badge-danger' ?>">
                                    <?= $m->status ? 'Active' : 'Inactive' ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('material/view/' . $m->material_id); ?>">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="<?= base_url('material/edit/' . $m->material_id); ?>">
                                    <i class="fa fa-edit text-primary"></i>
                                </a>
                                <a href="<?= base_url('material/delete/' . $m->material_id); ?>"
                                    onclick="return confirm('Delete?');">
                                    <i class="fa fa-trash text-danger"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>

    </div>
</div>