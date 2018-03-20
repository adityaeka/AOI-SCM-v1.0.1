<!DOCTYPE html>
<html>
<head>
	<title>EDIT DATA</title>
	<link rel="stylesheet" type="text/css" href="http://po.aoi.co.id/assets/bootstrap/css/bootstrap-datepicker.min.css">
    <script type="text/javascript" src="http://po.aoi.co.id/assets/bootstrap/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
      $(function(){
          $('#datepicker').datepicker({
              format: "yyyy-mm-dd"
          });
      })
    </script>
    <script type="text/javascript">
      $(function(){
          $('#datepicker2').datepicker({
              format: "yyyy-mm-dd"
          });
      })
    </script>
</head>
<body>
	<form method="POST" action="<?=base_url('/data/edit_header_submit');?>" class="form_daily_data">
		<input type="hidden" name="before[no_packinglist]" value="<?=$_GET['no_packinglist'];?>">			
		<input type="hidden" name="before[kst_invoicevendor]" value="<?=$_GET['kst_invoicevendor'];?>">	
		<input type="hidden" class="form-control" name="after[is_edited]" value="t">
		<label>Packing List Number</label>
		<input type="text" value="<?=$_GET['no_packinglist'];?>" class='form-control' disabled>
		<!--label>Surat Jalan or DN</label-->
		<label>Invoice (INV)</label>
		<input type="text" class="form-control" name="after[kst_invoicevendor]" value="<?=$_GET['kst_invoicevendor'];?>" required>
		<!--label>Resi Number (AWB)</label-->
		<label>Ex Factory Date</label>
		<input type="text" id="datepicker" name="after[kst_etddate]" class="form-control" required>
		<label>Estimated Time Arrival (ETA)</label>
		<input type="text" id="datepicker2" name="after[kst_etadate]" class="form-control" required>
		<label></label>
		<button class="btn btn-block btn-primary btn-flat"> Submit</button>
	</form>	
</body>
</html>


