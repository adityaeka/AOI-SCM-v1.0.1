<!DOCTYPE html>
<html>
<head>
	<title>PACKING LIST</title>
	<style type="text/css">
		.outer{
			font-family: arial;
			margin-left:0.5cm;
			margin-right: 0.5cm;
			height:28cm;
			width:20cm;
			border-radius: 0cm;
			margin-bottom: 0.5cm;
			margin-top: 0cm;
			border: 1px solid #000;
		}
		.header{
			width: 20cm;
			height: 2.5cm;
			
			border: 1px solid #000;
			text-align: center;
		}
		.header-kiri{
			width: 9.9cm;
			float: left;
			text-align: left;
			font-size: 12px;	
			line-height: 0.6cm;
		}
		.header-kanan{
			width: 9.9cm;
			float: right;
			font-size: 12px;	
			line-height: 0.6cm;
		}
		.create{
			width: 20cm;
			height: 0.6cm;
			border-bottom: 1px solid #000;
			text-align: right;
		}

		.tables{
			width: 100%;
			font-size: 12px;
		}
		.isi{
			margin-top: 20px;
			width: 20cm;
		}

	</style>
</head>
<body onload="window.print()">
	<?php 
		$no_packinglist = $_GET['no_packinglist'];
		$kst_invoicevendor = $_GET['invoice'];
		$this->db->where('kst_invoicevendor',$kst_invoicevendor);
		$this->db->where('no_packinglist',$no_packinglist);
		$data = $this->db->get('packinglist_header');
		foreach($data->result() as $pols){
	?>
	<div class="outer">
		<div class="create">
			<span style="font-size: 12px; padding-right: 10px;" >Created On: <?=$pols->date;?></span>
		</div>
		<div class="header">
			<span style="font-size: 32px; margin-top: 30px;">PACKING LIST</span><br><br>
			<span style="font-size: 18px"><?=$pols->supplier;?></span>
		</div>
		<div class="create">
			<div class="header-kiri">
				<span style="padding-left: 10px">Packing List no : <?=$pols->no_packinglist;?></span> 
			</div>
			<div class="header-kanan">
				<span style="padding-right: 10px">Invoice no : <?=$pols->kst_invoicevendor;?></span> 
			</div>
		</div>
		<div class="isi">
			<table border="1px" class="tables">
				<thead>
					<tr>
						<th>PURCHASE ORDER</th>
						<th>ITEM CODE</th>
						<th>PRODUCT</th>
						<th>QUANTITY</th>
						<th>FOC</th>
						<th>UOM</th>
						<?php if ($pols->type_po =='1') {
								echo "<th>ROLL</th>";
							}
							else{
								echo "<th>CARTON</th>";
							}
							;?>
					</tr>
				</thead>
				<tbody>
					<?php
						$this->db->order_by('documentno'); 
						$this->db->where('isactive','TRUE');
						$detail = $this->db->where('no_packinglist',$no_packinglist)->get('po_detail');
						foreach($detail->result() as $pol){
					?>
					<tr>
						<td><?=$pol->documentno?></td>
						<td><?=$pol->item?></td>
						<td><?=$pol->desc_product;?></td>
						<td><?=$pol->qty_upload;?></td>
						<td><?=$pol->foc;?></td>
						<td><?=$pol->uomsymbol;?></td>
						<td><?=$pol->qty_carton;?></td>
					</tr>
					<?php
						}
					?>
				</tbody>
			</table>

		</div>
	</div>

	<?php
		}
	?>
</body>
</html>