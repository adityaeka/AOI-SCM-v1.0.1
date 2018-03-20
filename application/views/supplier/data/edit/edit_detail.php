<?php
if($_GET['token'] == $this->session->userdata('session_id')){
	if($_GET['type'] == 2){
		unset($_GET['token'],$_GET['type']);
		$a = $this->db->where($_GET)->get('po_detail');
		foreach($a->result() as $b);
		?>
		<form autocomplete="off" method="POST" action="edit_detail_submit">
			<label>Quantity Delivery</label>
			<input type="number" name="after[qty_upload]" class="form-control" value="<?=$b->qty_upload;?>">
			<input type="hidden" name="where[po_detail_id]" value="<?=$_GET['po_detail_id'];?>" class="form-control">
			<input type="hidden" name="where[no_packinglist]" value="<?=$_GET['no_packinglist'];?>" class="form-control">
			<input type="hidden" class="form-control" name="after[is_edited]" value="t">
			<label>Quantity FOC</label>
			<input type="number" name="after[foc]" class="form-control" value="<?=$b->foc;?>">
			<label>Quantity Package</label>
			<input type="number" name="after[qty_carton]" class="form-control" value="<?=$b->qty_carton;?>">
			<br>
			<button class="btn pull-right btn-primary btn-flat">Update</button>
			<br><br>
		</form>
	<?php
		}else{
			unset($_GET['token'],$_GET['type']);
			?>
			<div class="alert alert-warning"><b>Warning!</b> All material will be overwrite</div>
			<form method="POST" enctype="multipart/form-data" action="update_material">
				<input type="hidden" name="po_detail_id" value="<?=$_GET['po_detail_id'];?>">
				<label>Quantity FOC</label>
				<input type="number" name="foc" class="form-control" placeholder="Quantity FOC">
				<label>Packing List of Material</label>
				<input type="file" name="file" class="form-control">
				<label></label><br>
				<button class="btn btn-primary btn-flat pull-right">Update Packing List</button><br>
			</form>
			<?php
		}
}else{
	echo "Session expired, please refresh this page!";
}
?>