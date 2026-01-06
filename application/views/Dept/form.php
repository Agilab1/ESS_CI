<div class="card">
    <div class="card-header">
        <h4><?= ucfirst($action) ?> Department</h4>
    </div>

    <div class="card-body">
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('deprt/save') ?>">
            <input type="text" name="department_name" class="form-control" value="<?= $department->department_name ?? '' ?>" <?= ($action === 'view') ? 'readonly' : 'required' ?>>

            <input type="hidden" name="action" value="<?= $action ?>">
            <input type="hidden" name="department_id" value="<?= $department->department_id ?? '' ?>">

            <div class="mb-3">
                <label class="form-label">Department Name</label>
                <input type="text" name="department_name" class="form-control" required value="<?= $department->department_name ?? '' ?>">
            </div>

            <?php if ($action !== 'view'): ?>
                <button type="submit" class="btn btn-success">Save</button>
            <?php endif; ?>

            <a href="<?= base_url('deprt/list') ?>" class="btn btn-secondary">
                Back
            </a>

        </form>
    </div>
</div>