<?php

	$count = $this->db2->where('c_bpartner_id',$this->session->userdata('user_id'))->get('f_web_po_header')->num_rows();
	if($count != 0){

?>
<style type="text/css">
	input[type=number]::-webkit-inner-spin-button, 
	input[type=number]::-webkit-outer-spin-button { 
	    -webkit-appearance: none;
	    -moz-appearance: none;
	    appearance: none;
	    margin: 0; 
	}
	.inp{
		width: 50px;
		border: 0px;
		background:inherit;
		text-align: center;
	}
	.imp{
		width: auto;
	}
	.actived{
		border-bottom: 1px dotted #999;
	}
	.dataTables_filter{
		margin-left: -100px;
		border: 0px solid #000;
	}
</style>
<div class="row">
	<?php if($this->session->userdata('user_id') == 1001120){ ?>
	<div class="col-sm-12">
		<a href="#" class="btn pull-right btn-warning btn-flat upload_pl"><i class='fa fa-upload'></i> Upload Packing List</a>
	</div>
	<?php } ?>
	<form method="POST" action="new_pl_submit" enctype="multipart/form-data">
	<div class="col-sm-3" style="overflow: hidden;">
		<label>Packing List Number</label>
		<input type="text" name="no_packinglist" class="form-control" placeholder="Packing List Name" required>
		<!--label>Surat Jalan or DN</label-->
		<input type="hidden" name="kst_suratjalanvendor" value ="-" class="form-control" placeholder="Surat Jalan or DN">
		<label>Invoice</label>
		<input type="text" name="kst_invoicevendor" class="form-control" value="-" placeholder="Invoice">
		<label>Resi Number or AWB</label>
		<input type="text" name="kst_resi" class="form-control" value="-" placeholder="Resi Number or AWB">
		<label>Ex Factory Date</label>
		<input type="text" id="datepicker" name="kst_etddate" class="form-control" placeholder="" required>
		<label>Estimated Time Arrival (ETA)</label>
		<input type="text" id="datepicker2" name="kst_etadate" class="form-control" placeholder="" required>
		<label>List of Purchase Order</label>
		<table class="table table-striped table-bordered" id="tables">
		<thead class="bg-green">
			<tr>
				<th style="width: 30px" class="text-center">#</th>
				<th>PO Number</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$user = $this->session->userdata('user_id');
		$this->db2->where('c_bpartner_id',$user);
		$users = $this->db2->get('f_web_po_header');
		foreach($users->result() as $po){
		$warna = $this->db->where('c_order_id',$po->c_order_id)->get('po_header')->num_rows();
		?>
			<tr class='<?php if($warna > 0){ echo 'bg-yellow'; } ?>'>
				<td class="text-center"><input type="checkbox" class='<?=$po->c_order_id;?>' onclick='return add(<?=$po->c_order_id;?>)' id="id<?=$po->documentno;?>"></td>
				<td><label for="id<?=$po->documentno;?>"><?=$po->documentno;?></label></td>
			</tr>
		<?php } ?>
		</tbody>
		</table>
	</div>
	<div class="col-sm-9">
	<label>Item list</label>
	<input type="hidden" name="type_po" value="<?=$users->result()[0]->type_po;?>">
	<?php
		if($users->result()[0]->type_po == 2){ 
	?>

	<table class="table table-striped table-bordered">
		<thead class="bg-green">
			<tr>
				<th class="text-center">#</th>
				<th>PO NUMBER</th>
				<th>ITEM</th>
				<th>PRODUCT CODE</th>
				<th>QTY ORDER</th>
				<th class="text-center">UOM</th>
				<th class="text-center">DP</th>
				<th class="text-center">QTY DLV</th>
				<th class="text-center">FOC</th>
				<th class="text-center">QTY PACKAGE</th>
			</tr>
		</thead>
		<tbody class="view">

		</tbody>
	</table>
<?php }else{ ?>
	<table class="table table-striped table-bordered">
		<thead class="bg-green">
			<tr>
				<th class="text-center">#</th>
				<th>PO NUMBER</th>
				<th>ITEM</th>
				<th>PRODUCT CODE</th>
				<th>QTY ORDER</th>
				<th class="text-center">UOM</th>
				<th class="text-center">QTY DEL</th>
				<th class="text-center">FOC</th>
				<th class="text-center">IMPORT</th>
			</tr>
		</thead>
		<tbody class="view">

		</tbody>
	</table>
	<?php
	} ?>
		DP : Date Promised
	<button class="btn btn-success pull-right">Save Packing List</button>
	</div>
	</form>
</div>
<div class="hidden upload_pl_pop">
	<form enctype="multipart/form-data" method="POST" class="upload_pl_" action='<?=base_url('data/upload_pl_new');?>' >
		<label>File</label>
		<input type="file" name="file" class="form-control">
		<label></label>
		<button class="btn btn-success btn-flat btn-block">Verify File</button>
	</form>
	<div class="view_">

	</div>
</div>
<script type="text/javascript">
	$(function(){
		$('.upload_pl').click(function(){
			$('.view_').html('');
			var val = $('.upload_pl_pop').html();
			$('#myModal').modal('show');
			$('.modal-dialog').addClass('modal-sm');
			$('.modal-title').text('Upload Packing List');
			$('.modal-body').html(val);
			$('.upload_pl_').submit(function(){
				var data = new FormData(this);
				$.ajax({
					url:$(this).attr('action'),
					type: "POST",
					data: data,
					contentType: false,       
					cache: false,          
					processData:false, 
					success: function(response){
						$('.modal-dialog').removeClass('modal-sm');
						$('.view_').html(response);
					}
				})
				return false;
			})
		})
	})
	function add(id){
		if($('.'+id).is(':checked')){
			$.ajax({
				url:'<?=base_url('data/show_line');?>',
				type:'POST',
				data:'id='+id,
				success:function(data){
					$('.view').append(data);
				}
			});
		}else{
			$('._'+id).remove();
		}
	}
	function activated(id){
		if($('.c_'+id).is(':checked')){
			$('.qd_'+id).prop('disabled',false).addClass('actived').val($('.qd_'+id).attr('val'));
			$('.foc_'+id).prop('disabled',false).addClass('actived').val('0');
			$('.car_'+id).prop('disabled',false).addClass('actived').val('1');
			$('.imp_'+id).prop('disabled',false).addClass('actived').val('0');
		}else{
			$('.qd_'+id).val('').prop('disabled',true).removeClass('actived');
			$('.foc_'+id).val('').prop('disabled',true).removeClass('actived');
			$('.car_'+id).val('').prop('disabled',true).removeClass('actived');
			$('.imp_'+id).val('').prop('disabled',true).removeClass('actived');
		}
	}
</script>
<?php }else{ echo "<div class='alert alert-info'>You can't create new packing list, because there is no active Purchase order</div>"; } ?>
