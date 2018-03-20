<?php
	if(isset($_POST['c_bpartner_id']) && $_POST['c_bpartner_id'] != NULL){
		$this->db->where('c_bpartner_id',$_POST['c_bpartner_id']);
		$c_bpartner_id = $_POST['c_bpartner_id'];
	}else{
		$c_bpartner_id = '';
	}
	if(!isset($_POST['c_bpartner_id'])){
		$this->db->limit(100);
	}
	$report = $this->db->get('po_detail');
?>
<div class="row">
	<div class="col-sm-3">
		<form method="POST" action="">
			<label>SUPPLIER</label>
			<input type="text" name="c_bpartner_id" class="form-control" placeholder="Input Nama Supplier" value="<?=$c_bpartner_id;?>">
			<label></label>
			<button class="btn btn-flat btn-primary btn-block">Pencarian</button>
			<br>
		</form>
	</div>
</div>
<?php
	if($report->num_rows() > 0){
?>
		<table class="table table-striped table-bordered">
			<thead>
				<tr class="bg-green">
				<th class="text-center">#</th>
				<th>SUPPLIER</th>
				<th>PL NUMBER</th>
				<!--th>SJ / DN </th-->
				<th>INVOICE</th>
				<!--th>RESI / AWB</th-->
				<!--th class="text-center">QC-CHECK REPORT</th>
				<th class="text-center">QC REPORT</th-->
				<th class="text-center">DETAIL</th>
				<th class="text-center">ACTION</th>
				</tr>
			</thead>
			<tbody>
<?php
$nomor=1;
	foreach($report->result() as $rep){
		?>
		<tr>

		</tr>
		<?php
	}
?>
</tbody>
</table>
<?php }else{
	echo "<strong class='text-danger'>No data found</strong>";
} ?>