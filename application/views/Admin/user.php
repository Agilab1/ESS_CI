<div class="card">
    <div class="card-header">

              <a href="<?=base_url('admin/add'); ?>"> <button class="btn btn-primary float-right"> Add Users</button></a>
    </div>
    <!-- /.card-header------------------------------------------------------------------------------------------------- -->
    <div class="card-body">
        <!-- <?php include('assets/incld/messages.php') ?> -->
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
                    <th>UserID</th>
                    <th>Name</th>
                    <th style="width:10vw;">Email</th>
                    <th style="width:10vw;">Phone</th>
                    <th>Role</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>View</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <?php if($users){
                     foreach($users as $count => $user){?>
                      <tr>
                        <td><?php echo ++$count; ?></td>
                        <td><?php echo $user->user_nm; ?></td>
                        <td><?php echo $user->mail_id; ?></td>
                        <td><?php echo $user->user_ph; ?></td>
                        <td><?php echo $user->role_id; ?></td>
                        <td><?php echo $user->user_ty; ?></td>
                        <td><?php echo $user->user_st; ?></td>
                        <td class="text-center"><a href="<?=base_url('admin/view').'/'.$user->user_id?>"><i class="fa fa-eye"></i></a></td>
                        <td class="text-center"><a href="<?=base_url('admin/edit').'/'.$user->user_id?>"><i class="fa fa-edit"></i></a></td>
                        <td class="text-center"><a href="<?= base_url('admin/delete_user/'.$user->user_id) ?>"onclick="return confirm('Delete this user?');"><i class="fa fa-trash text-danger"></i></a> </td>                 
                        <?php
                 
                     }
                    }
                 ?>
                
                
            </thead>
            <tbody>
                   
        
            </tbody> 
        </table>
    </div>
</div>