<body class="p-4" style="background:#f5f7fa ; ">
    <div class="d-flex justify-content-center align-items-center" style="height:100vh;">


        <div class="container " style="width:75%; max-width:900px;">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden"
                style="box-shadow: 0 12px 50px rgba(0,0,0,0.22); min-height:350px;">

                <div class="card-header border-5 py-3">
                    <h4 class="m-0"><?= ucfirst($action) ?> Holiday</h4>
                </div>

                <div class="card-body p-4">

                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                    <?php endif; ?>

                    <form method="post" action="<?= base_url('Holiday/save'); ?>" autocomplete="off">

                        <!-- Hidden fields -->
                        <input type="hidden" name="action" value="<?= $action ?>">
                        <input type="hidden" name="old_date_id" value="<?= $holiday->date_id ?? '' ?>">

                        <?php
                        $readonly = ($action == 'view') ? 'readonly disabled' : '';
                        ?>

                        <table class="table table-bordered">

                            <tr>
                                <td class="p-3 w-50">
                                    <label class="form-label">Holiday Date</label>
                                    <input type="date" name="date_id" class="form-control" required
                                        value="<?= isset($holiday->date_id) ? $holiday->date_id : '' ?>"
                                        <?= $readonly ?>>
                                </td>

                                <td class="p-3 w-50">
                                    <label class="form-label">Day Category</label>
                                    <input type="text" name="day_cat" class="form-control" required
                                        placeholder="Public, Festival, Optional"
                                        value="<?= isset($holiday->day_cat) ? $holiday->day_cat : '' ?>"
                                        <?= $readonly ?>>
                                </td>
                            </tr>

                            <tr>
                                <td class="p-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" rows="4" name="day_txt" required
                                        placeholder="Enter holiday description..."
                                        <?= $readonly ?>><?= isset($holiday->day_txt) ? $holiday->day_txt : '' ?></textarea>
                                </td>

                                <!-- <td class="p-3">
                                <label class="form-label">Remark</label>
                                <textarea class="form-control" rows="4" name="remark"
                                    placeholder="Enter remark (optional)..."
                                    <?= $readonly ?>><?= isset($holiday->remark) ? $holiday->remark : '' ?></textarea>
                            </td> -->
                            </tr>

                            <?php if ($action != 'view'): ?>
                                <tr>
                                    <td colspan="2" class="text-center pt-4 pb-3">
                                        <button class="btn btn-primary px-5 py-2 rounded-3">Save</button>
                                        <a href="<?= base_url('Holiday/list'); ?>" class="btn btn-secondary px-4 py-2 rounded-3 ms-3">Back</a>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2" class="text-center pt-4 pb-3">
                                        <a href="<?= base_url('Holiday/list'); ?>" class="btn btn-primary px-4 py-2 rounded-3">Back</a>
                                    </td>
                                </tr>
                            <?php endif; ?>

                        </table>

                    </form>
                </div>
            </div>
        </div>

    </div>
    ```

</body>