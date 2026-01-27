<style>
    input[readonly],
    input[disabled],
    select[disabled] {
        background-color: #e9ecef !important;
        color: #495057 !important;
        border: 1px solid #ced4da !important;
        cursor: not-allowed;
        box-shadow: none;
    }

    .bom-form .row {
        margin: 0;
    }

    .bom-form .row>div {
        border-right: 1px solid #dee2e6;
        border-bottom: 1px solid #dee2e6;
        padding-top: 8px;
        padding-bottom: 8px;
    }

    .bom-form .row>div:first-child {
        border-left: 1px solid #dee2e6;
    }

    .bom-form .header-row>div {
        background: #f8f9fa;
        font-weight: 600;
        border-top: 2px solid #ced4da;
        border-bottom: 2px solid #ced4da;
    }

    .bom-form {
        border: 1px solid #ced4da;
        border-radius: 6px;
        overflow: hidden;
    }
</style>

<div class="container" style="max-width:1100px; margin-top:30px;">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white py-3">
            <h4 class="m-0">
                <i class="fa fa-th-large me-2"></i>
                 Serial No : <?= !empty($material->serial_no) ? $material->serial_no : 'N/A' ?>
            </h4>
        </div>



        <div class="card-body p-4">

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="fw-bold">Material ID</label>
                    <input class="form-control bg-light" value="<?= $material->material_id ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label class="fw-bold">Material Code</label>
                    <input class="form-control bg-light" value="<?= $material->material_code ?>" readonly>
                </div>
            </div>

            <div class="border rounded p-3 bom-form">

                <div class="row fw-bold bg-light text-center border-bottom py-2">
                    <div class="col-md-1">#</div>
                    <div class="col-md-2">BOM ID</div>
                    <div class="col-md-3">Child Material</div>
                    <div class="col-md-2">UOM</div>
                    <div class="col-md-2">Qty</div>
                    <div class="col-md-2">Action</div>
                </div>

                <form method="post" action="<?= base_url('Bom/save_child') ?>">
                    <div class="row text-center align-items-center py-2 border-bottom">

                        <div class="col-md-1 text-primary fw-bold">+</div>

                        <div class="col-md-2">
                            <input class="form-control" value="Auto" readonly>
                            <input type="hidden" name="parent_material_id" value="<?= $material->material_id ?>">
                        </div>

                        <div class="col-md-3">
                            <select name="child_material_id" id="child_material_add" class="form-control" required>
                                <option value="">Select</option>
                                <?php foreach ($materials as $m): ?>
                                    <?php if ($m->material_id != $material->material_id): ?>
                                        <option value="<?= $m->material_id ?>"><?= $m->material_code ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="uom_id" id="uom_add" class="form-control" required>
                                <option value="">Select UOM</option>
                                <?php foreach ($uoms as $u): ?>
                                    <option value="<?= $u->uom_id ?>"><?= $u->uom_name ?> (<?= $u->uom_code ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <input type="number" name="qty" class="form-control" placeholder="Qty" required>
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-primary"><i class="fa fa-plus"></i></button>
                        </div>

                    </div>
                </form>

                <?php $i = 1;
                foreach ($boms as $b): ?>

                    <div class="row text-center align-items-center py-2 border-bottom">
                        <input type="hidden" class="bom_id" value="<?= $b->bom_id ?>">

                        <div class="col-md-1"><?= $i++ ?></div>

                        <div class="col-md-2">
                            <input class="form-control bg-light" value="<?= $b->bom_id ?>" readonly>
                        </div>

                        <div class="col-md-3">
                            <input class="form-control bg-light" value="<?= $b->child_name ?>" readonly>
                        </div>

                        <div class="col-md-2">
                            <input class="form-control bg-light" value="<?= $b->uom_name ?> (<?= $b->uom_code ?>)" readonly>
                        </div>

                        <div class="col-md-2">
                            <input type="number" class="form-control qty d-none" value="<?= $b->qty ?>">
                            <input type="text" class="form-control bg-light qty-show" value="<?= $b->qty ?>" readonly>
                        </div>

                        <div class="col-md-2">
                            <button type="button" class="editBtn btn btn-link p-0">
                                <i class="fa fa-edit text-primary"></i>
                            </button>

                            <button type="button" class="saveBtn d-none btn btn-link p-0">
                                <i class="fa fa-check text-success"></i>
                            </button>

                            <a href="<?= base_url('bom/delete/' . $b->bom_id) ?>" onclick="return confirm('Delete BOM?')">
                                <i class="fa fa-trash text-danger"></i>
                            </a>
                        </div>

                    </div>

                <?php endforeach; ?>

            </div>
        </div>
    </div>

    <script>
        document.getElementById('child_material_add').addEventListener('change', function() {
            let id = this.value;
            if (!id) return;

            fetch("<?= base_url('Material/get_material_details/') ?>" + id)
                .then(res => res.json())
                .then(data => {
                    if (data.uom_id) {
                        document.getElementById('uom_add').value = data.uom_id;
                    }
                });
        });

        document.querySelectorAll('.editBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                let row = this.closest('.row');

                row.querySelector('.qty-show').classList.add('d-none');
                row.querySelector('.qty').classList.remove('d-none');

                this.classList.add('d-none');
                row.querySelector('.saveBtn').classList.remove('d-none');

                row.querySelector('.qty').focus();
            });
        });

        document.querySelectorAll('.saveBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                let row = this.closest('.row');

                let data = new FormData();
                data.append('bom_id', row.querySelector('.bom_id').value);
                data.append('qty', row.querySelector('.qty').value);

                fetch("<?= base_url('Bom/update_child') ?>", {
                    method: 'POST',
                    body: data
                }).then(() => location.reload());
            });
        });
    </script>