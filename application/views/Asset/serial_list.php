<!-- <style>
.table td, .table th { white-space: nowrap; }

.status-switch {
    transform: scale(1.3);
    cursor: pointer;
}
.card-header {
    display: flex !important;
}
</style> -->
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

<div class="container-fluid p-4">

    <div class="card shadow-sm border-0 rounded-4">

        <!-- HEADER -->
        <div class="card-header">

            <div class="d-flex w-100 align-items-center">

                <div>
                    <h4 class="mb-0">
                        Asset: <?= $asset->asset_name ?> (<?= $asset->asset_no ?>)
                    </h4>
                    <div class="text-muted small">
                        Asset ID: <strong><?= $asset->asset_id ?></strong>
                    </div>
                </div>

                <div class="flex-grow-1"></div>

                <a href="<?= base_url('asset/detail/add/' . $asset->asset_id) ?>" class="btn btn-primary">
                    Add Detail
                </a>

            </div>

        </div>

        <div class="card-body">

            <!-- FLASH MESSAGES -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success auto-hide">
                    <?= $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger auto-hide">
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <table id="dtbl" class="table table-bordered table-striped mb-0 table-hover">
                <thead class="btn-primary text-white">
                    <tr>
                        <th>#</th>
                        <th>Serial No</th>
                        <th>Model No</th>
                        <th>Description</th>
                        <th>Material</th>
                        <th>Site</th>
                        <th>Department</th>
                        <th>Staff</th>
                        <th>Net Value</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($serials as $i => $s): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= $s->serial_no ?></td>
                            <td><?= $s->model_no ?? '-' ?></td>
                            <td><?= $s->descr ?? '-' ?></td>
                            <td>
                                <?php if (!empty($s->material_code)): ?>
                                    <a href="<?= site_url('Bom/material/' . $s->material_id); ?>"
                                        style="color:#0d6efd; text-decoration:underline;">
                                        <?= $s->material_code ?>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">N/A</span>
                                <?php endif; ?>
                            </td>

                            <td><?= $s->site_name ?? '-' ?></td>

                            <!-- Department -->
                            <td><?= !empty($s->department_name) ? $s->department_name : '-' ?></td>

                            <!-- Staff -->
                            <td><?= !empty($s->emp_name) ? $s->emp_name : '-' ?></td>

                            <td><?= number_format($s->net_val, 2) ?></td>

                            <td class="text-center">
                                <input type="checkbox"
                                    class="form-check-input status-switch"
                                    <?= $s->status == 1 ? 'checked' : '' ?>>
                            </td>

                            <td class="text-center">
                                <a href="<?= base_url('asset/detail/view/' . $s->assdet_id) ?>" class="mx-1 text-primary">
                                    <i class="fa fa-eye"></i>
                                </a>

                                <a href="<?= base_url('asset/detail/edit/' . $s->assdet_id) ?>" class="mx-1 text-primary">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a href="<?= base_url('asset/detail/delete/' . $s->assdet_id) ?>"
                                    onclick="return confirm('Delete this detail?')"
                                    class="mx-1 text-danger">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>


            <div class="text-center mt-3">
                <a href="<?= base_url('Asset/list') ?>" class="btn btn-secondary">Back</a>
            </div>

        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        document.querySelectorAll('.auto-hide').forEach(function(el) {
            el.style.transition = '0.5s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        });
    }, 2500);
</script>