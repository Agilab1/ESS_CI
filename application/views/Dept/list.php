<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Department List</h4>
        <a href="<?= base_url('deprt/add') ?>" class="btn btn-primary">
            Add Department
        </a>
    </div>

    <div class="card-body">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?= $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>

        <table class="table table-bordered table-striped">
            <thead class="btn-primary text-white">
                <tr>
                    <th>#</th>
                    <th>Department Name</th>
                    <th>Site</th>

                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($department)): ?>
                    <?php foreach ($department as $i => $d): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= $d->department_name ?></td>
                            <td><?= $d->site_no ?> - <?= $d->site_name ?></td>

                            <td class="text-center" style="white-space: nowrap;">
                                <!-- VIEW -->
                                <a href="<?= base_url('deprt/view/' . $d->department_id); ?>" class="mx-1">
                                    <i class="fa fa-eye"></i>
                                </a>

                                <!-- EDIT -->
                                <a href="<?= base_url('deprt/edit/' . $d->department_id); ?>" class="mx-1">
                                    <i class="fa fa-edit text-primary"></i>
                                </a>

                                <!-- DELETE -->
                                <a href="<?= base_url('deprt/delete/' . $d->department_id); ?>"
                                    class="mx-1"
                                    onclick="return confirm('Delete this department?');">
                                    <i class="fa fa-trash text-danger"></i>
                                </a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center text-danger">
                            No Departments Found
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>