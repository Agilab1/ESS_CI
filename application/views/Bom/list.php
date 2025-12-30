<style>
    th, td { white-space: nowrap; }
table { table-layout: auto !important; }
.card-body { overflow: visible !important; }
.dataTables_wrapper {
    width: 100% !important;
}
.dataTables_wrapper {
    width: 100% !important;
}
.dataTables_wrapper .row {
    width: 100% !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
}

.dataTables_info {
    float: left !important;
    padding-left: 10px;
}
.dataTables_paginate {
    float: right !important;
    padding-right: 10px;
}

.dataTables_wrapper .col-sm-12,
.dataTables_wrapper .col-md-5,
.dataTables_wrapper .col-md-7 {
    width: 100% !important;
}


</style>

<div class="card">

    <!-- Card Header -->
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">BOM – Bill of Material</h4>

        <a href="<?= base_url('bom/add'); ?>"
            class="btn btn-primary ml-auto">
            <i class="fa fa-plus"></i> Add BOM
        </a>
    </div>

    <!-- Card Body -->
    <div class="card-body">

        <div class="table-responsive">
            <table id="bomTable"
                class="table table-bordered table-striped text-center">

                <thead class="btn-primary text-white">
                    <tr>
                        <th>#</th>
                        <th>Parent Material</th>
                        <th>Child Material</th>
                        <th>UOM</th>
                        <th>Qty</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($boms as $i => $b): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= $b->parent_material ?></td>
                            <td><?= $b->child_material ?></td>
                            <td><?= $b->uom ?></td>
                            <td><?= $b->qty ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('bom/view/' . $b->bom_id); ?>">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="<?= base_url('bom/edit/' . $b->bom_id); ?>">
                                    <i class="fa fa-edit text-primary"></i>
                                </a>
                                <a href="<?= base_url('bom/delete/' . $b->bom_id); ?>"
                                    onclick="return confirm('Delete this BOM?');">
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