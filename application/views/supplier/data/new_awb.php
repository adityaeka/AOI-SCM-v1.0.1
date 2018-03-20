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
	<form method="POST" action="new_awb_submit" enctype="multipart/form-data">
	<div class="col-sm-4" style="overflow: hidden;">
		<label>AWB or Resi Number</label>
		<input type="text" name="no_packinglist" class="form-control" placeholder="AWB or Resi Number" required>
		<br>
		<label>List of Packing List</label>
		<table class="table table-striped table-bordered" id="tables">
		<thead class="bg-green">
			<tr>
				<th style="width: 30px" class="text-center">#</th>
				<th>Packing List Number</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$user = $this->session->userdata('user_id');
		$this->db->where('c_bpartner_id',$user);
		$users = $this->db->get('adt_awb_header');
		foreach($users->result() as $pl){
		// $warna = $this->db->where('c_order_id',$po->c_order_id)->get('po_header')->num_rows();
		?>
			<tr class='<?php if($warna > 0){ echo 'bg-yellow'; } ?>'>
				<td class="text-center"><input type="checkbox" class='<?=$pl->no_packinglist;?>' onclick='return add("<?=$pl->no_packinglist;?>"")' id="id<?=$pl->no_packinglist;?>"></td>
				<td><label for="id<?=$pl->no_packinglist;?>"><?=$pl->no_packinglist;?></label></td>
			</tr>
		<?php } ?>
		</tbody>
		</table>
	</div>
	<div class="col-sm-8">
	<label>Item list</label>
	
	<table class="table table-striped table-bordered">
		<thead class="bg-green">
			<tr>
				<th class="text-center">#</th>
				<th>PL NUMBER</th>
				<th>PO NUMBER</th>
				<th>ITEM</th>
				<th>QTY DELIVERED</th>
				<th class="text-center">QTY PACKAGE</th>
			</tr>
		</thead>
		<tbody class="view">

		</tbody>
	</table>		
	<button class="btn btn-success pull-right">Save AWB or RESI</button>
	</div>
	</form>
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
				url:'<?=base_url('data/show_line_awb');?>',
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
<?php }else{ echo "<div class='alert alert-info'>You can't input Air Way Bill because there is no active Packing List</div>"; } ?>
