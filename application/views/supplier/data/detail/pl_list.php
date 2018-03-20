<div class="row">
	<div class="col-sm-12">
		<table class="table table-striped table-bordered" id="tables">
			<thead>
				<tr class="bg-green">
				<th class="text-center">#</th>
				<th>PL NUMBER</th>
				<!--th>SJ / DN </th-->
				<th>INVOICE</th>
				<!--th>RESI / AWB</th-->
				<th class="text-center">QC-CHECK REPORT</th>
				<th class="text-center">QC REPORT</th>
				<th class="text-center">DETAIL</th>
				<th class="text-center">ACTION</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$nomor=1;
					$pl='';
					$this->db->distinct();
					$this->db->select('po_detail.no_packinglist, po_detail.kst_suratjalanvendor, po_detail.kst_invoicevendor, po_detail.kst_resi, type_po, is_locked');
					//$this->db->join('packing_list_qc','po_detail.no_packinglist = packing_list_qc.no_packinglist','left');
					$this->db->where('c_bpartner_id',$this->session->userdata('user_id'));
					$this->db->where('isactive =', 't');
					$a=$this->db->get('po_detail');
					foreach($a->result() as $b){
					?>
						<tr>
						<td class="text-center"><?=$nomor++;?></td>
						<td><a target="_blank" href='<?=base_url('data/print_pl?no_packinglist='.$b->no_packinglist.'&invoice='.$b->kst_invoicevendor);?>'><?=$b->no_packinglist;?></a></td>
						<td><?=$b->kst_invoicevendor;?></td>
						<?php
						$this->db->where('kst_resi',$b->kst_resi);
						$this->db->where('kst_invoicevendor',$b->kst_invoicevendor);
						$this->db->where('kst_suratjalanvendor',$b->kst_suratjalanvendor);
						$this->db->where('no_packinglist',$b->no_packinglist);
						$z=$this->db->get('packing_list_qc');
						$y=$z->num_rows();
						?>
						<td class="text-center">
							<?php 
								if($y > 0){
									echo "Already Uploaded";
								}else{
									echo "<center>
										<form method='POST' class='".$b->no_packinglist."' action='".base_url('data/up_pl_qc')."' enctype='multipart/form-data'>
											<input type='file' class='files' name='file' id='".$b->no_packinglist."'>
											<input type='hidden' name='no_packinglist' value='".$b->no_packinglist."'>
											<input type='hidden' name='kst_suratjalanvendor' value='".$b->kst_suratjalanvendor."'>
											<input type='hidden' name='kst_invoicevendor' value='".$b->kst_invoicevendor."'>
											<input type='hidden' name='kst_resi' value='".$b->kst_resi."'>
										</form></center>";
								}
							?>
						</td>
						<td class="text-center">
							<?php
								echo ($y > 0) ? "<a href='".base_url('data/download_qc_check/?token='.$this->session->userdata('session_id').'&no_packinglist='.trim($b->no_packinglist)."&kst_suratjalanvendor=".$b->kst_suratjalanvendor."&kst_resi=".$b->kst_resi."&kst_invoicevendor=".$b->kst_invoicevendor)."' ><i class='fa fa-download'></i></a>" : "";
							?>
						</td>
						<td class="text-center">
							<a class='link' data='pl=<?=$b->no_packinglist;?>&sj=<?=$b->kst_suratjalanvendor;?>&inv=<?=$b->kst_invoicevendor;?>&awb=<?=$b->kst_resi;?>' href='<?=base_url('data/pl_detail');?>'>Detail</a>
						</td>
						<td class="text-center">
							<?php
								if($b->is_locked == 't'){
									if($b->type_po == 1){
									echo "<a title='Print Barcode' target='_Blank' style='margin-right:10px' href='".base_url('label/label_fb_new/'.$b->no_packinglist).'/'.$b->kst_suratjalanvendor.'/'.$b->kst_invoicevendor.'/'.$b->kst_resi."'><i class='fa fa-qrcode'></i></a>";
									}
									else{
										$smli = 1001128;
										$sml = 1001950;
										if($this->session->userdata('user_id') == $smli || $this->session->userdata('user_id') == $sml){
										echo "<a title='Print Barcode' target='_Blank' style='margin-right:10px' href='".base_url('label/sml?nopl='.$b->no_packinglist).'&sj='.$b->kst_suratjalanvendor.'&inv='.$b->kst_invoicevendor.'&awb='.$b->kst_resi."'><i class='fa fa-qrcode'></i></a>";
											
										}else{
										echo "<a title='Print Barcode' target='_Blank' style='margin-right:10px' href='".base_url('label/acc?nopl='.$b->no_packinglist).'&sj='.$b->kst_suratjalanvendor.'&inv='.$b->kst_invoicevendor.'&awb='.$b->kst_resi."'><i class='fa fa-qrcode'></i></a>";
											
										}

									}	
								}else{
									echo "<a title='Print Barcode' style='margin-right:10px' onclick='return confirm(\"Please confirm packing list first\")' href='#'><i class='fa fa-qrcode'></i></a>";
								}
							?>

						<!--/td>
						<td class="text-center"-->
						<?php
							if($b->is_locked == 'f'){
								?>
								<a title="Edit Header" style='margin-right:10px' href='<?=base_url('data/edit_header/?token='.$this->session->userdata('session_id').'&no_packinglist='.trim($b->no_packinglist)."&kst_invoicevendor=".$b->kst_invoicevendor);?>' class="edit_header"><i class='fa fa-edit'></i></a>
								<?php						
							}
						?>

						<!--/td>
						<td class="text-center"-->
							<a title="Delete Header" style='margin-right:10px' onclick="return confirm('Do you want to delete this Packing List?')" href='<?=base_url('data/isactive?token='.$this->session->userdata('session_id').'&no_packinglist='.trim($b->no_packinglist)."&kst_invoicevendor=".$b->kst_invoicevendor);?>'><i class='fa fa-trash'></i></a>
						<!--/td>
						<td class="text-center"-->
						<?php
							if($b->is_locked == 'f'){
								echo "<a onclick='return confirm(\"Do you want to Lock this Packing List?\")' href='".base_url('data/lock?&no_packinglist='.trim($b->no_packinglist).'&kst_invoicevendor='.($b->kst_invoicevendor))."'><i class='fa fa-unlock'></i></a>";
							}else{
								echo "<a onclick='return alert(\"Packing List has been locked.\")'><i class='fa fa-lock'></i></a>";
							}
						?>						
						</td>
						</tr>
						<?php
					}
				?>
			</tbody>
		</table>
	</div>
	<div class="col-sm-12 view">

	</div>
</div>
<script type="text/javascript">
	$(function(){
		$('.link').click(function(){
			$.ajax({
				url:$(this).attr('href'),
				data:$(this).attr('data'),
				type:"POST",
				success:function(data){
					var modal = $('#myModal > div > div');
					$('#myModal').modal('show');
					modal.children('.modal-header').children('.modal-title').html('EDIT DATA');
					modal.parent('.modal-dialog').addClass('modal-lg');
					modal.children('.modal-body').html(data);
				}
			})
			return false;
		});
		$('.files').change(function(){
			var x = confirm('Do you really want to upload a file?');
			if(x==true)
				$('.'+$(this).attr('id')).submit();
			else
				return false;
		})
	})
    $(function(){
        $('.edit_header').click(function(){
			var url = $(this).attr('href');
			$.ajax({
				url:url,
				success:function(data){
					$('#myModal').modal('show');
					$('.modal-dialog').removeClass('modal-lg');
					$('.modal-title').html('EDIT DATA');
					$('.modal-body').html(data);
				}
			})
			return false;
		});
    })
</script>



