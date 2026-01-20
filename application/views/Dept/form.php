<?php
$isView = ($action === 'view');
$disabled = $isView ? 'disabled' : '';
?>

<body class="p-4" style="background:#f5f7fa;">
    <div class="d-flex justify-content-center align-items-center" style="min-height:80vh;">
        <div class="container" style="width:60%; max-width:700px;">

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

                <div class="card-header bg-primary py-3 text-white d-flex justify-content-between align-items-center">
                    <h4 class="m-0 fw-bold">
                        <i class="fa fa-th-large me-2"></i>
                        <?= ucfirst($action) ?> Department
                    </h4>
                </div>


                <div class="card-body p-4">

                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                    <?php endif; ?>

                    <?php if (!$isView): ?>
                        <form method="post" action="<?= base_url('deprt/save'); ?>" autocomplete="off">
                            <input type="hidden" name="action" value="<?= $action ?>">

                            <?php if ($action === 'edit'): ?>
                                <input type="hidden" name="department_id" value="<?= $department->department_id ?>">
                            <?php endif; ?>
                        <?php endif; ?>

                        <table class="table table-bordered">

                            <tr>
                                <td>
                                    <label class="fw-semibold">Department Name</label>
                                    <input type="text"
                                        name="department_name"
                                        class="form-control"
                                        value="<?= $department->department_name ?? '' ?>"
                                        <?= $disabled ?> required>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label class="fw-semibold">Site</label>
                                    <select name="site_id" class="form-control" <?= $disabled ?> required>
                                        <option value="">Select Site</option>

                                        <?php foreach ($sites as $s): ?>
                                            <option value="<?= $s->site_id ?>"
                                                <?= (isset($department->site_id) && $department->site_id == $s->site_id) ? 'selected' : '' ?>>
                                                <?= $s->site_no ?> - <?= $s->site_name ?>
                                            </option>
                                        <?php endforeach; ?>

                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-center pt-3">

                                    <?php if (!$isView): ?>
                                        <button type="submit" class="btn btn-primary me-3">
                                            <i class="fas fa-save me-1"></i> Save
                                        </button>
                                    <?php endif; ?>

                                    <a href="<?= base_url('deprt/list'); ?>" class="btn btn-secondary">Back</a>

                                </td>
                            </tr>

                        </table>

                        <?php if (!$isView): ?>
                        </form>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</body>