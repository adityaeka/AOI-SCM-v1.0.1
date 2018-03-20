<?php
$this->db2->where('c_bpartner_id',$_GET['id']);
$po = $this->db2->get('f_web_po_detail');
?>
<!-- <a href="<?=base_url('admin/download_datepromised_detail?c_bpartner_id='.$_GET['id']);?>" class="btn btn-success btn-flat pull-right">Download</a><br><br> -->
<table class="table table-striped table-bordered table-hovered small" id="detail">
	<thead class="bg-green">
		<tr>
			<th>PO NUMBER</th>
			<th>ITEM</th>
			<th class="text-center">DATE REQUIRED</th>
			<th class="text-center">DATE PROMISED</th>
			<th class="text-center">ETA</th>
			<th class="text-center">ETD</th>
			<th class="text-center">LOCK DATE</th>
			<th class="text-center">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach($po->result() as $po){
	$dp = $this->db->limit(1)->order_by('created_date','DESC')->where('c_orderline_id',$po->c_orderline_id)->get('m_date_promised');
	if($dp->num_rows() == 0){
		$dpr = 'Not Set';
		$lock = 0;
	}else{
		$dpr = date('d-m-Y',strtotime($dp->result()[0]->date_promised));
		if($dp->result()[0]->lock == 'f')
			$lock = 1;
		else
			$lock = 2;
	}
	$sh = $this->db->where('c_order_id',$po->c_order_id)->get('show_po_status')->num_rows();
	if($sh == 0){
		$sho  = "<a onclick='return show(".$po->c_orderline_id.")' class='shows".$po->c_orderline_id." btn btn-xs btn-success' href='#'>SHOW</a><a onclick='return show(".$po->c_orderline_id.")' class='shows".$po->c_orderline_id." btn btn-xs btn-danger hidden' href='#'>HIDE</a>";
	}else{
		$sho = "<a onclick='return show(".$po->c_orderline_id.")' class='shows".$po->c_orderline_id." btn btn-xs btn-danger' href='#'>HIDE</a><a onclick='return show(".$po->c_orderline_id.")' class='shows".$po->c_orderline_id."	 btn btn-xs btn-success hidden' href='#'>HIDE</a>";
	}
	?>
		<tr>
			<td><?=$po->documentno;?></td>
			<td><?=$po->item;?></td>
			<td class="text-center"><?=(($po->datepromised != NULL) ? date('d-m-Y',strtotime($po->datepromised)) : '-');?></td>
			<td class="text-center"><?=$dpr;?></td>
			<td></td> <!-- kolom ETA -->
			<td></td> <!-- kolom ETD -->
			<td class="text-center">
				<?php
					if($lock == 1)
						echo '<a onclick=\'return lock("lock",'.$po->c_orderline_id.')\' href="#" class="lock"><i class="fa fa-lock"></i></a>';
					else if($lock == 2)
						echo 'Locked';//'<a onclick=\'return lock("unlock",'.$po->c_orderline_id.','.$_GET['id'].')\' href="#" class="lock"><i class="fa fa-unlock"></i></a>';
					else
						echo '-';
				?>
			</td>
			<td class="text-center">Input ETA & ETD</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<script type="text/javascript">
	$(function(){
        $('#detail').DataTable();
	});
	function lock(status,id){
		var x = confirm("Item ini akan terkunci, apakah anda yakin akan melakukan proses ini?");
		if(x == true){
			$.ajax({
				url:'<?=base_url("admin/date_promised");?>',
				data:'status='+status+'&c_orderline_id='+id,
				type:'POST',
				success:function(response){
					$('.modal-body').load('<?=base_url('admin/po_detail?id='.$_GET["id"]);?>');
				}
			})
		}
		return false;
	}
</script>