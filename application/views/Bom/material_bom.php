<div class="d-flex justify-content-center align-items-center" style="min-height:100vh; background:#f4f6f9;">

    <div class="container" style="max-width:1100px;">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

            <div class="card-header bg-primary text-white py-3">
                <h4 class="m-0">BOM – Bill of Material</h4>
            </div>

            <div class="card-body p-4">
                <a href="<?= base_url('Bom/add_child/' . $material->material_id) ?>"
                    class="btn btn-primary mb-3">
                    <i class="fa fa-plus"></i> Add Child BOM
                </a>

                <!-- PARENT MATERIAL -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="fw-bold">Material ID</label>
                        <input type="text" class="form-control"
                            value="<?= $material->material_id ?>" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold">Material Code</label>
                        <input type="text" class="form-control"
                            value="<?= $material->material_code ?>" readonly>
                    </div>
                </div>

                <!-- CHILD BOM TABLE -->
                <div class="table-responsive">
                    <table class="table table-bordered text-center">

                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>BOM ID</th>
                                <th>Child Material</th>
                                <th>UOM</th>
                                <th>Qty</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($boms)): ?>
                                <?php $i = 1;
                                foreach ($boms as $b): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $b->bom_id ?></td>
                                        <td><?= $b->child_name ?></td>
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
                                    <td colspan="6" class="text-muted py-3">
                                        No BOM found for this material
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>

                <div class="text-center mt-4">
                    <a href="<?= base_url('Material'); ?>" class="btn btn-secondary">
                        ← Back to Material List
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>