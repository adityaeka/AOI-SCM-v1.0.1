<?php
	if(isset($_POST['c_bpartner_id']) && $_POST['c_bpartner_id'] != NULL){
		$this->db2->where('c_bpartner_id',$_POST['c_bpartner_id']);
		$c_bpartner_id = $_POST['c_bpartner_id'];
	}else{
		$c_bpartner_id = '';
	}
	if(isset($_POST['last_confirm_date']) && $_POST['last_confirm_date'] != NULL){
		$this->db2->where('date(last_confirm_date)',$_POST['last_confirm_date']);
		$last_confirm_date = $_POST['last_confirm_date'];
	}else{
		$last_confirm_date = '';
	}

			  $this->db2->order_by('last_confirm_date','desc');
	$report = $this->db2->get('adt_date_promised_detail_report');
				$this->db->order_by('nama','asc');
	$supplier = $this->db->get('m_user');
?>
<div class="row">
	<div class="col-sm-3">
		<form method="POST" action="">
			<label>Date Confirmed</label>
			<input type="date" name="last_confirm_date" class="form-control" value="">
			<label>Supplier</label>
			<select class="form-control" name="c_bpartner_id">
				<option value="">Pilih Nama Supplier</option>
				<?php
					foreach ($supplier->result() as $dt) {
						echo "<option value='".$dt->user_id."'>".$dt->nama."</option>";
					}
				?>
			</select>
			<label></label>
			<button class="btn btn-flat btn-primary btn-block">Search</button>
			<br>
		</form>
	</div>
	<?php
		if(isset($_POST['last_confirm_date']) || isset($_POST['c_bpartner_id'])){
			?>
				<div class="col-sm-9">
					<br>
					<a href="<?=base_url('admin/xls_pilih_confirm_date?last_confirm_date='.$last_confirm_date.'&c_bpartner_id='.$c_bpartner_id);?>" class="btn btn-flat btn-success pull-right"><i class='fa fa-download'></i> DOWNLOAD</a>
				</div>
			<?php
		}
	?>
</div>	



<script type="text/javascript">
      $(function(){
        $('#tablesss').DataTable({
            'paging':true,
            'scrollX':true
        });

        var url = location.href;
          url = url.split('#');
        if(url[1] != undefined && url[1] != ''){
          detail(url[1]);
        }
      });
    </script>