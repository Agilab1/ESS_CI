<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Role Details</h4>
        <a style="margin-left: 80%;" href="<?= base_url('Role/add'); ?>" class="btn btn-primary">Add Role</a>
    </div>

    <div class="card-body">

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
        <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <table id="dtbl" class="table table-bordered table-striped">
            <thead class="btn-primary">
                <tr>
                    <th>Role ID</th>
                    <th>User Role</th>
                    <th>Status</th>
                    <th class="text-center" style="width: 6vw;">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($roles)): ?>
                    <?php foreach ($roles as $i => $role): ?>
                        <tr>

                            <td><?= $role->role_id ?></td>
                            <td><?= $role->usr_role ?></td>
                            <td><?= $role->role_st ?></td>

                            <!-- ALL ACTION ICONS IN ONE TD (Datatable safe) -->
                            <td class="text-center" style="white-space: nowrap;">

                                <a href="<?= base_url('Role/view/' . $role->role_id); ?>" class="mx-1">
                                    <i class="fa fa-eye"></i>
                                </a>

                                <a href="<?= base_url('Role/edit/' . $role->role_id); ?>" class="mx-1">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a href="<?= base_url('Role/delete/' . $role->role_id); ?>"
                                    onclick="return confirm('Are you sure?');"
                                    class="mx-1">
                                    <i class="fa fa-trash text-danger"></i>
                                </a>

                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>