<table class="table table-bordered table-striped">
      <a href="<?= base_url('Role/add'); ?>" class="btn btn-primary float-right">Add Staff</a>
       <!-- Flash Messages -->
            <?php include('assets/incld/messages.php') ?>

    <thead>
        <tr>
            <th>SR NO</th>
            <th>Role ID</th>
            <th>User Role</th>
            <th>Status</th>
            <th colspan="3" class="text-center">Action</th>
        </tr>
    </thead>

    <tbody>
        <?php if (!empty($roles)): ?>
            <?php foreach ($roles as $i => $role): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= $role->role_id ?></td>
                    <td><?= $role->usr_role ?></td>
                    <td><?= $role->role_st ?></td>

                    <td class="text-center">
                        <a href="<?= base_url('Role/view/'.$role->role_id) ?>">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>

                    <td class="text-center">
                        <a href="<?= base_url('Role/edit/'.$role->role_id) ?>">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>

                    <td class="text-center">
                        <a href="<?= base_url('Role/delete/'.$role->role_id) ?>" 
                           onclick="return confirm('Are you sure?')">
                            <i class="fa fa-trash text-danger"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>