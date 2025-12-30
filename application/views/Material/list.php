<style>
.card-body {
    overflow-y: visible !important;
    overflow-x: visible !important;
    max-height: none !important;
}
.content-wrapper {
    height: auto !important;
    overflow: visible !important;
}
.content {
    overflow: visible !important;
}

    .content-wrapper .container-fluid {
        max-width: 100% !important;
    }
    .content-wrapper .card {
        width: 100% !important;
    }
    #materialTable {
        width: 100% !important;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h3>Material Details</h3>
            <a href="<?= base_url('material/create') ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Material
            </a>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-body">

                    <table id="materialTable"
                        class="table table-bordered table-striped text-center">
                        <thead style="background:#007bff;color:white;">
                            <tr>
                                <th>#</th>
                                <th>Material ID</th>
                                <th>Material Code</th>
                                <th>UOM</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $i = 1;
                            foreach ($materials as $m): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $m->material_id ?></td>
                                    <td><?= $m->material_code ?></td>
                                    <td><?= $m->uom ?></td>
                                    <td><?= number_format($m->unit_price, 2) ?></td>
                                    <td><?= $m->quantity ?></td>
                                    <td>
                                        <?php if ($m->status == 1): ?>
                                            <span class="badge badge-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('material/view/' . $m->material_id) ?>"
                                            class="text-primary mr-2">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="<?= base_url('material/edit/' . $m->material_id) ?>"
                                            class="text-info mr-2">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="<?= base_url('material/delete/' . $m->material_id) ?>"
                                            onclick="return confirm('Delete this material?')"
                                            class="text-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </section>
</div>