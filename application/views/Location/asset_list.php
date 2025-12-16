<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="d-flex justify-content-center align-items-center" style="min-height:100vh; background:#f4f6f9;">

    <div class="container" style="max-width:1100px;">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

            <!-- HEADER -->
            <div class="card-header bg-primary text-white py-3">
                <h4 class="m-0">
                    <i class="fa fa-th-large me-2"></i>
                    Site Asset Verification
                </h4>
            </div>

            <!-- BODY -->
            <div class="card-body p-4">

                <!-- SITE DETAILS -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Site ID</label>
                        <input type="text" class="form-control" 
                               value="<?= $site->site_id ?? '' ?>" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Site No</label>
                        <input type="text" class="form-control" 
                               value="<?= $site->site_no ?? '' ?>" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Site Name</label>
                        <input type="text" class="form-control" 
                               value="<?= $site->site_name ?? '' ?>" readonly>
                    </div>
                </div>

                <!-- ASSET TABLE -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">

                        <thead style="background:#bcdcff;">
                            <tr class="text-center">
                                <th style="width:60px;">#</th>
                                <th>Asset Name</th>
                                <th style="width:150px;">Quantity</th>
                                <th style="width:120px;">Verify</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($assets)): ?>
                                <?php foreach ($assets as $i => $asset): ?>
                                    <tr>
                                        <td class="text-center"><?= $i + 1 ?></td>
                                        <td><?= $asset->asset_name ?></td>
                                        <td class="text-center">
                                            <?= $asset->quantity ?? '-' ?>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" checked>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        No assets found for this site
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>

                <!-- BACK BUTTON -->
                <div class="text-center mt-4">
                    <a href="<?= base_url('Location/list'); ?>" 
                       class="btn btn-secondary px-4 py-2">
                        <i class="fa fa-arrow-left me-1"></i>
                        Back to Location List
                    </a>
                </div>

            </div>
        </div>
    </div>

</div>
