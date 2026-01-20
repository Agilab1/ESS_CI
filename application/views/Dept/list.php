<style>
    .department-header {
        display: flex;
        align-items: center;
    }

    .department-header a {
        margin-left: auto;
    }

    table {
        table-layout: fixed;
        width: 100%;
    }

    /* # column */
    table th:nth-child(1),
    table td:nth-child(1) {
        width: 5%;
        text-align: center;
    }

    /* Department ID */
    table th:nth-child(2),
    table td:nth-child(2) {
        width: 10%;
        text-align: center;
    }

    /* Department Name */
    table th:nth-child(3),
    table td:nth-child(3) {
        width: 15%;
    }

    /* Site – zyada space */
    table th:nth-child(4),
    table td:nth-child(4) {
        width: 45%;
        word-break: break-word;
    }

    /* Action – chhota */
    table th:nth-child(5),
    table td:nth-child(5) {
        width: 10%;
        white-space: nowrap;
        text-align: center;
    }
</style>
<div class="card">
    <div class="card-header department-header">
        <h4 class="mb-0">Department List</h4>

        <a href="<?= base_url('deprt/add'); ?>" class="btn btn-primary">
            Add Department
        </a>
    </div>

    <div class="card-body">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?= $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>

        <table id="dtbl" class="table table-bordered table-striped mb-0 table-hover">
            <thead class="btn-primary text-white">
                <tr>
                    <th>#</th>
                    <th>Department ID</th>
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
                            <td><?= $d->department_id ?></td>
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