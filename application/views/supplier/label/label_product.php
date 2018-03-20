<html>
<head>
	<title>BARCODE :: PRODUCT</title>
	<script type="text/javascript" src="<?=base_url('assets/barcode.js');?>"></script>
	<style>
	.outer{
		font-family: arial;
		text-transform: uppercase;
		border: 4px solid #000;
		margin-left:0cm;
		margin-right: 0.3cm;
		height:8cm;
		width:10cm;
		border-radius: 0cm;
		margin-bottom: 0.5cm;
		margin-top: 0cm;
		
	}
	.title,
	.creator,
	.company,
	.footer{
		text-align: center;
		padding-top: 6px;
		font-weight: bold;
		font-size: 12px;		
	}	
	.qrcode{
		text-align: left;
		margin-left: 0px;
		width: 25%;
		float: left;
		margin-top: 20px;
		
	}
	.isi{
		height: 6.85cm;
		width: 9.5cm;
		border: 1px solid #000;
		margin-top: 0.3cm;
		margin-left: 0.2cm;
		margin-right: 0.2cm;
		font-weight: bold;
		font-size: 11px;
		position: absolute;
	}
	.isi1{
		height:0.8cm;
		text-align: center;
		border: 1px solid #000;
		font-weight: bold;
		font-size: 15px;
		padding-top: 4px;
		line-height: 0.8cm;
	}
	.isi2{
		text-align: center;
		height:4.9cm;
		width: 40%;
		float: left;
		border: 1px solid #000;
	}
	.isi3{
		height:4.9cm;
		width:58.5%;
		text-align: center;
		float: right;
		border: 1px solid #000;
	}
	.creator{
		padding-top: 5px;
	}
	.block-kiri{
		width: 100%;
		font-weight: bold;
		display: block;
		border-bottom: 1px solid #000;
		height: 24px;
	}
	.block-kiri:last-child{
		border-bottom: 0px solid #000;
	}
	</style>
</head>
<body>
<?php
$this->db->join('po_detail','po_detail.po_detail_id = m_material.po_detail_id');
$this->db->where('m_material.po_detail_id',$po_detail);
$a = $this->db->get('m_material');
foreach($a->result() as $b){
?>
	<div class="outer">
		<div class="title">BARCODE SYSTEM - AOI</div>
		<div class="isi">
			<div class="isi1">
				<?=$b->item;?>
			</div>
			<div class="isi1">
				No Roll : <span style="font-size: 20px;"><?=$b->nomor_roll;?> || <?=number_format($b->qty,3);?></span> <?=$b->uomsymbol;?>
			</div>

			<div class="isi2">
				<div class="block-kiri" style="justify-content: center; height: 45px;">
					<span style="font-size: 10px"><?=$b->desc_product;?></span>
				</div>
				<div class="block-kiri" style="height:35px;line-height: 35px">
					<span style="font-size: 12px"><?=$b->documentno;?></span>
				</div>
				<div class="block-kiri" style="height: 38px;">
					<span style="font-size: 10px"><?=$b->supplier;?></span>
				</div>
				<div class="block-kiri" style="margin-top: 6px">
					<span style="font-size: 16px"></span>
				</div>
				<div class="block-kiri">
					<span style="font-size: 12px"><?=$b->batch_number;?></span>
				</div>
			</div>
			<div class="isi3">
				<div class="block-kiri" style="height: 120px;">
					<svg id="id<?=$b->barcode_id;?>" onload='return barcode("id<?=$b->barcode_id;?>","<?=$b->barcode_id;?>")'></svg>
				</div>
				<div class="block-kiri" style="margin-top: 6px;" >
					Packing List : <?=$b->no_packinglist;?>
				</div>
				<div class="block-kiri" style="margin-top: 6px;">
					<?=($b->datepromised != NULL) ? $b->datepromised : '-'; ?>
				</div>
			</div>
		</div>		
	</div>
<?php } ?>
<script type="text/javascript">
	function barcode(id, val){
		JsBarcode("#"+id, val, {
		  format: "code128",
		  width: 1.5,
	  	  height: 90,
		  displayValue: false
		});
	}
</script>
</body>
</html>