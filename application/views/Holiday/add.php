<!DOCTYPE html>
<html>
<head>
    <title><?= ucfirst($action) ?> Holiday</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">

<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4><?= ucfirst($action) ?> Holiday</h4>
        </div>

        <div class="card-body">

            <!-- Flash Messages -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
            <?php elseif ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
            <?php endif; ?>

            <form action="<?= base_url('holiday/save'); ?>" method="post">

                <!-- Hidden old_date_id for edit -->
                <?php if ($action === 'edit'): ?>
                    <input type="hidden" name="old_date_id" value="<?= $holiday->date_id ?>">
                <?php endif; ?>

                <input type="hidden" name="action" value="<?= $action ?>">

                <div class="mb-3">
                    <label for="date_id">Holiday Date</label>
                    <input type="date" id="date_id" name="date_id" class="form-control"
                           value="<?= isset($holiday) ? $holiday->date_id : set_value('date_id'); ?>"
                           <?= ($action === 'view') ? 'readonly' : 'required'; ?>>
                </div>

                <div class="mb-3">
                    <label for="day_cat">Day Category</label>
                    <input type="text" id="day_cat" name="day_cat" class="form-control"
                           value="<?= isset($holiday) ? $holiday->day_cat : set_value('day_cat'); ?>"
                           <?= ($action === 'view') ? 'readonly' : 'required'; ?>
                           placeholder="Public, Festival, Optional...">
                </div>

                <div class="mb-3">
                    <label for="day_txt">Description</label>
                    <textarea id="day_txt" name="day_txt" class="form-control" rows="3"
                              <?= ($action === 'view') ? 'readonly' : 'required'; ?>><?= isset($holiday) ? $holiday->day_txt : set_value('day_txt'); ?></textarea>
                </div>

                <?php if ($action !== 'view'): ?>
                    <button type="submit" class="btn btn-success"><?= ucfirst($action) ?> Holiday</button>
                <?php endif; ?>
                <a href="<?= base_url('holiday/list'); ?>" class="btn btn-secondary">Back</a>

            </form>
        </div>
    </div>
</div>

</body>
</html>
