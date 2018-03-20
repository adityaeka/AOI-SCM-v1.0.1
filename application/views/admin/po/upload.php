<?php
$this->db2->where('c_bpartner_id',$_GET['id']);
$po = $this->db2->get('f_web_po_header');
$nomor = 1;
?>
<div class="alert alert-info">
Klik pada <b>REVISION STATUS</b> untuk menampilkan daftar file untuk setip Purchase Order
</div>
<table class="table table-striped table-bordered table-hovered" id="detail">
	<thead class="bg-green">
		<tr>
			<th>PO NAME</th>
			<th class="text-center">STATUS</th>
			<th class="text-center">REVISION STATUS</th>
			<th class="text-center">UPLOAD</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($po->result() as $po){ 
		$file = $this->db->limit(1)->order_by('created_date','DESC')->where('c_order_id',$po->c_order_id)->get('m_po_file');
		$count = $file->num_rows();
	?>
		<tr>
			<td><?=$po->documentno;?></td>
			<td class="text-center">
				<?=($count == 0) ? '<div class="label label-danger">Not Uploaded</div>' : '<div class="label label-success">Uploaded</a>';?>
			</td>
			<td class="text-center">
				<?=($count == 0) ? '-' : '<a href="#" onclick=\'return revisi('.$po->c_order_id.',"'.$po->documentno.'")\'>'.date("d-m-Y H:i:s",strtotime($file->result()[0]->created_date)).'</a>';?>
			</td>
			<td class="text-center">
				<a onclick="return upload_(<?=$po->c_order_id;?>,'<?=$po->documentno;?>',<?=$_GET['id'];?>)" href="#"><i class='fa fa-upload'></i></a>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<script type="text/javascript">
	$(function(){
        $('#detail').DataTable();
	});
</script>