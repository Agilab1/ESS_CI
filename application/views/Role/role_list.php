<div class="card">
     <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Role Details</h2>
        <a style="margin-left: 80%;" href="<?= base_url('Role/add'); ?>" class="btn btn-primary">Add Role</a>
    </div>
    <div class="card-body">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        <table id="dtbl" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <!-- <th>Sr No</th> -->
                    <th>Role ID</th>
                    <th>User Role</th>
                    <th>Status</th>
                    <th class="text-center">View</th>
                    <th class="text-center">Edit</th>
                    <th class="text-center">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($roles)): ?>
                    <?php foreach ($roles as $i => $role): ?>
                        <tr>
                            <!-- <td><?= $i + 1 ?></td> -->
                            <td><?= $role->role_id ?></td>
                            <td><?= $role->usr_role ?></td>
                            <td><?= $role->role_st ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('Role/view/'.$role->role_id); ?>">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('Role/edit/'.$role->role_id); ?>">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('Role/delete/'.$role->role_id); ?>"
                                    onclick="return confirm('Are you sure?');">
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
