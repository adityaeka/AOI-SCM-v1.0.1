<script type="text/javascript">
	$(function(){
		$("body").keypress(function(event){		
			var input = event.keyCode;
			var res = String.fromCharCode(input);
//			if(input > 44 && input < 58 || input == 13){
				var x = ''; 
				if(event.keyCode != 13){
					x = $('.scan').val()+res;
					$('.scan').val(x);
				}else{
					$('.scansubmit').submit();
					$('.scan').val('');
				}
//			}
		});
		$('.scansubmit').submit(function(){
			var dataa = $(this).serialize();
			$.ajax({
				url:$(this).attr('action'),
				data:$(this).serialize(),
				type:'POST',
				success:function(data){
					if(data == 0){
						$('.status').html('<span class="text-danger">TERJADI KESALAHAN, SILA ULANGI!</span>');
					}else if(data == 2){
						$('.status').html('<span class="text-danger">ITEM SUDAH SIAP DI RECEIVE!</span>');
					}else if(data == 3){
						$('.status').html('<span class="text-danger">ITEM SUDAH DIRECEIVE!</span>');
					}else if(data == 4){
						$('.status').html('<span class="text-danger">ITEM BEDA JENIS WAREHOUSE!</span>');
					}else if(data == 10){
						$('.status').html('<span class="text-danger">MEMILIH DETAIL LINE!</span>');
						$('#myModal').modal('show');
						$('.modal-title').text('Pilih PO Buyer');
						$.ajax({
							url:"<?=base_url('receive/view_detailline');?>",
							type:"POST",
							data:dataa,
							success:function(line){
								$('.modal-body').html(line);
							}
						})
					}else{
						$('.status').html('<span class="text-danger">SUKSES!</span>');
						$('.view').load('<?=base_url("receive/view_temp");?>')
					}
				}
			})
			return false;
		})
	})
	function receive(id){
		$check = $('.c_'+id).is(':checked');
		if($check == true){
			alert(id);
		}else{
			alert('not checked');
		}
	}
</script>
<div class="row">
	<div class="col-xs-12">
		<center>
			<img src="<?=base_url('assets/cube.svg');?>" width='50' height='auto'>
			<br><br>
			<b>SILAHKAN PINDAI NOMOR <u>ITEM BARCODE</u></b>
			<h5 class="status"></h5>
		</center>
	</div>
	<div class="col-xs-12">
	<form method="POST" action="<?=base_url('receive/set_temp');?>" class="scansubmit">
		<input type="text" name="barcode_id" class="scan" readonly style="position: fixed; top: 60px;">
	</form>
	</div>
	<div class="col-xs-12 view">
	<?php $this->load->view('admin/receive/temp_view'); ?>
	</div>
</div>