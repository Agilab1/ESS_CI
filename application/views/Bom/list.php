<style>
    .table input.form-control,
    .table select.form-control {
        background-color: #f8f9fa;
        /* light grey */
        border-color: #ced4da;
    }

    .table input.form-control[readonly],
    .table input.form-control:disabled {
        background-color: #e9ecef;
        cursor: not-allowed;

        .table input.form-control,
        .table select.form-control {
            background-color: #f8f9fa;
            border-radius: 6px;
        }

    }
</style>
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h4 class="mb-0">BOM – Bill of Material</h4>

        <a href="<?= base_url('bom/add'); ?>"
            class="btn btn-primary ml-auto">
            <i class="fa fa-plus"></i> Add BOM
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">

                <thead class="btn-primary text-white">
                    <tr>
                        <th>#</th>
                        <th>Parent Material</th>
                        <th>Child Material</th>
                        <th>UOM</th>
                        <th>Qty</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($boms)): ?>
                        <?php foreach ($boms as $i => $b): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= $b->parent_material ?></td>
                                <td><?= $b->child_material ?></td>
                                <td><?= $b->uom ?></td>
                                <td><?= $b->qty ?></td>
                                <td>
                                    <a href="<?= base_url('bom/view/' . $b->bom_id) ?>"><i class="fa fa-eye"></i></a>
                                    <a href="<?= base_url('bom/edit/' . $b->bom_id) ?>"><i class="fa fa-edit text-primary"></i></a>
                                    <a href="<?= base_url('bom/delete/' . $b->bom_id) ?>"
                                        onclick="return confirm('Delete BOM?')">
                                        <i class="fa fa-trash text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-muted">No BOM found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>