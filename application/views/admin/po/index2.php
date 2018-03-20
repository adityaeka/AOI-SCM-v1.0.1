<style type="text/css">
 .sorting, .sorting_asc, .sorting_desc {
    background : none;
}
.modal-xxl {
     width: 1200px;
    }
</style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> not stable-->
    <script src="http://code.jquery.com/jquery-migrate-1.1.0.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>
<?php
	if(isset($_POST['c_bpartner_id']) && $_POST['c_bpartner_id'] != NULL){
		$this->db2->where('c_bpartner_id',$_POST['c_bpartner_id']);
		$c_bpartner_id = $_POST['c_bpartner_id'];?>
		<div class="row">
<!-- ---------------------------------------Button Download------------------------------------------ -->
			<div class="col-md-4">
				<div class="panel-group">
					<?php
								$c_bpartner_id = $_POST['c_bpartner_id'];
								$this->db->where('user_id',$c_bpartner_id);
								$user = $this->db->get('m_user');
								foreach ($user->result() as $u) {
									
								}
							?>
					  <div class="panel panel-success">
					  	<div class="panel-heading" style="text-align: center;"><strong>PO Confirmation  for <?=$u->nama;?></strong></div>
					    <div class="panel-body">
					    	<div class="container" style="vertical-align: center;">
					    		<a href="<?=base_url('admin/xls_temp_confirm?c_bpartner_id='.$c_bpartner_id);?>" class="btn btn-sm btn-success"><i class='fa fa-download'></i> Download</a>&nbsp&nbsp
					    		<a href="#" class="btn btn-sm btn-danger upload_po_confirm"><i class='fa fa-upload'></i> Upload</a>
					    	</div>
					    </div>
					  </div>
				</div>
			</div>
<!-- ---------------------------------Button Upload--------------------------------------------- -->
			<div class="col-md-4">
				<div class="panel-group">
					  <div class="panel panel-danger">
					  	<div class="panel-heading" style="text-align: center;"><strong> Lock Date Promised for <?=$u->nama;?></strong></div>
					    <div class="panel-body">
					    	<div class="container">
					    		<a href="<?=base_url('admin/xls_temp_date_promised?c_bpartner_id='.$c_bpartner_id);?>" class="btn btn-sm btn-success"><i class='fa fa-download'></i> Download</a>&nbsp&nbsp
					    		<a href="#" class="btn btn-sm btn-danger upload_lock_dp"><i class='fa fa-upload'></i> Upload</a>
					    	</div>
					    </div>
					  </div>
				</div>
			</div>
<!-- ---------------------------------Button Upload--------------------------------------------- -->
			<div class="col-md-4" >
				<div class="panel-group">
					  <div class="panel panel-info">
					  	<div class="panel-heading" style="text-align: center;"><strong> ETA & ETD for <?=$u->nama;?></strong></div>
					    <div class="panel-body">
					    	<div class="container">
					    		<a href="<?=base_url('admin/xls_temp_eta?c_bpartner_id='.$c_bpartner_id);?>" class="btn btn-sm btn-success"><i class='fa fa-download'></i> Download</a>&nbsp&nbsp
					    		<a href="#" class="btn btn-sm btn-danger upload_po_eta"><i class='fa fa-upload'></i> Upload</a>
					    	</div>
					    </div>
					  </div>
				</div>
			</div>
		</div>
<!-- ----------------------------------------------------------------------------------------- -->
		<div class="row">
			<div class="col-sm-4 col-xs-6">
		        <div class="small-box bg-green">
		            <div class="inner">
		              <h3><?=$this->db2->select('count(*)')->where('c_bpartner_id',$c_bpartner_id)->get('f_web_po_header')->result()[0]->count;?></h3>
		              <p>Active PO || <strong><?=$u->nama;?></strong></p>
		            </div>
		            <div class="icon">
		                <i class="fa fa-cart-plus"></i>
		            </div>
		        </div>
		    </div>
<!-- ----------------------------------------------------------------------------------------- -->
    <div class="col-sm-4 col-xs-6">
        <div class="small-box bg-red">
            <div class="inner">
              <h3>
                <?php
						$a = $this->db->where('status','t')->where('c_bpartner_id',$c_bpartner_id)->get('show_po_status');
						foreach($a->result() as $b){
							$c_order[] = $b->c_order_id;
						}
						if(sizeof($c_order) > 0)
							$this->db2->where_not_in('c_order_id',$c_order);

						echo $this->db2->where('c_bpartner_id',$c_bpartner_id)->get('f_web_po_header')->num_rows();
						?>
              </h3>
              <p>Unconfirmed PO || <strong><?=$u->nama;?></strong></p>
            </div>
            <div class="icon">
                <i class="fa fa-check-square-o"></i>
            </div>
        </div>
    </div>
<!-- ----------------------------------------------------------------------------------------- -->
    <div class="col-sm-4 col-xs-6">
        <div class="small-box bg-blue">
            <div class="inner">
              <h3>
              	<?php 
						
						echo $this->db->where('lock','f')->where('c_bpartner_id',$c_bpartner_id)->get('adt_temp_date_promised')->num_rows();

					 ?>
              </h3>
              <p>Unlocked Date Promised || <strong><?=$u->nama;?></strong></p>
            </div>
            <div class="icon">
                <i class="fa fa-calendar-check-o"></i>
            </div>
        </div>
    </div>
		</div>
	<?php }else{
		?>
		<div class="row">
			<div class="col-md-4">
				<div class="alert alert-warning alert-dismissable">
					  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					  <strong>Warning!</strong> Please choose one Supplier!
				</div>
			</div>
		</div>
	<?php }
				$this->db->order_by('nama','asc');
	$supplier = $this->db->get('m_user');
				
