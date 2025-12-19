<style>
    /* ===== A4 Portrait Page ===== */
    .a4-portrait {
        max-width: 794px;          /* A4 width (px) */
        min-height: 1123px;        /* A4 height (px) */
        margin: auto;
        background: #fff;
    }

    /* Center card inside A4 */
    .a4-card {
        max-width: 500px;
        margin: 30px auto;
    }

    /* Table layout control */
    table {
        width: 100%;
        table-layout: fixed;   /* IMPORTANT for width control */
    }

    th, td {
        text-align: center;
        vertical-align: middle;
        font-size: 14px;
        padding: 6px !important;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Allow wrap for long text */
    .wrap {
        white-space: normal;
    }

    /* Print settings */
    @media print {
        body {
            background: #fff;
        }

        .a4-portrait {
            width: 210mm;
            height: 297mm;
            margin: 0;
        }

        .btn {
            display: none; /* Hide buttons on print */
        }
    }
</style>

<div class="container-fluid a4-portrait mt-4">

    <div class="card shadow a4-card">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white text-center">
            <h5 class="mb-0">Staff Asset Details</h5>
        </div>

        <div class="card-body">

            <!-- STAFF INFO -->
            <div class="row mb-4">
                <div class="col-6">
                    <label class="form-label fw-bold">Staff ID</label>
                    <input type="text" class="form-control"
                           value="<?= $staff->staff_id ?>" readonly>
                </div>

                <div class="col-6">
                    <label class="form-label fw-bold">Staff Name</label>
                    <input type="text" class="form-control"
                           value="<?= $staff->emp_name ?>" readonly>
                </div>
            </div>

            <!-- ASSET LIST -->
            <div class="mb-3">
                <label class="form-label fw-bold">Assigned Assets</label>

                <?php if (!empty($assets)) { ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm align-middle mb-0">

                            <!-- COLUMN WIDTH CONTROL -->
                            <colgroup>
                                <col style="width: 10%;">  <!-- Asset ID -->
                                <col style="width: 30%;">  <!-- Asset Name -->
                                <col style="width: 20%;">  <!-- Site No -->
                                <col style="width: 40%;">  <!-- Site Name -->
                            </colgroup>

                            <thead class="table-light">
                                <tr>
                                    <th>AID</th>
                                    <th>Asset Name</th>
                                    <th>Site No</th>
                                    <th>Site Name</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($assets as $a) { ?>
                                    <tr>
                                        <td><?= $a->asset_id ?></td>
                                        <td class="wrap"><?= $a->asset_name ?></td>
                                        <td><?= $a->site_no ?></td>
                                        <td class="wrap"><?= $a->site_name ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>

                        </table>
                    </div>

                <?php } else { ?>

                    <div class="bg-light text-muted p-3 rounded border text-center">
                        No assets assigned to this staff.
                    </div>

                <?php } ?>
            </div>

        </div>

        <!-- FOOTER -->
        <div class="card-footer text-center">
            <a href="<?= base_url('Staff/list') ?>" class="btn btn-secondary btn-sm">
                ← Back 
            </a>
        </div>

    </div>

</div>
