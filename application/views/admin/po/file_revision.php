<?php
$nomor=1;
$this->db->order_by('created_date','DESC');
$this->db->join('m_admin','m_admin.user_id = m_po_file_additional.user_id');
$rev = $this->db->where('c_order_id',$_GET['id'])->get('m_po_file_additional');
?>
<table class="table table-bordered small">
	<thead class="bg-green">
		<tr>
			<th class="text-center" style="width: 20px">NO</th>
			<th>REV TIME</th>
			<th>BY</th>
			<th>FILE NAME</th>
			<th class="text-center">DOWNLOAD</th>
			<th class="text-center">DELETE</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($rev->result() as $rev){ 
		if($rev->status == 'f'){
			$bg = 'bg-danger';
		}else{
			$bg = '';
		}
		?>
		<tr class="<?=$bg;?>">
			<td class="text-center"><?=$nomor++;?></td>
			<td><?=date("d-m-Y H:i:s",strtotime($rev->created_date));?></td>
			<td><?=$rev->nama;?></td>
			<td><?=str_replace(explode('-',$rev->file_name)[0].'-','',$rev->file_name);?></td>
			<td class="text-center"><a href="<?=base_url('admin/file_download?token='.$this->session->userdata('session_id').'&id='.$rev->id);?>"><i class='fa fa-download'></i></a></td>
			<td class="text-center">
				<?php
				if($rev->status == 't'){ 
				?>
				<a class="delete_file" url="<?=base_url('admin/file_add_delete?token='.$this->session->userdata('session_id').'&id='.$rev->id);?>" href='javascript:void(0)'><i class='fa fa-trash-o'></i></a>
				<?php } ?>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<script type="text/javascript">
	$('.delete_file').click(function(){
		var x = confirm('Apakah anda yakin akan menhapus file ini? setelah dihapus file tidak dapat dikembalikan.');
		if(x == true){
			$.ajax({
				url:$(this).attr('url'),
				type:'POST',
				success:function(data){
					if(data == 1){

					}
				}
			})
		}
		return false;
	})
</script>