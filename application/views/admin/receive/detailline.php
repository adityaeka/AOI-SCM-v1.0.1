<form method="POST" action="<?=base_url('receive/save_temp_detailline');?>">
<input type="hidden" name="po_detail_id" value="<?=$po_detail_id;?>">
<table class="table table-striped table-bordered">
	<thead class="bg-primary">
		<tr>
			<th class="text-center">#</th>
			<th>PO BUYER</th>
			<th>QTY</th>
			<th>QTY ACTUAL</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$nomor = 1;
	foreach($data->result() as $data){ 
		$cek = $this->db->where('po_detailline_id',$data->po_detailline_id)->get('temp_receive_line');
		$count = $cek->num_rows();
		?>	
		<tr>
			<td class="text-center"><input type="checkbox" <?php if($count!=0){ echo 'checked'; } ?> value="<?=$data->po_detailline_id;?>" class='check'></td>
			<td><?=$data->poreference;?></td>
			<td><?=$data->qty_pr;?></td>
			<td style="width: 100px">
				<input name="data[<?=$data->po_detailline_id;?>]" <?php if($count!=0){ echo "value='".$cek->result()[0]->qty."'"; }else{ echo 'disabled'; } ?> type="text" class="form-control input-xs input-<?=$data->po_detailline_id;?>" style="width: 50px" name="">
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<button class="btn btn-primary">Save Temp</button><br>
</form>
<script type="text/javascript">
	$(function(){
		$('.check').click(function(){
			if($(this).is(':checked')){
				$('.input-'+$(this).val()).prop('disabled',false);
			}else{
				$('.input-'+$(this).val()).prop('disabled',true);
			}
		})
	})
</script>