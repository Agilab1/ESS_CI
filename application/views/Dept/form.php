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

            <input type="hidden" name="action" value="<?= $action ?>">
            <input type="hidden" name="department_id" value="<?= $department->department_id ?? '' ?>">

            <!-- Department Name -->
            <div class="mb-3">
                <label class="form-label">Department Name</label>
                <input type="text"
                       name="department_name"
                       class="form-control"
                       value="<?= $department->department_name ?? '' ?>"
                       <?= ($action === 'view') ? 'readonly' : 'required' ?>>
            </div>

            <!-- Site -->
            <div class="mb-3">
                <label class="form-label">Site</label>
                <select name="site_id"
                        class="form-control"
                        <?= ($action === 'view') ? 'disabled' : 'required' ?>>

                    <option value="">Select Site</option>
                    <?php foreach ($sites as $s): ?>
                        <option value="<?= $s->site_id ?>"
                            <?= (isset($department->site_id) && $department->site_id == $s->site_id) ? 'selected' : '' ?>>
                            <?= $s->site_no ?> - <?= $s->site_name ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <?php if ($action !== 'view'): ?>
                <button type="submit" class="btn btn-success">Save</button>
            <?php endif; ?>

            <a href="<?= base_url('deprt/list') ?>" class="btn btn-secondary">Back</a>

        </form>
    </div>
</div>
