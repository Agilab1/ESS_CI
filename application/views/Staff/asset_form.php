<style>
    input[readonly],
    input[disabled],
    select[disabled] {
        background: #e9ecef !important;
        cursor: not-allowed;
    }

    .asset-form .row {
        margin: 0
    }

    .asset-form .row>div {
        border-right: 1px solid #dee2e6;
        border-bottom: 1px solid #dee2e6;
        padding: 8px;
    }

    .asset-form .row>div:first-child {
        border-left: 1px solid #dee2e6;
    }

    .asset-form .header-row>div {
        background: #f8f9fa;
        font-weight: 600;
        border-top: 2px solid #ced4da;
        border-bottom: 2px solid #ced4da;
    }

    .asset-form {
        border: 1px solid #ced4da;
        border-radius: 6px;
        overflow: hidden;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="container" style="max-width:1100px;margin-top:30px;">
    <div class="card shadow-lg border-0 rounded-4">

        <div class="card-header bg-primary text-white py-3">
            <h4 class="m-0">
                <i class="fa fa-laptop me-2"></i> Staff Asset Details
            </h4>
        </div>

        <div class="card-body p-4">
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <?= $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <!-- STAFF INFO -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="fw-bold">Staff ID</label>
                    <input class="form-control bg-light" value="<?= $staff->staff_id ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label class="fw-bold">Staff Name</label>
                    <input class="form-control bg-light" value="<?= $staff->emp_name ?>" readonly>
                </div>
            </div>

            <div class="border rounded p-3 asset-form">

                <!-- HEADER -->

                <div class="row header-row text-center py-2">
                    <div class="col-md-1">#</div>
                    <div class="col-md-2">Serial No</div>
                    <div class="col-md-1">Asset ID</div>
                    <div class="col-md-2">Asset Name</div>
                    <div class="col-md-2">Site</div>
                    <div class="col-md-3">Owner</div>
                    <div class="col-md-1">Action</div>
                </div>

                <!-- ADD ROW -->

                <form method="post" action="<?= base_url('Staff/save_staff_asset') ?>">
                    <div class="row text-center align-items-center py-2 border-bottom">

                        <!-- PLUS -->
                        <div class="col-md-1 fw-bold text-primary">+</div>

                        <!-- SERIAL NO DROPDOWN -->
                        <div class="col-md-2">

                           <select name="serial_no" id="serial_no" class="form-control" required>
    <option value="">Select Serial No</option>
    <?php foreach ($serials as $s): ?>
        <option value="<?= $s->serial_no ?>">
            <?= $s->serial_no ?>
        </option>
    <?php endforeach; ?>
</select>


                            <input type="hidden" name="staff_id" value="<?= $staff->staff_id ?>">
                        </div>

                        <!-- ASSET ID -->
                        <div class="col-md-1">
                            <input type="text" name="asset_id" id="asset_id"
                                class="form-control bg-light" readonly>
                        </div>

                        <!-- ASSET NAME -->
                        <div class="col-md-2">
                            <input type="text" name="asset_name" id="asset_name"
                                class="form-control bg-light" readonly>
                        </div>

                        <!-- SITE -->
                        <div class="col-md-2">
                            <input type="text" id="site_name"
                                class="form-control bg-light" readonly>
                            <input type="hidden" name="site_id" id="site_id">
                        </div>

                        <!-- OWNER -->
                        <div class="col-md-3">
                            <input type="text" class="form-control bg-light"
                                value="<?= $staff->emp_name ?>" readonly>
                        </div>

                        <!-- ACTION -->
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>

                    </div>
                </form>


                <!-- SAVED ROWS -->
                <?php $i = 1;
                foreach ($assets as $a): ?>
                    <div class="row text-center align-items-center py-2 border-bottom">

                        <div class="col-md-1"><?= $i++ ?></div>

                        <div class="col-md-2">
                            <input class="form-control bg-light"
                                value="<?= $a->serial_no ?>" readonly>
                        </div>

                        <div class="col-md-1">
                            <input class="form-control bg-light"
                                value="<?= $a->asset_id ?>" readonly>
                        </div>

                        <div class="col-md-2">
                            <input class="form-control bg-light"
                                value="<?= $a->asset_name ?>" readonly>
                        </div>

                        <div class="col-md-2">
                            <input class="form-control bg-light"
                                value="<?= $a->site_no ?>" readonly>
                        </div>

                        <div class="col-md-3">
                            <select class="form-control change-owner"
                                data-assdet="<?= $a->assdet_id ?>">

                                <option value="">Select Staff</option>

                                <?php foreach ($all_staff as $s): ?>
                                    <option value="<?= $s->staff_id ?>"
                                        <?= ($s->staff_id == $a->staff_id) ? 'selected' : '' ?>>
                                        <?= $s->emp_name ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>
                        <div class="col-md-1">
                            <?php if (!isset($action) || $action !== 'view'): ?>
                                <a href="<?= base_url('Staff/delete_asset/' . $a->assdet_id) ?>"
                                    onclick="return confirm('Delete asset?')"

                                    class="btn btn-link p-0">
                                    <i class="fa fa-trash text-danger"></i>
                                </a>
                            <?php else: ?>
                                <!-- view mode → no action -->
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </div>


                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('serial_no').addEventListener('change', function() {

        let serial = this.value;

        if (serial === '') {
            document.getElementById('asset_id').value = '';
            document.getElementById('asset_name').value = '';
            document.getElementById('site_name').value = '';
            document.getElementById('site_id').value = '';
            return;
        }

        fetch("<?= base_url('Staff/get_asset_by_serial_ajax') ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "serial_no=" + encodeURIComponent(serial)
            })
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    document.getElementById('asset_id').value = res.data.asset_id;
                    document.getElementById('asset_name').value = res.data.asset_name;
                    document.getElementById('site_name').value = res.data.site_name;
                    document.getElementById('site_id').value = res.data.site_id;
                } else {
                    alert('Asset not found for selected serial');
                }
            });
    });



    $(document).on('change', '.change-owner', function() {

        let staff_id = $(this).val(); // new owner
        let assdet_id = $(this).data('assdet'); // asset row id

        // 🔥 asset_form layout sाठी
        let row = $(this).closest('.row');

        if (!staff_id) return;

        if (!confirm('Change ownership?')) {
            location.reload();
            return;
        }

        $.ajax({
            url: "<?= base_url('Staff/change_asset_owner') ?>",
            type: "POST",
            dataType: "json",
            data: {
                assdet_id: assdet_id,
                staff_id: staff_id
            },
            success: function(res) {

                if (res.status === 'success') {

                    alert('Ownership changed successfully');

                    // 🔥 STEP 1: remove from current staff
                    row.fadeOut(300, function() {
                        $(this).remove();

                        // 🔥 STEP 2: go to selected staff asset page
                        window.location.href =
                            "<?= base_url('Staff/asset_form/') ?>" + staff_id;
                    });

                } else {
                    alert('Update failed');
                }
            },
            error: function() {
                alert('Something went wrong');
            }
        });
    });
</script> 