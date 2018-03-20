<?php
	if(isset($_GET['from']) && $_GET['from'] != NULL){
    $dari   = date("Y-m-d 00:00:00",strtotime($_GET['from']));
    $this->db2->where('created_time >=',$dari);
	  }
	  if(isset($_GET['until']) && $_GET['until'] != NULL){
	    $sampai = date("Y-m-d 23:59:59",strtotime($_GET['until']));
	    $this->db2->where('created_time <=',$sampai);
	  }
	$this->db2->where('c_bpartner_id',$_GET['c_bpartner_id']);
	$data_all=$this->db2->get('adt_format_packinglist_v1')->result();
	$tgl = date("Y-m-d");

	header("cache-control:no-cache.must-revalidate");
    header("pragma:no-cache");
    header("Content-type=appalication/x-ms-excel");
    header('Content-Disposition:attachment; filename="Template Upload Packinglist '.date('d-m-Y').'.xls"');
	
?>
<table border="1px">
<thead>
	<tr>
		<th style="background-color: green">C ORDERLINE ID</th>
		<th style="background-color: red">INVOICE NO</th>
		<th style="background-color: green">PO NUMBER</th>
		<th style="background-color: green">ORDER QTY</th>
		<th style="background-color: red">INVOICE QTY</th>
		<th style="background-color: red">PACKING LIST NO</th>
		<th style="background-color: red">DELIVERY DATE</th>
		<th style="background-color: red">ETA</th>
		<th style="background-color: yellow">PSNO</th>
		<th style="background-color: red">SUM QTY CARTON</th>
		<th style="background-color: yellow">ORDER NO</th>
		<th style="background-color: yellow">REMARK</th>
		<th style="background-color: red">AWB/RESI</th>
		<th style="background-color: green">ITEM</th>
		<th style="background-color: green">UOM</th>
		<th style="background-color: red">FOC</th>
		<th style="background-color: yellow">ALREADY IN PACKINGLIST</th>
		<th>Price</th>

	</tr>
</thead>
<tbody>
	<?php foreach($data_all as $data){ ?>
		<tr>
			<td style="background-color: green"><?=$data->c_orderline_id;?></td>
			<td style="background-color: red"></td>
			<td style="background-color: green"><?=$data->documentno;?></td>
			<td style="background-color: green"><?=$data->qtyentered;?></td>
			<td style="background-color: red"></td>
			<td style="background-color: red"></td>
			<td style="mso-number-format:'Short Date';background-color: red;"></td>
			<td style="mso-number-format:'Short Date';background-color: red;"></td>
			<td style="background-color: yellow"></td>
			<td style="background-color: red"></td>
			<td style="background-color: yellow"></td>
			<td style="background-color: yellow"></td>
			<td style="background-color: red; text-align: center;">-</td>
			<td style="background-color: green"><?=$data->item;?></td>
			<td style="background-color: green"><?=$data->uomsymbol;?></td>
			<td style="background-color: red">0</td>
			<td style="background-color: yellow"><?=$data->qty_upload;?></td>
			<td><?=$data->priceentered;?></td>
		</tr>
	<?php } ?>
</tbody>	
</table>