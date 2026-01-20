<style>
    /* ===== A4 Landscape Page ===== */
    .a4-landscape {
        width: 1123px;
        /* Landscape width */
        min-height: 794px;
        /* Landscape height */
        margin: 20px auto;
        background: #fff;
        padding: 20px;
        box-sizing: border-box;
    }

    .a4-card {
        width: 100%;
        margin: 0 auto;
        border-radius: 6px;
    }

    table {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
    }

    th,
    td {
        text-align: center;
        vertical-align: middle;
        font-size: 13px;
        padding: 6px !important;
    }

    th {
        background: #f1f3f5;
        font-weight: 600;
    }

    td {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .no-cut {
        white-space: normal !important;
        overflow: visible !important;
        text-overflow: unset !important;
        word-break: break-word;
        font-size: 12px;
    }

    .wrap {
        white-space: normal;
        word-break: break-word;
    }

    /* ===== PRINT SETTINGS ===== */
    @media print {
        @page {
            size: A4 landscape;
            margin: 12mm;
        }

        body {
            margin: 0;
            background: #fff;
        }

        .a4-landscape {
            margin: 0;
            padding: 0;
        }

        .btn,
        select {
            display: none !important;
        }

        tr {
            page-break-inside: avoid;
        }
    }

    .input-like {
        border-radius: 6px;
        height: 28px;
        padding: 6px 10px;
        font-size: 14px;
        border: 1px solid #0d6efd;
        box-shadow: none;
    }

    .input-like:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, .25);
    }
</style>

<div class="a4-landscape">

    <div class="card shadow a4-card">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white text-center">
            <h5 class="mb-0 fw-bold float-sm-left">
                <i class="fa fa-th-large me-2"></i>
                Staff Asset Details
            </h5>
        </div>

        

        <div class="card-body">

            <!-- STAFF INFO -->
            <div class="row mb-4">
                <div class="col-6">
                    <label class="form-label fw-bold">Staff ID</label>
                    <input type="text" class="form-control"
                        value="<?= $staff->staff_id ?? '' ?>" readonly>
                </div>

                <div class="col-6">
                    <label class="form-label fw-bold">Staff Name</label>
                    <input type="text" class="form-control"
                        value="<?= $staff->emp_name ?? '' ?>" readonly>
                </div>
            </div>

            <!-- ASSET LIST -->
            <div class="mb-3">
                <label class="form-label fw-bold">Assigned Assets</label>

                <?php if (!empty($assets)) { ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm align-middle mb-0">

                            <colgroup>
                                <col style="width: 8%;"> <!-- Assdet ID -->
                                <col style="width: 8%;"> <!-- Asset ID -->
                                <col style="width: 18%;"> <!-- Asset Name -->
                                <col style="width: 14%;"> <!-- Serial No -->
                                <col style="width: 8%;"> <!-- Site No -->
                                <col style="width: 16%;"> <!-- Site Name -->
                                <col style="width: 28%;"> <!-- 🔥 Change Ownership -->
                            </colgroup>

                            <thead>
                                <tr>
                                    <th>Assdet ID</th>
                                    <th>Asset ID</th>
                                    <th>Asset Name</th>
                                    <th>Serial No</th>
                                    <th>Site No</th>
                                    <th>Site Name</th>
                                    <th>Change Ownership</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($assets as $a) { ?>
                                    <tr>
                                        <td class="no-cut"><?= $a->assdet_id ?></td>
                                        <td class="no-cut"><?= $a->asset_id ?></td>
                                        <td class="wrap"><?= $a->asset_name ?></td>
                                        <td>
                                            <select class="form-select input-like" disabled>
                                                <option>
                                                    <?= $a->serial_no ?? '-' ?>
                                                </option>
                                            </select>
                                        </td>

                                        <td><?= $a->site_no ?></td>
                                        <td class="wrap"><?= $a->site_name ?></td>

                                        <!-- CHANGE OWNERSHIP -->
                                        <td>
                                            <select class="form-select change-owner input-like"
                                                data-assdet="<?= $a->assdet_id ?>">
                                                <option value="">-- Select --</option>
                                                <?php foreach ($all_staff as $s) { ?>

                                                    <option value="<?= $s->staff_id ?>"
                                                        <?= ($s->staff_id == $a->staff_id) ? 'selected' : '' ?>>
                                                        <?= $s->staff_id ?> - <?= $s->emp_name ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>

                        </table>
                        <div id="noAssetBox"
                            class="bg-light text-muted p-3 rounded border text-center"
                            style="<?= !empty($assets) ? 'display:none;' : '' ?>">
                            No assets assigned to this staff.
                        </div>

                    </div>

                <?php } else { ?>

                    <div class="bg-light text-muted p-3 rounded border text-center">
                        No assets assigned to this staff.
                    </div>

                <?php } ?>
            </div>

        </div>

        <div class="card-footer text-center">
            <a href="<?= base_url('Staff/list') ?>" class="btn btn-secondary btn-sm">
                ← Back
            </a>
        </div>

    </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on('change', '.change-owner', function() {

        let staff_id = $(this).val();
        let assdet_id = $(this).data('assdet');
        let row = $(this).closest('tr');

        if (!staff_id) return;

        if (!confirm('Change ownership?')) {
            $(this).val('');
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

                    // 🔥 remove row
                    row.fadeOut(300, function() {
                        $(this).remove();

                        // 🔥 check if table empty
                        if ($('tbody tr').length === 0) {
                            $('.table-responsive').hide();
                            $('#noAssetBox').show();
                        }
                    });
                }
            },
            error: function() {
                alert('Something went wrong');
            }
        });
    });
</script>