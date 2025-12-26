<form action="<?= base_url('Asset/assign') ?>" method="post">

<input type="hidden" name="asset_id" value="<?= $asset->asset_id ?>">

<select name="cat_id" class="form-control mb-2">
<?php foreach($categories as $c): ?>
<option value="<?= $c->cat_id ?>"><?= $c->cat_name ?></option>
<?php endforeach; ?>
</select>

<select name="site_id" class="form-control mb-2">
<?php foreach($sites as $s): ?>
<option value="<?= $s->site_id ?>"><?= $s->site_name ?></option>
<?php endforeach; ?>
</select>

<select name="staff_id" class="form-control mb-3">
<?php foreach($staffs as $st): ?>
<option value="<?= $st->staff_id ?>"><?= $st->staff_name ?></option>
<?php endforeach; ?>
</select>

<button class="btn btn-success">Assign Asset</button>
</form>
