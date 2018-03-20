<?php
	//print_r ($data['type_po']);
	
	if(isset($_POST['exfctdate']) && $_POST['exfctdate'] != NULL){
		$this->db->where('exfctdate',$_POST['exfctdate']);
		$exfctdate = $_POST['exfctdate'];
	}else{
		$exfctdate = '';
	}
	if(isset($_POST['kst_etadate']) && $_POST['kst_etadate'] != NULL){
		$this->db->where('date(kst_etadate)',$_POST['kst_etadate']);
		$kst_etadate = $_POST['kst_etadate'];
	}else{
		$kst_etadate = '';
	}
	if(isset($_POST['c_bpartner_id']) && $_POST['c_bpartner_id'] != NULL){
		$this->db->where('c_bpartner_id',$_POST['c_bpartner_id']);
		$c_bpartner_id = $_POST['c_bpartner_id'];
	}else{
		$c_bpartner_id = '';
	}
	if(!isset($_POST['kst_etadate']) && !isset($_POST['exfctdate'])){
		$this->db->limit(100);
	}
	$report = $this->db->get('adt_report_imported_pl_acc');

	$supplier = $this->db->get('m_user');
?>
<div class="row">
	<div class="col-sm-3">
		<form method="POST" action="">
			<label>Ex Factory Date</label>
			<input type="date" name="exfctdate" class="form-control" value="<?=$exfctdate;?>">
			<label>Estimated Time Arrival (ETA)</label>
			<input type="date" name="kst_etadate" class="form-control" value="<?=$kst_etadate;?>">
			<label>Supplier</label>
			<select class="form-control" name="c_bpartner_id">
				<option value="">Pilih Nama Supplier</option>
				<?php
					foreach ($supplier->result() as $dt) {
						echo "<option value='".$dt->user_id."'>".$dt->nama."</option>";
					}
				?>
			</select>
			<label></label>
			<button class="btn btn-flat btn-primary btn-block">Pencarian</button>
			<br>
		</form>
	</div>
	<?php
		if(isset($_POST['kst_etadate']) || isset($_POST['exfctdate'])){
			?>
				<div class="col-sm-9">
					<br>
					<a href="<?=base_url('admin/xls_pilih?exfctdate='.$exfctdate.'&kst_etadate='.$kst_etadate.'&c_bpartner_id='.$c_bpartner_id);?>" class="btn btn-flat btn-success pull-right"><i class='fa fa-download'></i> DOWNLOAD</a>
				</div>
			<?php
		}
	?>
</div>
<?php
	if($report->num_rows() > 0){
?>
<table class="table table-striped table-bordered" id="tablesss">
	<thead class="bg-purple">
		<tr>
			<th style="width: 20px">#</th>
			<th>Ex Factory Date (ETD)</th>
		   	<th>Estimated Time Arrival (ETA)</th>
			<th>Supplier</th>
			<th>PO Supplier</th>
			<th>Packing List</th>
			<th>Invoice</th>
			<th>Category</th>
			<th>Item</th>
			<th>Request Arrival Date</th>
		  	<!--<th>Date Promised</th>-->
			<!--<th>Qty Order</th>-->
			<th>Qty Delivery</th>
			<th>FOC</th>
			<th>UoM</th>
			<th>Qty Package</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$nomor=1;
		foreach($report->result() as $po){
	?>
		<tr>
			<td><?=$nomor++;?></td>
			<td><?=$po->exfctdate;?></td>
			<td><?=$po->kst_etadate;?></td>
			<td><?=$po->supplier;?></td>
			<td><?=$po->documentno;?></td>
			<td><?=$po->no_packinglist;?></td>
			<td><?=$po->kst_invoicevendor;?></td>
			<td><?=$po->category;?></td>
			<td><?=$po->item;?></td>
			<td><?=($po->request_arrival_date == NULL) ? '-' : date('Y-m-d',strtotime($po->request_arrival_date));?></td>
			<!--<td><?=$po->date_promised;?></td>-->
			<!--<td><?=number_format($po->qtyentered,2);?></td>-->
			<td><?=$po->qty_upload;?></td>
			<td><?=$po->foc;?></td>
			<td><?=$po->uomsymbol;?></td>
			<td><?=$po->qty_carton;?></td>
			<?php
				$a = $po->is_locked;
				if ($a == 't') {
					?><td>Locked</td><?php
				}else{
					?><td>Unlocked</td><?php
				}
			?>

		</tr>
	<?php
		}
	?>
	</tbody>
</table>
<?php }else{
	echo "<strong class='text-danger'>No data found</strong>";
} ?>
<script type="text/javascript">
      $(function(){
        $('#tablesss').DataTable({
            'paging':true,
            'scrollX':true
        });

        var url = location.href;
          url = url.split('#');
        if(url[1] != undefined && url[1] != ''){
          detail(url[1]);
        }
      });
    </script>