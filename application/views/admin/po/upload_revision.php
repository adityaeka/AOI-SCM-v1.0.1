<?php
$nomor=1;
$this->db->order_by('created_date','DESC');
$this->db->join('m_admin','m_admin.user_id = m_po_file.user_id');
$rev = $this->db->where('c_order_id',$_GET['id'])->get('m_po_file');
?>
<table class="table table-striped table-bordered small">
	<thead class="bg-green">
		<tr>
			<th class="text-center" style="width: 20px">NO</th>
			<th>REV TIME</th>
			<th>BY</th>
			<th class="text-center">DOWNLOAD</th>
			<th class="text-center">DELETE</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($rev->result() as $rev){ ?>
		<tr>
			<td class="text-center"><?=$nomor++;?></td>
			<td><?=date("d-m-Y H:i:s",strtotime($rev->created_date));?></td>
			<td><?=$rev->nama;?></td>
			<td class="text-center"><a href="<?=base_url('admin/po_download?token='.$this->session->userdata('session_id').'&id='.$rev->id);?>"><i class='fa fa-download'></i></a></td>
			<td class="text-center">
				<i class="fa fa-trash-o"></i>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>