?>
<div class="row">
	<div class="col-md-4">
		<form method="POST" action="">
			<label>Supplier</label>
			<!-- <select class="form-control" name="c_bpartner_id"> -->
				<select class="livesearch" name="c_bpartner_id">
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
</div>
<!-- ------------------- Pop up upload Lock Date Promised----------------------------------------- -->
<div class="hidden upload_lock_dp_pop">
	<form enctype="multipart/form-data" method="POST" class="upload_lock_dp_" action='<?=base_url('admin/upload_lock_dp_new');?>' >
		<label>File</label>
		<input type="file" name="file" class="form-control">
		<label></label>
		<button class="btn btn-success btn-flat btn-block">Verify File</button>
	</form>
	<div class="view_">

	</div>
</div>
<!-- ------------------- Pop up upload PO Confirmation----------------------------------------- -->
<div class="hidden upload_po_confirm_pop">
	<form enctype="multipart/form-data" method="POST" class="upload_po_confirm_" action='<?=base_url('admin/upload_po_confirm_new');?>' >
		<label>File</label>
		<input type="file" name="file" class="form-control">
		<label></label>
		<button class="btn btn-success btn-flat btn-block">Verify File</button>
	</form>
	<div class="view_po_confirm_">

	</div>
</div>

<!-- ------------------- Pop up upload ETA ETD----------------------------------------- -->
<div class="hidden upload_po_eta_pop">
	<form enctype="multipart/form-data" method="POST" class="upload_po_eta_" action='<?=base_url('admin/upload_po_eta_new');?>' >
		<label>File</label>
		<input type="file" name="file" class="form-control">
		<label></label>
		<button class="btn btn-success btn-flat btn-block">Verify File</button>
	</form>
	<div class="view_po_eta_">

	</div>
</div>
<!-- ----------------------------------------------------------------------------------------- -->
<div class="upload_form hidden">
<form class="upload_po" enctype="multipart/form-data" method="POST">
	<label>File</label>
	<input type="file" name="po" class="form-control">
	<label></label>
	<button class="btn btn-flat btn-block btn-primary">Upload</button>
