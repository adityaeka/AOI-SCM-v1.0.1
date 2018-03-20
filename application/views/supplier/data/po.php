<div class="row">
<div class="col-sm-12">
<a onclick="location.href = '<?=base_url('data/download_excel_po?c_bpartner_id='.$this->session->userdata('user_id'));?>';" href='javascript:void(0)' class="btn btn-flat btn-success"><i class='fa fa-excel-o'></i>Download in Excel</a>

<!-- <a onclick="location.href = '<?=base_url('data/download_excel_po?c_bpartner_id='.$this->session->userdata('user_id'));?>';" href='javascript:void(0)' class="flash-button"><i class='fa fa-excel-o'></i>Upload Date Promised</a>
 -->	
 	<!-- <?php if($this->session->userdata('user_id') == 1001808){ ?>
		<a href="#" class="btn btn-warning btn-flat upload_dp"><i class='fa fa-upload'></i> Upload Date Promised</a>
	<?php } ?> -->

	<a href="#" class="btn btn-warning btn-flat upload_dp"><i class='fa fa-upload'></i> Upload Date Promised</a>
		
		

<table class="table table-striped table-bordered" id="tables">
<thead class="bg-green">
	<tr>
		<!-- <th style="width: 20px">#</th> -->
		<th>PO Number</th>
		<th class="text-center">Category</th>
		<th class="text-center">Item</th>
		<th class="text-center">Detail</th>
		<th class="text-center">Purchase Order</th>
		<th class="text-center">Supplier PI</th>
		<th class="text-center">AOI PI</th>
		<th class="text-center">Additional File</th>
		<th class="text-center">Orderform</th>
		<th class="text-center">Unconfirm</th>
		<!-- <th class="text-center">Remark Confirmation</th> -->
		<th class="text-center">Date Created PO</th>
	</tr>
</thead>
<tbody>
<?php
$nomor=1;
$user = $this->session->userdata('user_id');
$this->db2->where('c_bpartner_id',$user);
$users = $this->db2->get('f_web_po_header');
foreach($users->result() as $po){
//cek di show table
$show = $this->db->where('c_order_id',$po->c_order_id)->where('status','t')->get('show_po_status')->num_rows();

if($show > 0){
$file = $this->db->where('c_order_id',$po->c_order_id)->limit(1)->order_by('created_date','DESC')->get('m_po_file');
if($file->num_rows() == 0){
	$down = '-';
}else{
	$down = '<a href='.base_url("data/po_download?id=".$po->c_order_id).'>Download</a>';
}

$files = $this->db->where('c_order_id',$po->c_order_id)->limit(1)->order_by('created_date','DESC')->get('m_po_file_additional');
if($files->num_rows() == 0){
	$downs = '-';
}else{
	$count = $this->db->where('c_bpartner_id',$this->session->userdata('user_id'))->where('read','f')->where('c_order_id',$po->c_order_id)->get('m_po_file_additional')->num_rows();
	$downs = '<a onclick="return unduh('.$po->c_order_id.')" href="javascript:void(0)"><i class="fa fa-download"></i> '.(($count == 0) ? '' : '<span class="label label-danger">'.$count.'</span>').'</a>';
}

?>
	<tr>
		<!-- <td><?=$nomor++;?></td> -->
		<td><?=$po->documentno;?></td>
		<td class="text-center"><?=$po->category;?></td>
		<td class="text-center"><?=$countss=$this->db2->where('c_order_id',$po->c_order_id)->get('f_web_po_detail')->num_rows();?></td>
		<td class="text-center"><a href='<?=base_url('data/po_detail/'.$po->c_order_id);?>'>Detail</a></td>
		<td class="text-center">
			<a href='javascript:void(0)' url='<?=base_url('data/po_view?id='.$po->c_order_id);?>' class='btn btn-xs btn-success view_po'><i class='fa fa-search'></i></a> 
			<a href="<?=base_url('data/doc_po?id='.$po->c_order_id);?>" class='btn btn-primary btn-xs'><i class='fa fa-download'></i></a></td>

		<td class="text-center"><a href='javascript:void(0)' url='<?=base_url('data/po_view?id='.$po->c_order_id);?>' class='btn btn-xs btn-danger view_po'><i class='fa fa-upload'></i></a> 
			<a href="<?=base_url('data/doc_po?id='.$po->c_order_id);?>" class='btn btn-primary btn-xs'><i class='fa fa-download'></i></a></td>

		<td class="text-center"><a href='javascript:void(0)' url='<?=base_url('data/po_view?id='.$po->c_order_id);?>' class='btn btn-xs btn-danger view_po'><i class='fa fa-upload'></i></a> 
			<a href="<?=base_url('data/doc_po?id='.$po->c_order_id);?>" class='btn btn-primary btn-xs'><i class='fa fa-download'></i></a></td>

		<td class="text-center"><?=$downs;?></td>
		<td class="text-center"><a href="<?=base_url('data/orderform_thread?c_order_id='.$po->c_order_id);?>">Thread</a> - <a href="<?=base_url('data/orderform_zipper?c_order_id='.$po->c_order_id);?>">Zipper</a></td>
		<?php
			$a = $this->db->distinct()->select('c_orderline_id')->where('c_order_id',$po->c_order_id)->where('c_orderline_id >',0)->get('m_date_promised');
			$warna = $countss-$a->num_rows();
			if ($warna == $countss) {
				$warna2 = 'bg-red';
			}
			if ($warna != $countss) {
				if ($warna == 0) {
					$warna2 = 'bg-green';
				}else{
					$warna2 = 'bg-yellow';
				}
			}

		?>
		<td class="text-center <?php echo $warna2;?>">
			<?php
			echo $countss-$a->num_rows();
			
			?>
		</td>
		
		<!-- <td class="text-center">
			<?php
				if ($warna2 == 'bg-red') {
					echo "Nothing Confirmed";
				}
				if ($warna2 == 'bg-green') {
					echo "Already Confirmed";
				}
				if ($warna2 == 'bg-yellow'){
					echo "Partially Confirmed";
				}
			?>
		</td> -->
		<td class="text-center"><?= date('Y-m-d', strtotime($po->create_po));?></td>
	</tr>
<?php } } ?>
</tbody>
</table>
</div>
</div>
<div class="hidden upload_dp_pop">
	<form enctype="multipart/form-data" method="POST" class="upload_dp_" action='<?=base_url('data/upload_dp_new');?>' >
		<label>File</label>
		<input type="file" name="file" class="form-control">
		<label></label>
		<button class="btn btn-success btn-flat btn-block">Verify File</button>
	</form>
	<div class="view_">

	</div>
</div>
<script type="text/javascript">
	$(function(){
		$('.view_po').click(function(){
			$('#myModal').modal('show');
			$('.modal-title').text('Preview Purchase Order');
			$('.modal-dialog').addClass('modal-lg');
			$('.modal-body').load($(this).attr('url'));
			return false;
		});
	});
	function unduh(id){
		$('#myModal').modal('show');
		$('.modal-title').text('All file attachment');
		$('.modal-dialog').removeClass('modal-lg');
		$('.modal-body').load('<?=base_url('data/list_file?id=');?>'+id);
		return false;
	}
	$(function(){
		$('.upload_dp').click(function(){
			$('.view_').html('');
			var val = $('.upload_dp_pop').html();
			$('#myModal').modal('show');
			$('.modal-dialog').addClass('modal-lg');
			$('.modal-title').text('Upload Date Promised');
			$('.modal-body').html(val);
			$('.upload_dp_').submit(function(){
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
</script>