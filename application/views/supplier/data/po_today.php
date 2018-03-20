<div class="row">
	<div class="col-sm-12">
		<a onclick="location.href = '<?=base_url('data/download_excel_po_today?c_bpartner_id='.$this->session->userdata('user_id'));?>';" href='javascript:void(0)' class="btn btn-flat btn-success"><i class='fa fa-excel-o'></i>Download in Excel (Today)</a>
		<table class="table table-striped table-bordered" id="tables">
			<thead class="bg-green">
				<tr>
					<th style="width: 20px">#</th>
					<th>PO Number</th>
					<th class="text-center">Item</th>
					<th class="text-center">Detail</th>
					<th class="text-center">Purchase Order</th>
					<th class="text-center">Download File</th>
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
				$show = $this->db->where('c_order_id',$po->c_order_id)->where('status','t')->where('date(created_time)',date('Y-m-d'))->get('show_po_status')->num_rows();

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
					$downs = '<a onclick="return unduh('.$po->c_order_id.')" href="javascript:void(0)">Download</a>';
				}

				?>
					<tr>
						<td><?=$nomor++;?></td>
						<td><?=$po->documentno;?></td>
						<td class="text-center"><?=$this->db2->where('c_order_id',$po->c_order_id)->get('f_web_po_detail')->num_rows();?></td>
						<td class="text-center"><a href='<?=base_url('data/po_detail/'.$po->c_order_id);?>'>Detail</a></td>
						<td class="text-center">
							<a href='javascript:void(0)' url='<?=base_url('data/po_view?id='.$po->c_order_id);?>' class='btn btn-xs btn-success view_po'><i class='fa fa-search'></i></a> 
							<a href="<?=base_url('data/doc_po?id='.$po->c_order_id);?>" class='btn btn-primary btn-xs'><i class='fa fa-download'></i></a></td>
						<!--td class="text-center"><?=$down;?></td-->
						<td class="text-center"><?=$downs;?></td>
					</tr>
				<?php } } ?>
			</tbody>
		</table>
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
</script>