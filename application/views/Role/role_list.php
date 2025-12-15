<style>
    /* ===== Card Header Right Align Fix ===== */
    .card-header {
        position: relative;
    }

    /* Desktop view */
    @media (min-width: 768px) {
        .card-header a.btn {
            margin-left: auto !important;
        }
    }

    /* Mobile view */
    @media (max-width: 767px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .card-header a.btn {
            width: 100%;
            text-align: center;
            margin-top: 10px;
        }
    }
</style>
<div class="card">

    <!--  HEADER SAME + MOBILE FIX ADDED  -->
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
        <h4 class="mb-0">Role Details</h4>
        <a href="<?= base_url('Role/add'); ?>" class="btn btn-primary mt-2 mt-md-0 ms-md-auto"> Add Role</a>
    </div>



    <div class="card-body">

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success flash-msg"><?= $this->session->flashdata('success'); ?></div>
        <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger flash-msg"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <!--  MOBILE RESPONSIVE TABLE ADDED HERE  -->
        <div class="table-responsive" style="overflow-x:auto; -webkit-overflow-scrolling: touch;">

            <table id="dtbl" class="table table-bordered table-striped">
                <thead class="btn-primary">
                    <tr>
                        <th class="text-nowrap">Role ID</th>
                        <th class="text-nowrap">User Role</th>
                        <th class="text-nowrap">Status</th>
                        <th class="text-center text-nowrap" style="width: 6vw;">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($roles)): ?>
                        <?php foreach ($roles as $i => $role): ?>
                            <tr>
                                <td><?= $role->role_id ?></td>
                                <td class="text-break"><?= $role->usr_role ?></td>
                                <td><?= $role->role_st ?></td>

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

        </div> <!-- table-responsive end -->

    </div>
</div>


<script>
    // Flash message auto hide after 6 seconds
    setTimeout(function() {
        const flash = document.querySelector('.flash-msg');
        if (flash) {
            flash.style.transition = "opacity 0.5s ease";
            flash.style.opacity = "0";

            setTimeout(() => {
                if (flash) flash.remove();
            }, 500);
        }
    }, 6000);
</script>