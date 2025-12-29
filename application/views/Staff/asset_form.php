<style>
    /* ===== A4 Portrait Page ===== */
    .a4-portrait {
        width: 794px;
        min-height: 1123px;
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

    th, td {
        text-align: center;
        vertical-align: middle;
        font-size: 13px;
        padding: 6px !important;
    }

    th {
        background: #f1f3f5;
        font-weight: 600;
    }

    /* DEFAULT cells */
    td {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* 🔥 FULL VALUE SHOW */
    .no-cut {
        white-space: normal !important;
        overflow: visible !important;
        text-overflow: unset !important;
        word-break: break-all;   /* long IDs break */
        font-size: 12px;
    }

    .wrap {
        white-space: normal;
    }

    @media print {
        body {
            margin: 0;
            background: #fff;
        }

        .a4-portrait {
            margin: 0;
            padding: 15mm;
        }

        .btn {
            display: none;
        }

        tr {
            page-break-inside: avoid;
        }
    }
</style>

<div class="a4-portrait">

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
                                <col style="width: 12%;">  <!-- Assdet ID -->
                                <col style="width: 12%;">  <!-- Asset ID -->
                                <col style="width: 22%;">  <!-- Asset Name -->
                                <col style="width: 18%;">  <!-- Serial No -->
                                <col style="width: 12%;">  <!-- Site No -->
                                <col style="width: 24%;">  <!-- Site Name -->
                            </colgroup>

                            <thead>
                                <tr>
                                    <th>Assdet ID</th>
                                    <th>Asset ID</th>
                                    <th>Asset Name</th>
                                    <th>Serial No</th>
                                    <th>Site No</th>
                                    <th>Site Name</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($assets as $a) { ?>
                                    <tr>
                                        <!-- 🔥 FULL ID DISPLAY -->
                                        <td class="no-cut"><?= $a->assdet_id ?></td>
                                        <td class="no-cut"><?= $a->asset_id ?></td>

                                        <td class="wrap"><?= $a->asset_name ?></td>
                                        <td class="no-cut"><?= $a->serial_no ?? '-' ?></td>
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

        <div class="card-footer text-center">
            <a href="<?= base_url('Staff/list') ?>" class="btn btn-secondary btn-sm">
                ← Back
            </a>
        </div>

    </div>

</div>
