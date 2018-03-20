<?php
$this->db->where('c_bpartner_id',$this->session->userdata('user_id'))->update('m_po_file_additional',array('read'=>'t'));
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
			<th>UPLOAD BY</th>
			<th>FILE NAME</th>
			<th class="text-center"><i class='fa fa-download'></i></th>
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
			<td class="text-center">
				<?php
				if($rev->status == 't'){ 
				?>
				<a href='<?=base_url('data/download_po_file?id='.$rev->id);?>'><i class='fa fa-download'></i></a>
				<?php } ?>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>