</form>
</div>
<!-- ----------------------------------------------------------------------------------------- -->
<script type="text/javascript">
	$(function(){
        $('#tabless').DataTable();
	})
	$(function(){
		$('.upload_lock_dp').click(function(){
			$('.view_').html('');
			var val = $('.upload_lock_dp_pop').html();
			$('#myModal').modal('show');
			$('.modal-dialog').addClass('modal-md');
			$('.modal-title').text('Upload to Lock The Date Promised');
			$('.modal-body').html(val);
			$('.upload_lock_dp_').submit(function(){
				var data = new FormData(this);
				$.ajax({
					url:$(this).attr('action'),
					type: "POST",
					data: data,
					contentType: false,       
					cache: false,          
					processData:false, 
					success: function(response){
						$('.modal-dialog').removeClass('modal-lg');
						$('.view_').html(response);
					}
				})
				return false;
			})
		})
	})
	$(function(){
		$('.upload_po_confirm').click(function(){
			$('.view_po_confirm_').html('');
			var val = $('.upload_po_confirm_pop').html();
			$('#myModal').modal('show');
			$('.modal-dialog').addClass('modal-md');
			$('.modal-title').text('Upload to Confirm the PO');
			$('.modal-body').html(val);
			$('.upload_po_confirm_').submit(function(){
				var data = new FormData(this);
				$.ajax({
					url:$(this).attr('action'),
					type: "POST",
					data: data,
					contentType: false,       
					cache: false,          
					processData:false, 
					success: function(response){
						$('.modal-dialog').removeClass('modal-lg');
						$('.view_po_confirm_').html(response);
					}
				})
				return false;
			})
		})
	})	
	$(function(){
		$('.upload_po_eta').click(function(){
			$('.view_po_eta_').html('');
			var val = $('.upload_po_eta_pop').html();
			$('#myModal').modal('show');
			$('.modal-dialog').addClass('modal-md');
			$('.modal-title').text('Upload the ETA & ETD PO');
			$('.modal-body').html(val);
			$('.upload_po_eta_').submit(function(){
				var data = new FormData(this);
				$.ajax({
					url:$(this).attr('action'),
					type: "POST",
					data: data,
					contentType: false,       
					cache: false,          
					processData:false, 
					success: function(response){
						$('.modal-dialog').removeClass('modal-lg');
						$('.view_po_eta_').html(response);
					}
				})
				return false;
			})
		})
	})	
    $(".livesearch").chosen();
    function upload__(id,name){
		var modal = $('#myModal > div > div');
		$('#myModal').modal('show');
		modal.children('.modal-header').children('.modal-title').html('ADDITIONAL FILE FOR <b>'+name+'</b>');
		modal.parent('.modal-dialog').addClass('modal-lg');
		modal.children('.modal-body').html('<center>Loading..</center>');
		modal.children('.modal-body').load('<?=base_url('admin/po_add_upload_ad?id=');?>'+id);
		return false;
	}
	function upload_file(id,name,user_id){
		var modal = $('#myModal_ > div > div');
		$('#myModal_').modal('show');
		modal.children('.modal-header').children('.modal-title').html(name);
		modal.parent('.modal-dialog').addClass('modal-sm');
		modal.children('.modal-body').html('<center>Loading..</center>');
		modal.children('.modal-body').html($('.upload_form').html());
		$('.upload_po').submit(function(){
			var data = new FormData(this);
			$.ajax({
				url:'<?=base_url('admin/po_upload_file_submit?c_order_id=');?>'+id,
				type: "POST",
				data: data,
				contentType: false,       
				cache: false,          
				processData:false, 
				success: function(response){
					if(response == 1){
						$('#myModal_').modal('hide');
						$('#myModal > div > div').children('.modal-body').html('<center>Loading..</center>').load('<?=base_url('admin/po_add_upload?id=');?>'+user_id);
					}
				}
			})
			return false;
		})
		return false;
	}
</script>