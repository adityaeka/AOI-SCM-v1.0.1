<div class="row">
	<div class="col-md-12">
<table class="table table-striped table-bordered table-responsive" id="tables2">
	<thead class="bg-green">
		<tr>
			<th style="width: 20px">#</th>
			<th>PO Number</th>
			<th class="text-center">Release Date</th>
			<th class="text-center">Category</th>
			<th class="text-center">Item</th>
			<th class="text-center">Detail</th>
			<th class="text-center">Purchase Order</th>
			<th class="text-center">Additional File</th>
			<th class="text-center">Orderform</th>
			<th class="text-center">Unconfirm</th>
			<th class="text-center">Remark Confirmation</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$no = 1;
			$dari   = date("Y-m-d 00:00:00",strtotime($_POST['from']));
		    $sampai = date("Y-m-d 23:59:59",strtotime($_POST['until']));
		    $this->db->where('c_bpartner_id', $this->session->userdata('user_id'));
		    $this->db->where('release_date >=',$dari);
		    $this->db->where('release_date <=',$sampai);
		    $this->db->where('status','t');
		    $this->db->order_by('release_date','asc');
		    $a = $this->db->get('adt_activepo');
			foreach ($a->result() as $data) {
				$show = $this->db->where('c_order_id',$data->c_order_id)->where('status','t')->get('show_po_status')->num_rows();
				if($show > 0){
				$file = $this->db->where('c_order_id',$data->c_order_id)->limit(1)->order_by('created_date','DESC')->get('m_po_file');
					if($file->num_rows() == 0){
						$down = '-';
					}else{
						$down = '<a href='.base_url("data/po_download?id=".$data->c_order_id).'>Download</a>';
					}

					$files = $this->db->where('c_order_id',$data->c_order_id)->limit(1)->order_by('created_date','DESC')->get('m_po_file_additional');
					if($files->num_rows() == 0){
						$downs = '-';
					}else{
						$count = $this->db->where('c_bpartner_id',$this->session->userdata('user_id'))->where('read','f')->where('c_order_id',$data->c_order_id)->get('m_po_file_additional')->num_rows();
						$downs = '<a onclick="return unduh('.$data->c_order_id.')" href="javascript:void(0)"><i class="fa fa-download"></i> '.(($count == 0) ? '' : '<span class="label label-danger">'.$count.'</span>').'</a>';
					}
				?>
				<tr>
					<td><?=$no++;?></td>
					<td><?=$data->documentno;?></td>
					<td><?=date("Y-m-d",strtotime($data->release_date));?></td>	
					<td><?=$data->category;?></td>	
					<td class="text-center"><?=$countss=$this->db2->where('c_order_id',$data->c_order_id)->get('f_web_po_detail')->num_rows();?></td>
					<td class="text-center"><a href='<?=base_url('data/po_detail/'.$data->c_order_id);?>'>Detail</a></td>
					<td class="text-center">
						<a href='javascript:void(0)' url='<?=base_url('data/po_view?id='.$data->c_order_id);?>' class='btn btn-xs btn-success view_po'><i class='fa fa-search'></i></a> 
						<a href="<?=base_url('data/doc_po?id='.$data->c_order_id);?>" class='btn btn-primary btn-xs'><i class='fa fa-download'></i></a>
					</td>
					<td class="text-center"><?=$downs;?></td>
					<td class="text-center"><a href="<?=base_url('data/orderform_thread?c_order_id='.$data->c_order_id);?>">Thread</a> - <a href="<?=base_url('data/orderform_zipper?c_order_id='.$data->c_order_id);?>">Zipper</a></td>
					<?php
						$a = $this->db->distinct()->select('c_orderline_id')->where('c_order_id',$data->c_order_id)->where('c_orderline_id >',0)->get('m_date_promised');
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
					<td class="text-center">
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
					</td>			
				</tr>
			<?php }}
		?>
	</tbody>
</table>
	</div>
</div>
<div class="row">
	<div class="col-sm-2">
		 <a href="<?=base_url('data/activepo');?>" class="btn btn-block btn-danger"><i class='fa fa-arrow-left'></i> Back</a> 
	</div>
</div>
<script type="text/javascript">
      $(function(){
        $('#tables2').DataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
        });

        var url = location.href;
          url = url.split('#');
        if(url[1] != undefined && url[1] != ''){
          detail(url[1]);
        }
      });
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