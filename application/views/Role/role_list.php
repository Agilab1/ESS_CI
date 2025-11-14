<div class="container">
    <div class="card">
        <div class="card-header">
            <a href="<?= base_url('role/add') ?>" class="btn btn-primary float-right">Add Role</a>
        </div>
        <div class="card-body">
            <table  id="" class="table table-bordered table-striped" style="vertical-align:middle;">
                <thead>
                    <tr>
                        <th>SR NO</th>
                        <th>Role ID</th>
                        <th>User Role</th>
                        <th>Role Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($roles): ?>
                        <?php foreach ($roles as $count =>$role):?>
                            <tr>
                                <th><?= ++$count ?></th>
                                <th><?= $role->role_id ?></th>
                                <th><?= $role->usr_role ?></th>
                                <th><?= $role->role_st ?></th>
                                <td class="text_center"><a href="<?= base_url('Role/view/'.$role->role_id )?>"> <i class="fa fa-eye"></i></a></td>
                                <td class="text-center"><a href="<?= base_url('Role/edit/'.$role->role_id); ?>"> <i class="fa fa-edit"></i></a></td>
                                <td class="text-center"><a href="<?= base_url('Role/delete'.$role->role_id); ?>"> <i class="fa fa-trash text-danger"></i></a></td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>