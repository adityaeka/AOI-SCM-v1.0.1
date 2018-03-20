<?php
	$this->db->distinct();
	$this->db->select('no_packinglist, kst_invoicevendor, kst_etddate, kst_etadate');
	$this->db->where('no_packinglist',$pl);
	//$this->db->where('kst_suratjalanvendor',$sj);
	$this->db->where('kst_invoicevendor',$inv);
	//$this->db->where('kst_resi',$awb);
	$this->db->where('isactive =', 't');
	$datass = $this->db->get('po_detail')->result();
?>

<div class="alert alert-info">
	<table>
	<tr><td style="width: 300px;">PACKING LIST NUMBER</td><td style="width: 10px;"> : </td><td> <span style="font-size: 16px;""><b><?php echo $pl;?></b></span></td></tr>
	<!--tr><td>SURAT JALAN (SJ) / DELIVERY NOTE (DN)</td><td> : </td><td> <span style="font-size: 16px;""><b><?php echo $sj;?></b></span></td></tr-->
	<tr><td>INVOICE (INV)</td><td> : </td><td> <span style="font-size: 16px;""><b><?php echo $inv;?></b></span></td></tr>
	<!--tr><td>RESI / AIRWAYBILL (AWB)</td><td> : </td><td><span style="font-size: 16px;""><b><?php echo $awb;?></b></span></td></tr-->
	</table>
</div>
<?php
	$this->db->where('no_packinglist',$pl);
	//$this->db->where('kst_suratjalanvendor',$sj);
	$this->db->where('kst_invoicevendor',$inv);
	//$this->db->where('kst_resi',$awb);
	$this->db->where('isactive =', 't');
	$this->db->order_by('documentno');
	$data = $this->db->get('po_detail')->result();
?>
<?php
if($data[0]->type_po == 2){
?>
<table class="table table-striped table-bordered">
	<thead class="bg-blue">
		<tr>
			<th>#</th>
			<th>PO NUMBER</th>
			<th>WAREHOUSE</th>
			<th>ITEM CODE</th>
			<th>PRODUCT CODE</th>
			<th>QTY ORDER</th>
			<th>QTY DEL</th>
			<th>QTY FOC</th>
			<th>UOM</th>
			<th>QTY PACKAGE</th>
			<th class="text-center" colspan="2">ACTION</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$number=1;
	foreach($data as $b){
	?>
		<tr>
			<td><?=$number++;?></td>
			<td><?=$b->documentno;?></td>
			<td><?=$b->m_warehouse_id;?></td>
			<td><?=$b->item;?></td>
			<td><?=$b->desc_product;?></td>
			<td><?=number_format($b->qtyentered,2);?></td>
			<td><?=$b->qty_upload;?></td>
			<td><?=$b->foc;?></td>
			<td><?=$b->uomsymbol;?></td>
			<td><?=$b->qty_carton;?></td>
			<td class="text-center">
				<a href="<?=base_url('data/edit_pl_list?type='.$b->type_po.'&token='.$this->session->userdata('session_id').'&po_detail_id='.$b->po_detail_id.'&no_packinglist='.$b->no_packinglist);?>" class='edit'><i class='fa fa-edit'></i></a>
			</td>
			<td class="text-center">
				<a href="<?=base_url('data/delete_pl_list?&po_detail_id='.$b->po_detail_id);?>" class="delete"><i class='fa fa-trash-o'></i></a>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php }else{ ?>
<table class="table table-striped table-bordered">
<thead class="bg-blue">
	<tr>
		<th>#</th>
		<th>PO NUMBER</th>
		<th>ITEM CODE</th>
		<th>PRODUCT CODE</th>
		<th>QTY ORDER</th>
		<th>QTY DEL</th>
		<th>QTY FOC</th>
		<th>UOM</th>
		<th>DETAIL</th>
		<th  class="text-center" colspan="2">ACTION</th>
	</tr>
</thead>
	<tbody>
	<?php
	$number=1;
	foreach($data as $b){
	?>
		<tr>
			<td><?=$number++;?></td>
			<td><?=$b->documentno;?></td>
			<td><?=$b->item;?></td>
			<td><?=$b->desc_product;?></td>
			<td><?=number_format($b->qtyentered,2);?></td>
			<td>
				<?php
						$a = $this->db->select_sum('qty')->where('po_detail_id',$b->po_detail_id)->get('m_material')->result();
						foreach($a as $ba){
							echo number_format($ba->qty,3);
						}
					?>
			</td>
			<td><?=$b->foc;?></td>
			<td><?=$b->uomsymbol;?></td>
			<td><a href="<?=base_url('data/detail/'.$b->po_detail_id);?>" class="detail">Detail</a></td>
			<td class="text-center">
				<a href="<?=base_url('data/edit_pl_list?type='.$b->type_po.'&token='.$this->session->userdata('session_id').'&po_detail_id='.$b->po_detail_id.'&no_packinglist='.$b->no_packinglist);?>" class='edit'><i class='fa fa-edit'></i></a>
			</td>
			<td class="text-center">
				<a href="<?=base_url('data/delete_pl_list/'.$b->po_detail_id.'/'.$b->no_packinglist);?>" class="delete"><i class='fa fa-trash-o'></i></a>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>
<script type="text/javascript">
$(function(){
	$('.detail').click(function(){
		var modal = $('#myModal_ > div > div');
		$('#myModal_').modal('show');
		modal.children('.modal-header').children('.modal-title').html('Detail Material');
		modal.children('.modal-body').load($(this).attr('href'));
		return false;
	});
	$('.edit').click(function(){
		var modal = $('#myModal_ > div > div');
		$('#myModal_').modal('show');
		modal.children('.modal-header').children('.modal-title').html('Edit Packing List');
		modal.children('.modal-body').load($(this).attr('href'));
		return false;
	});

	$('.delete').click(function(){
			var x = confirm('Do you realy want to delete this detail?');
			if(x==false)
				return false;
	});
	})
</script>