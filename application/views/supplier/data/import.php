<div class="row">
	<div class="col-sm-3">
	<form action="<?=base_url('data/import_action');?>" enctype="multipart/form-data" method="POST">
	<label>File</label>
	<input type="file" name="data" class="form-control">
	<label></label>
	<button name="upload" class="btn btn-primary btn-flat btn-block">Import</button>
	</form>
	</div>
</div>