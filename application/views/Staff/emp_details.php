<div class="container-fluid">
    <div class="row justify-content-center">

        <div class="col-md-12">
            <div class="card card-primary">

                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-8">
                            <h3 class="card-title">Punch Details</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <!-- Responsive Wrapper -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover mb-0">

                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Punch Date</th>
                                    <th>Staff ID</th>
                                    <th>Employee Name</th>
                                    <th>Work Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($works as $item) { ?>
                                    <tr>
                                        <td><?= $item->date ?></td>
                                        <td><?= $item->staff_id ?></td>
                                        <td><?= $item->emp_name ?></td>
                                        <td><?= $item->staff_st ?></td>
                                        <td>
                                            <a href="<?= base_url('Staff/status/' . $item->staff_id); ?>" class="btn btn-sm btn-primary">View</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>


                        </table>
                    </div>

                </div>

            </div>
        </div>


    </div>
</div>