<style type="text/css">
	.sorting, .sorting_asc, .sorting_desc {
    background : none;
}
</style>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-striped table-bordered" id="tabless"> 
			<thead class="bg-green">
				<tr>
					<th class="text-center" style="width: 30px">#</th>
					<th>Nama</th>
					<th class="text-center">Input ETA & ETD</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$nomor=1;
				$sp = $this->db->get('m_user');
				foreach($sp->result() as $sp){
					$c_order = array();
					$c_orderline = array();
				?>
				<tr>
					<td class="text-center"><?=$nomor++;?></td>	
					<td><?=$sp->nama;?></td>	
					<td class="text-center"><a href='javascript:void(0);' onclick='return detail(<?=$sp->user_id;?>,"<?=$sp->nama;?>")'>Detail</a></td>	
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	$(function(){
        $('#tabless').DataTable();
	})
	function delete_file(id){
		alert(id);
		return false;
	}
	function detail(id,name){
		var modal = $('#myModal > div > div');
		$('#myModal').modal('show');
		modal.children('.modal-header').children('.modal-title').html('Purchase Order <b>'+name+'</b>');
		modal.parent('.modal-dialog').addClass('modal-lg');
		modal.children('.modal-body').html('<center>Loading..</center>');
		modal.children('.modal-body').load('<?=base_url('admin/eta_etd_detail?id=');?>'+id);
		return false;
	}
	function upload_file(id,name,user_id){
		var modal = $('#myModal_ > div > div');
		$('#myModal_').modal('show');
		modal.children('.modal-header').children('.modal-title').html(name);
		modal.parent('.modal-dialog').addClass('modal-sm');
		modal.children('.modal-body').html('<center>Loading..</center>');
		modal.children('.modal-body').html($('.upload_form').html());
		$('.upload_po').submit(function(){
			var data = new FormData(this);
			$.ajax({
				url:'<?=base_url('admin/po_upload_file_submit?c_order_id=');?>'+id,
				type: "POST",
				data: data,
				contentType: false,       
				cache: false,          
				processData:false, 
				success: function(response){
					if(response == 1){
						$('#myModal_').modal('hide');
						$('#myModal > div > div').children('.modal-body').html('<center>Loading..</center>').load('<?=base_url('admin/po_add_upload?id=');?>'+user_id);
					}
				}
			})
			return false;
		})
		return false;
	}
	function upload(id,name){
		var modal = $('#myModal > div > div');
		$('#myModal').modal('show');
		modal.children('.modal-header').children('.modal-title').html('Upload PO <b>'+name+'</b>');
		modal.parent('.modal-dialog').addClass('modal-lg');
		modal.children('.modal-body').html('<center>Loading..</center>');
		modal.children('.modal-body').load('<?=base_url('admin/po_upload?id=');?>'+id);
		return false;
	}
	function upload__(id,name){
		var modal = $('#myModal > div > div');
		$('#myModal').modal('show');
		modal.children('.modal-header').children('.modal-title').html('ADDITIONAL FILE FOR <b>'+name+'</b>');
		modal.parent('.modal-dialog').addClass('modal-lg');
		modal.children('.modal-body').html('<center>Loading..</center>');
		modal.children('.modal-body').load('<?=base_url('admin/po_add_upload?id=');?>'+id);
		return false;
	}
	function revisi(id,name){
		var modal = $('#myModal_ > div > div');
		$('#myModal_').modal('show');
		modal.children('.modal-header').children('.modal-title').html('REVISION STATUS : '+name);
		modal.parent('.modal-dialog').removeClass('modal-sm');
		modal.children('.modal-body').html('<center>Loading..</center>');
		modal.children('.modal-body').load("<?=base_url('admin/po_upload_revision?id=');?>"+id);
		return false;
	}
	function revisi_file(id,name){
		var modal = $('#myModal_ > div > div');
		$('#myModal_').modal('show');
		modal.children('.modal-header').children('.modal-title').html('REVISION STATUS : '+name);
		modal.parent('.modal-dialog').removeClass('modal-sm');
		modal.children('.modal-body').html('<center>Loading..</center>');
		modal.children('.modal-body').load("<?=base_url('admin/file_upload_revision?id=');?>"+id);
		return false;
	}
</script>