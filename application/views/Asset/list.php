<style>
    th, td {
        white-space: nowrap;
    }

    th {
        writing-mode: horizontal-tb !important;
        transform: rotate(0deg) !important;
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

        <!-- Flash Message -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
        <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <!-- ASSET TABLE -->
        <div class="table-responsive">
            <table id="dtbl" class="table table-bordered table-striped">

                <thead class="btn-primary text-white">
                    <tr>
                        <th>Asset ID</th>
                        <th>Asset No</th>
                        <th>Asset Name</th>
                        <th>Site</th>
                        <th>Staff</th>
                        <th>Net Value</th>
                        <th>Status</th>
                        <th>Category</th>
                        <th class="text-center" style="width:7vw;">Action</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (!empty($assets)): ?>
                        <?php $i = 1; foreach ($assets as $a): ?>
                            <tr>
                                <td><?= $a->asset_id ?></td>

                                <td><?= $a->asset_no ?></td>
                                <td><?= $a->asset_name ?></td>

                                <!-- Site -->
                                <td><?= $a->site_no ?> – <?= $a->site_name ?></td>

                                <!-- Staff -->
                                <td><?= $a->emp_name ? $a->emp_name : '<i>No Staff</i>' ?></td>

                                <td><?= $a->net_value ?></td>
                                <td class="text-center">
                                <input type="checkbox"
                                    <?= $a->status == 1 ? 'checked' : '' ?>
                                    style="width:18px; height:10px; margin-top:10px; transform: scale(1.4); cursor: not-allowed;">
                                </td>
                                <td><?= $a->cat_no ?> – <?= $a->cat_name ?></td>

                          <td class="text-center" style="white-space:nowrap;">
                                    <a href="<?= base_url('Asset/action/view/' . $a->asset_id); ?>" class="mx-1">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <a href="<?= base_url('Asset/action/edit/' . $a->asset_id); ?>" class="mx-1">
                                        <i class="fa fa-edit primary"></i>
                                    </a>

                                    <a href="<?= base_url('Asset/action/delete/' . $a->asset_id); ?>"
                                       onclick="return confirm('Delete this asset?');"
                                       class="mx-1">
                                        <i class="fa fa-trash text-danger"></i>
                                    </a>
                                </td>

                            </tr>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">No assets found.</td>
                        </tr>
                    <?php endif; ?>

                </tbody>

            </table>
        </div>

    </div>
</div>
