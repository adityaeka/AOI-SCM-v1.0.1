<?php
$this->db2->where('c_bpartner_id',$_GET['id']);
$po = $this->db2->get('f_web_po_header');
$nomor = 1;
?>
<table class="table table-bordered table-hovered" id="detail">
	<thead class="bg-blue">
		<tr>
			<th>PO NAME</th>
			<th>DOC STATUS</th>
			<th class="text-center">STATUS</th>
			<th class="text-center">REVISION STATUS</th>
			<th class="text-center">UPLOAD</th>
			<th class="text-center">SET ETA& ETD</th>
			<th class="text-center">ETA</th>
			<th class="text-center">ETD</th>
			<th class="text-center">SHOW/HIDE</th>
			<th class="text-center">LAST CONFIRMED</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($po->result() as $po){ 
		$file = $this->db->limit(1)->order_by('created_date','DESC')->where('c_order_id',$po->c_order_id)->get('m_po_file_additional');
		$eta=$this->db->where('c_order_id',$po->c_order_id)->get('m_po_eta_etd');
		$count = $file->num_rows();
		$sh = $this->db->where('c_order_id',$po->c_order_id)->where('status','t')->get('show_po_status')->num_rows();

				$this->db->where('c_order_id',$po->c_order_id);
				//$this->db->where('status','t');
		$last =	$this->db->get('show_po_status');

				$this->db2->where('c_order_id',$po->c_order_id);
		$docstatus = $this->db2->get('adt_docstatus_po_header');
		if($sh == 0){
			$sho  = "<a onclick='return show(".$po->c_order_id.",1)' class='btn btn-xs btn-success' href='javascript::void(0)'>UNCONFIRMED</a>";
		}else{
			$sho = "<a onclick='return show(".$po->c_order_id.",2)' class='btn btn-xs btn-default' href='javascript:void(0)'>CONFIRMED</a>";
		}
		$status = $docstatus->result()[0]->docstatus;
		
	?>

		<tr class="<?php
						if($status == "DR"){
							echo ("bg-yellow");
						}else{
							echo("");
						}
					?>">
			<td><?=$po->documentno;?></td>
			<td><?=$status;?></td>
			<td class="text-center">
				<?=($count == 0) ? '<div class="label label-danger">No Additional File</div>' : '<div class="label label-success">Uploaded</a>';?>
			</td>
			<td class="text-center">
				<?=($count == 0) ? '-' : '<a href="javascript:void(0)" onclick=\'return revisi_file('.$po->c_order_id.',"'.$po->documentno.'")\'>'.date("d-m-Y H:i:s",strtotime($file->result()[0]->created_date)).'</a>';?>
			</td>
			<td class="text-center">
				<a onclick="return upload_file(<?=$po->c_order_id;?>,'<?=$po->documentno;?>',<?=$_GET['id'];?>)" href="javascript:void(0)"><i class='fa fa-upload'></i></a>
			</td>
			<td class='text-center'>
				<a onclick="return set_eta(<?=$po->c_order_id;?>,'<?=$po->documentno;?>',<?=$_GET['id'];?>)" href="javascript:void(0)"><i class='fa fa-calendar'></i></a>
			</td>
			<td><?php
					if ($eta->num_rows() > 0) {
						$date = $eta->result()[0]->eta;
					}else{
						$date = '';
					}
					
					echo trim($date);
				?>
			</td>
			<td>
				<?php
					if ($eta->num_rows() > 0) {
						$date = $eta->result()[0]->etd;
					}else{
						$date = '';
					}
					
					echo trim($date);
				?>				
			</td>
			<td class="text-center">
				<?=$sho;?>
			</td>
			<td>
				<?php
				if ($last->num_rows() > 0) {
					$date = $last->result()[0]->created_time;
				}else{
					$date = '';
				}
				
				echo trim($date);
				?>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<div class="set_eta hidden">


<form class="set_eta"  method="POST">
	<label>Set ETA</label>
	<input type="date" name="eta" class="form-control" value="<?=date('Y-m-d');?>">
	<label>Set ETD</label>
	<input type="date" name="etd" class="form-control" value="<?=date('Y-m-d');?>">
	<label></label>
	<button class="btn btn-flat btn-block btn-primary">Simpan</button>
</form>
<script type="text/javascript">
	$(function(){
        $('#detail').DataTable();
	});
	function show(id,st){
		if(st == 1){
			var x = confirm('Apakah anda yakin akan menampilkan Purchase Order ini untuk supplier?');
			var y = '<?=base_url('admin/show_po');?>';
		}else{
			var x = confirm('Apakah anda yakin akan mennyembunyikan Purchase Order dari untuk supplier?');
			var y = '<?=base_url('admin/hide_po');?>';
		}
		if(x == true){
			$.ajax({
				url:y,
				data:'c_order_id='+id,
				type:'POST',
				success:function(data){
					if(data != 0){
						$('.modal-body').load('<?=base_url('admin/po_add_upload?id='.$_GET['id']);?>');
					}else{
						alert('Gagal!');
					}
				}
			})
		}
		return false;
	}
	
	function set_eta(id,name,user_id){
		var modal = $('#myModal_ > div > div');
		$('#myModal_').modal('show');
		modal.children('.modal-header').children('.modal-title').html(name);
		modal.parent('.modal-dialog').addClass('modal-sm');
		modal.children('.modal-body').html('<center>Loading..</center>');
		modal.children('.modal-body').html($('.set_eta').html());
		$('.set_eta').submit(function(){
			var data = new FormData(this);
			$.ajax({
				url:'<?=base_url('admin/set_eta?c_order_id=');?>'+id,
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