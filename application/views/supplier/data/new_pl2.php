<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> not stable-->
    <script src="http://code.jquery.com/jquery-migrate-1.1.0.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>
<?php

	$count = $this->db2->where('c_bpartner_id',$this->session->userdata('user_id'))->get('f_web_po_header')->num_rows();
	if($count != 0){
		$this->db->order_by('name','asc');
		$warehouse = $this->db->get('m_warehouse');
		?>

	<div class="row">
	<div class="col-md-4">
		<form method="POST" action="">
			<label>Warehouse of Shipment</label>
			<!-- <select class="form-control" name="c_bpartner_id"> -->
				<select class="livesearch" name="m_warehouse_id">
				<option value=""><strong>-- Select Warehouse --</strong></option>
				<?php
					foreach ($warehouse->result() as $dt) {
						echo "<option value='".$dt->m_warehouse_id."'>".$dt->name."</option>";
					}
				?>
			</select>
			<br><br>
			<button class="btn btn-flat btn-primary btn-block">Search</button>
			<br>
		</form>
	</div>
</div>
<?php	 
		if (isset($_POST['m_warehouse_id']) && $_POST['m_warehouse_id'] != NULL) {
			$this->db->where('m_warehouse_id',$_POST['m_warehouse_id']);
			$m_warehouse_id = $_POST['m_warehouse_id']; ?>


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
	<div class="col-sm-4" style="overflow: hidden;">
		<label>Packing List Number</label>
		<input type="text" name="no_packinglist" class="form-control" placeholder="Packing List Name"  id="no_packinglist" required>
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
				<th>Warehouse</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$user = $this->session->userdata('user_id');
		$this->db2->where('c_bpartner_id',$user);
		$this->db2->where('m_warehouse_id',$m_warehouse_id);
		$users = $this->db2->get('f_web_po_header');
		foreach($users->result() as $po){
		$warna = $this->db->where('c_order_id',$po->c_order_id)->get('po_header')->num_rows();
		$wh = $po->m_warehouse_id;
		if ($wh == 1000013) {
			$whs = "Acc AOI 2";
		}elseif ($wh == 1000011) {
			$whs = "Fbr AOI 2";
		}elseif ($wh == 1000001) {
			$whs = "Fbr AOI 1";
		}
		else{
			$whs = "Acc AOI 1";
		}
		?>
			<tr class='<?php if($warna > 0){ echo 'bg-yellow'; } ?>'>
				<td class="text-center"><input type="checkbox" class='<?=$po->c_order_id;?>' onclick='return add(<?=$po->c_order_id;?>)' id="id<?=$po->documentno;?>"></td>
				<td><label for="id<?=$po->documentno;?>"><?=$po->documentno;?></label></td>
				<td><?=$whs;?></td>
			</tr>
		<?php } ?>
		</tbody>
		</table>
	</div>
	<div class="col-sm-8">
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
	<button class="btn btn-success pull-right"  onclick="checkLetter()">Save Packing List</button>
	</div>
	</form>
</div>

			<?php }else{
			echo "No records found!";
		}
}else{ echo "<div class='alert alert-info'>You can't create new packing list, because there is no active Purchase order</div>"; } ?>

<script type="text/javascript">
	$(".livesearch").chosen();

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
	function checkLetter()
        {
			var validasiHuruf = /^[a-zA-Z-/]+$/;
			var no_packinglist = document.getElementById("no_packinglist");
			
            if (no_packinglist.value.match(validasiHuruf)) {
				alert("Your packinglist is " + no_packinglist.value);
			} else {
				alert("Don't use special character like / or space!");
				
			}
		}
</script>
