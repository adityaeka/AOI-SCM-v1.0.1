<div class="row">
<div class="col-sm-12">
<table class="table table-striped table-bordered" id="tables">
<thead class="bg-green">
	<tr>
		<th style="width: 20px">#</th>
		<th>PO NUMBER</th>
		<th class="text-center">ITEM CODE</th>
		<th>DATE REQUIRED</th>
		<th>QTY ORDER</th>
		<th>QTY DELIVERED</th>
		<th>FOC</th>
		<th>UoM</th>
	</tr>
</thead>
<tbody>
<?php
$nomor=1;
$user = $this->session->userdata('user_id');
$this->db2->where('c_bpartner_id',$user);
$users = $this->db2->get('adt_status_po_sum_v2_fbc_new');
foreach($users->result() as $po){
?>
	<tr>
		<td><?=$nomor++;?></td>
		<td><?=$po->documentno;?></td>
		<td><?=$po->product?></td>
		<td><?=date('d-m-Y', strtotime($po->datepromised))?></td>
		<td><?=number_format($po->qtyordered, 2)?></td>
		<td><?=$po->qty_upload?></td>
		<td><?=$po->foc?></td>
		<td><?=$po->uomsymbol?></td>
	</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>