<style>
    th, td { white-space: nowrap; }
table { table-layout: auto !important; }
.card-body { overflow: visible !important; }

</style>
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">

<div class="card">

    <!-- Card Header -->
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">BOM – Bill of Material</h4>

        <a href="<?= base_url('bom/add') ?>" class="btn btn-primary">
            <i class="fa fa-plus"></i> Add BOM
        </a>
    </div>

    <!-- Card Body -->
    <div class="card-body">

        <div class="table-responsive">
        <table id="bomTable" class="table table-bordered table-striped">

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
                        <a href="<?= base_url('bom/view/'.$b->bom_id) ?>" class="mx-1">
                            <i class="fa fa-eye text-primary"></i>
                        </a>
                        <a href="<?= base_url('bom/edit/'.$b->bom_id) ?>" class="mx-1">
                            <i class="fa fa-edit text-info"></i>
                        </a>
                        <a href="<?= base_url('bom/delete/'.$b->bom_id) ?>"
                           onclick="return confirm('Delete this BOM?')"
                           class="mx-1">
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

</div>
</section>
</div>
