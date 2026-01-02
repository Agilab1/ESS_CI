<style>
    th,
    td {
        white-space: nowrap;
    }

    table {
        table-layout: auto !important;
    }

    .card-header a.btn {
        margin-left: auto !important;
    }
</style>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Asset Details</h4>
        <a href="<?= base_url('Asset/action/add'); ?>" class="btn btn-primary">
            <i class="fa fa-plus"></i> Add Asset
        </a>
    </div>

    <div class="card-body">

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
        <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <div class="table-responsive">
            <table id="dtbl" class="table table-bordered table-striped">

                <thead class="btn-primary text-white">
                    <tr>
                        <th>ID</th>
                        <th>Asset No</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Material</th>
                        <th>Category</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($assets)): foreach ($assets as $a): ?>
                            <tr>
                                <td><?= $a->asset_id ?></td>
                                <td><?= $a->asset_no ?></td>
                                <td><?= $a->asset_name ?></td>
                                <td class="text-center">
                                    <a href="<?= site_url('Asset/serials/' . $a->asset_id); ?>"
                                        style="color:#0d6efd; text-decoration:underline; cursor:pointer; text-decoration: none;">
                                        <?= (int)$a->quantity ?>
                                    </a>
                                </td>
                                <!-- <td></td> -->


                                <td>
<?php if (!empty($a->material_code)): ?>
    <a href="<?= site_url('Bom/material/' . $a->material_id); ?>"
       style="color:#0d6efd; text-decoration:underline;">
        <?= $a->material_code ?>
    </a>
<?php else: ?>
    <span class="text-muted">N/A</span>
<?php endif; ?>
</td>


                                <td><?= $a->cat_no ?> – <?= $a->cat_name ?></td>

                                <td class="text-center">
                                    <a href="<?= base_url('Asset/action/view/' . $a->asset_id); ?>" class="mx-1"><i class="fa fa-eye"></i></a>
                                    <a href="<?= base_url('Asset/action/edit/' . $a->asset_id); ?>" class="mx-1"><i class="fa fa-edit text-primary"></i></a>
                                    <a href="<?= base_url('Asset/action/delete/' . $a->asset_id); ?>" class="mx-1" onclick="return confirm('Delete asset?');">
                                        <i class="fa fa-trash text-danger"></i>
                                    </a>
                                </td>

                            </tr>
                        <?php endforeach;
                    else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No assets found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>