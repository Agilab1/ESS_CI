<div class="container mt-4">
    <h4>BOM – Bill of Material</h4>

    <a href="<?= base_url('bom/add') ?>" class="btn btn-primary mb-3">
        + Add BOM
    </a>

    <table class="table table-bordered">
        <thead class="table-dark">
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
            <?php foreach ($boms as $i => $b): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= $b->parent_material ?></td>
                    <td><?= $b->child_material ?></td>
                    <td><?= $b->uom ?></td>
                    <td><?= $b->qty ?></td>
                    <td>
                        <!-- VIEW -->
                        <a href="<?= base_url('bom/view/' . $b->bom_id) ?>"
                            class="text-primary mr-2">
                            <i class="fas fa-eye"></i>
                        </a>

                        <!-- EDIT -->
                        <a href="<?= base_url('bom/edit/' . $b->bom_id) ?>"
                            class="text-info mr-2">
                            <i class="fas fa-edit"></i>
                        </a>

                        <!-- DELETE -->
                        <a href="<?= base_url('bom/delete/' . $b->bom_id) ?>"
                            onclick="return confirm('Delete this BOM?')"
                            class="text-danger">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>



                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>