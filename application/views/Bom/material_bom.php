<div class="d-flex justify-content-center align-items-center"
    style="min-height:100vh; background:#f4f6f9;">

    <div class="container" style="max-width:1100px;">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

            <!-- HEADER -->
            <div class="card-header bg-primary text-white py-3">
                <h4 class="m-0">BOM – Bill of Material</h4>
            </div>

            <!-- BODY -->
            <div class="card-body p-4">

                <a href="<?= base_url('Bom/add_child/' . $material->material_id) ?>"
                    class="btn btn-primary mb-4">
                    <i class="fa fa-plus"></i> Add Child BOM
                </a>

                <!-- PARENT MATERIAL -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="fw-bold">Material ID</label>
                        <input type="text"
                            class="form-control"
                            value="<?= $material->material_id ?>"
                            readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold">Material Code</label>
                        <input type="text"
                            class="form-control"
                            value="<?= $material->material_code ?>"
                            readonly>
                    </div>
                </div>

                <!-- CHILD BOM TABLE -->
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">

                        <!-- TABLE HEADER -->
                        <thead style="background:#b6d4fe;">
                            <tr >
                                <th ><input class="form-control  text-center fw-bold " value="#"  readonly ></th>
                                <th><input class="form-control text-center fw-bold" value="BOM ID" readonly></th>
                                <th><input class="form-control text-center fw-bold" value="Child Material" readonly></th>
                                <th><input class="form-control text-center fw-bold" value="UOM" readonly></th>
                                <th><input class="form-control text-center fw-bold" value="QTY" readonly></th>
                                <th><input class="form-control text-center fw-bold" value="Action" readonly></th>
                            </tr>
                        </thead>

                        <!-- TABLE BODY -->
                        <tbody>
                            <?php if (!empty($boms)): ?>
                                <?php $i = 1;
                                foreach ($boms as $b): ?>
                                    <tr>
                                        <td>
                                            <input class="form-control bg-light text-center"
                                                value="<?= $i++ ?>" readonly>
                                        </td>

                                        <td>
                                            <input class="form-control bg-light text-center"
                                                value="<?= $b->bom_id ?>" readonly>
                                        </td>

                                        <td>
                                            <input class="form-control bg-light text-center"
                                                value="<?= $b->child_name ?>" readonly>
                                        </td>

                                        <td>
                                            <input class="form-control bg-light text-center"
                                                value="<?= $b->uom ?>" readonly>
                                        </td>

                                        <td>
                                            <input class="form-control bg-light text-center"
                                                value="<?= $b->qty ?>" readonly>
                                        </td>

                                        <!-- ACTIONS AS INPUT STYLE -->
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">

                                                <!-- VIEW -->
                                                <span class="form-control text-center"
                                                    style="width:42px; cursor:pointer"
                                                    title="View"
                                                    onclick="location.href='<?= base_url('bom/view/' . $b->bom_id) ?>'">
                                                    <i class="fa fa-eye text-secondary"></i>
                                                </span>

                                                <!-- EDIT -->
                                                <span class="form-control text-center"
                                                    style="width:42px; cursor:pointer"
                                                    title="Edit"
                                                    onclick="location.href='<?= base_url('bom/edit/' . $b->bom_id) ?>'">
                                                    <i class="fa fa-edit text-primary"></i>
                                                </span>

                                                <!-- DELETE -->
                                                <span class="form-control text-center"
                                                    style="width:42px; cursor:pointer"
                                                    title="Delete"
                                                    onclick="if(confirm('Delete BOM?')) location.href='<?= base_url('bom/delete/' . $b->bom_id) ?>'">
                                                    <i class="fa fa-trash text-danger"></i>
                                                </span>

                                            </div>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-muted py-4">
                                        No BOM found for this material
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>

                <!-- BACK -->
                <div class="text-center mt-4">
                    <a href="<?= base_url('Material'); ?>" class="btn btn-secondary">
                        ← Back to Material List
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>