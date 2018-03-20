<style type="text/css">
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0; 
}
	input[type=text],
	input[type=number]{
		border: 0px;
		background: inherit;
		margin: 0px;
		width: 100%;
		height: 100%;
		text-align: center;
		border: 0px solid #000;
	}
	input[type=text]:focus,
	input[type=number]:focus{
		background: #FFF;
		color: #000;
	}
	input[type=text]{
		text-align: left;
	}
	td,th{
		white-space: nowrap;
	}
</style>
<div class="row">
	<div class="col-xs-12">
		<a href="<?=base_url('data/po');?>" class="btn btn-flat btn-danger"> <i class="fa fa-arrow-left"></i> Back</a><br><br>
		<div class="table-responsives"  style='min-height: 100%'>
			<table class="table table-striped table-bordered small">
				<thead class="bg-green">
					<tr>
						<th>#</th>
						<th>PURCHASE ORDER</th>
						<th>CAT</th>
						<th>ITEM CODE</th>
						<th>PRODUCT</th>
						<th>REQUEST ARRIVAL DATE</th>
						<th>ETD AOI</th>
						<th>ETA AOI</th>
						<th>DATE PROMISED</th>
						<th>QTY ORDERED</th>
						<th class="text-right">QTY DELIVERED</th>
						<th class="text-center">FOC</th>
						<th class="text-center">UOM</th>
						<th>PL NUM</th>
						<!--th>SJ / DN</th-->
						<th>INV</th>
						<!--th>AWB</th-->
						<!--th class="text-center">REMARK</th-->
					</tr>
				</thead>
				<tbody>
					<?php
						$nomor=1;
						foreach($data as $a => $po){
							$lokal = $this->db->where('c_orderline_id',$po->c_orderline_id)->get('po_detail');

							if($lokal->num_rows() == 0){
								$dp = $this->db->limit(1)->order_by('created_date','DESC')->where('c_orderline_id',$po->c_orderline_id)->get('m_date_promised');
								if($dp->num_rows() == 0){
									$dpr = 'Date Promised';
									$iclass = '';
									$link = 'set_dp';
								}else{
									$dpr = $dp->result()[0]->date_promised;

									if ($dp->result()[0]->lock == 't'){
										$iclass = 'fa fa-lock';
										$link = '';
									}
									else{
										$iclass = 'fa fa-unlock';
										$link = 'set_dp';
									}
								}
							?>
						<tr>
							<td><?=$nomor++;?></td>
							<td><?=$po->documentno;?></td>
							<td><?=$po->category;?></td>
							<td><?=$po->item;?></td>
							<td><?=$po->desc_product;?></td>
							<td><?=($po->datepromised == NULL) ? '-' : date('Y-m-d',strtotime($po->datepromised));?></td>
							<td>
                                <?php
                                    
                                    $x = $po->c_order_id;
                                    $a = $this->db->select('etd')->where('c_order_id',$x)->get('m_po_eta_etd')->result();
                                    foreach($a as $b){
                                        echo $b->etd;
                                    }
                                    
                                ?>
                            </td>
                                 <td>
                                <?php
                                    
                                    $x = $po->c_order_id;
                                    $a = $this->db->select('eta')->where('c_order_id',$x)->get('m_po_eta_etd')->result();
                                    foreach($a as $b){
                                        echo $b->eta;
                                    }
                                    
                                ?>
                            </td>
							<td class="text-center">
								<i class='<?=$iclass?>'></i>
								<a href="#" class="<?=$link?>" id="<?=$po->c_orderline_id;?>"><?=$dpr;?></a>
							</td>
							<td><?=number_format($po->qtyentered,2);?></td>
							<td></td>
							<td class="text-center"><input type="number" name="foc" value="" class="foc" id="<?=$po->c_orderline_id;?>" disabled></td>
							<td class="text-center"><?=$po->uomsymbol;?></td>
							<td></td>
							<td></td>

							<!--td><input id="<?=$po->c_orderline_id;?>" type="text" name="no_packinglist" class="no_packinglist"></td>
							<td><input id="<?=$po->c_orderline_id;?>" type="text" name="kst_suratjalanvendor" class="kst_suratjalanvendor"></td>
							<td><input id="<?=$po->c_orderline_id;?>" type="text" name="kst_invoicevendor" class="kst_invoicevendor"></td>
							<td><input id="<?=$po->c_orderline_id;?>" type="text" name="kst_resi" class="kst_resi"></td>
							<td class="text-center">
								
							</td-->
						</tr>
					<?php
						}else{
							foreach($lokal->result() as $pol){
								$dp = $this->db->limit(1)->order_by('created_date','DESC')->where('c_orderline_id',$pol->c_orderline_id)->get('m_date_promised');
								if($dp->num_rows() == 0){
									$dpr = 'Date Promised';
									$iclass = '';
									$link = 'set_dp';
								}else{
									$dpr = $dp->result()[0]->date_promised;
									if ($dp->result()[0]->lock == 't'){
										$iclass = 'fa fa-lock';
										$link = '';
									}
									else{
										$iclass = 'fa fa-unlock';
										$link = 'set_dp';
									}
								}
					?>
						<tr class="bg-yellow">
							<td><?=$nomor++;?></td>
							<td><?=$pol->documentno;?></td>
							<td><?=$pol->category;?></td>
							<td><?=$pol->item;?></td>
							<td><?=$pol->desc_product;?></td>
							<td><?=($pol->datepromised == NULL) ? '-' : date('Y-m-d',strtotime($pol->datepromised));?></td>
							<td>
                                <?php
                                    
                                    $x = $po->c_order_id;
                                    $a = $this->db->select('etd')->where('c_order_id',$x)->get('m_po_eta_etd')->result();
                                    foreach($a as $b){
                                        echo $b->etd;
                                    }
                                    
                                ?>
                            </td>
                                 <td>
                                <?php
                                    
                                    $x = $po->c_order_id;
                                    $a = $this->db->select('eta')->where('c_order_id',$x)->get('m_po_eta_etd')->result();
                                    foreach($a as $b){
                                        echo $b->eta;
                                    }
                                    
                                ?>
                            </td>	
							<td class="text-center">
								<i class='<?=$iclass?>'></i>
								<a href="#" class="<?=$link?>" id="<?=$po->c_orderline_id;?>"><?=$dpr;?></a>
							</td>
							<td><?=number_format($pol->qtyentered,2);?></td>
							<td>
								<?php
									$a = $this->db->select_sum('qty')->where('po_detail_id',$pol->po_detail_id)->get('m_material')->result();
									foreach($a as $b){
										echo number_format($b->qty,3);
									}
								?>
							</td>
							<td class="text-center"><input type="number" name="foc" class="foc_" id="<?=$pol->po_detail_id;?>" value='<?=$pol->foc;?>'></td>
							<td class="text-center"><?=$pol->uomsymbol;?></td>
							<td><?=$pol->no_packinglist;?></td>
							<!--td><?=$pol->kst_suratjalanvendor;?></td-->
							<td><?=$pol->kst_invoicevendor;?></td>
							<!--td><?=$pol->kst_resi;?></td-->
							<!--td><input id="<?=$pol->po_detail_id;?>" type="text" name="no_packinglist" class="no_packinglist_" value='<?=$pol->no_packinglist;?>'></td>
							<td><input id="<?=$pol->po_detail_id;?>" type="text" name="kst_suratjalanvendor" class="kst_suratjalanvendor_" value='<?=$pol->kst_suratjalanvendor;?>'></td>
							<td><input id="<?=$pol->po_detail_id;?>" type="text" name="kst_invoicevendor" class="kst_invoicevendor_" value='<?=$pol->kst_invoicevendor;?>'></td>
							<td><input id="<?=$pol->po_detail_id;?>" type="text" name="kst_resi" class="kst_resi_" value='<?=$pol->kst_resi;?>'></td>
							<td class="text-center">
								<div class="btn-group btn-group-xs">
						                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						                  <span class="caret"></span>
						                </button>
						                <ul class="dropdown-menu" style="margin-left: -100px">
						                <?php if($pol->no_packinglist != NULL){ ?>
						                	<li><a href='#' class="popup" data='<?=$pol->po_detail_id;?>' c_order='<?=$pol->c_order_id;?>' title="Upload Packing List">Upload PL</a></li>
						                	<?php if($pol->master == 1){ ?>
						                	<li><a href='<?=base_url('data/add_pl/'.$pol->po_detail_id);?>' title="Create new partial packing list">Add Partial PL</a></li>
						                	<?php } ?>
						                	<li><a class="" data='<?=$pol->po_detail_id;?>' href='<?=base_url('label/label_fabric/'.$pol->po_detail_id);?>' title="Create Label">Creater Label</a></li>
						                <?php } ?>
						                	<li><a class="detail" href="<?=base_url('data/detail/'.$pol->po_detail_id);?>" title="Detail Material">Detail</a></li>
						                </ul>
						              </div>
								</div>
							</td-->
						</tr>
						<?php
					}
				}
			}
		?>
		</tbody>
		</table>
		</div>
		<div class="alert alert-info">
			<b>Information!</b><br>
			<ol>
				<li>Before upload packing list, please insert:
					<ul><i>- Packing List Number (PL NUM)</i></ul>
					<ul><i>- Invoice (INV)</i></ul>
				</li>
			</ol>
		</div>
	</div>
</div>
<div class="pop_up hidden">
	<form action="create_dp_po" method="POST">
		<label>Date Promised</label>
		<input type="date" name="date_promised" class="form-control dp" value="<?=date('Y-m-d');?>">
		<label></label>
		<button class="btn btn-primary btn-flat btn-block save_dp">Save</button>
	</form>
</div>
<script type="text/javascript">
	$(function(){
		$('.popup').click(function(){
			$('#myModal').modal('show');
			$('.modal-dialog').addClass('modal-sm');
			if($(this).hasClass('inp-foc') == true){
				$('.modal-title').html('Input FOC');
				$('.modal-body').load('<?=base_url('data/form_foc');?>/'+$(this).attr('data'));
			}else if($(this).hasClass('inp-qty')){
				$('.modal-title').html('Input QTY');
				$('.modal-body').load('<?=base_url('data/form_qty');?>/'+$(this).attr('data'));
			}else{
				$('.modal-title').html('Upload Packing List');
				$('.modal-body').load('<?=base_url('data/form_upload');?>/'+$(this).attr('data')+'/'+$(this).attr('c_order'));
			}

			$('.modal-footer').remove();
			return false;
		});
		$('.detail').click(function(){
			$('#myModal').modal('show');
			$('.modal-dialog').removeClass('modal-sm');
			$('.modal-title').html('Detail Material');
			$('.modal-body').load($(this).attr('href'));
			return false;
		});
		$('.qty_upload').blur(function(){
			var val = $(this).val();
			$.ajax({
				url:'<?=base_url('data/input_qty');?>' + '/' + $(this).attr('id'),
				data:'qty=' + val,
				type:'POST',
				success:function(data){

				}
			})
		});
		$('.foc').blur(function(){
			var val = $(this).val();
			$.ajax({
				url:'<?=base_url('data/input_foc');?>' + '/' + $(this).attr('id'),
				data:'foc=' + val,
				type:'POST',
				success:function(data){

				}
			})
		});
		$('.foc_').blur(function(){
			var val = $(this).val();
			$.ajax({
				url:'<?=base_url('data/input_foc_');?>' + '/' + $(this).attr('id'),
				data:'foc=' + val,
				type:'POST',
				success:function(data){

				}
			})
		});
		$('.no_packinglist').blur(function(){
			var val = $(this).val();
			$.ajax({
				url:'<?=base_url('data/input_nopl');?>' + '/' + $(this).attr('id'),
				data:'nopl=' + val,
				type:'POST',
				success:function(data){
				location.href = location.href;
				//alert(data);
				}
			})
		});
		$('.no_packinglist_').blur(function(){
			var val = $(this).val();
			$.ajax({
				url:'<?=base_url('data/input_nopl_');?>' + '/' + $(this).attr('id'),
				data:'nopl=' + val,
				type:'POST',
				success:function(data){
					location.href = location.href;
				}
			})
		});
		$('.kst_suratjalanvendor').blur(function(){
			var val = $(this).val();
			$.ajax({
				url:'<?=base_url('data/input_sj');?>' + '/' + $(this).attr('id'),
				data:'sj=' + val,
				type:'POST',
				success:function(data){
				location.href = location.href;
				//alert(data);
				}
			})
		});
		$('.kst_suratjalanvendor_').blur(function(){
			var val = $(this).val();
			$.ajax({
				url:'<?=base_url('data/input_sj_');?>' + '/' + $(this).attr('id'),
				data:'sj=' + val,
				type:'POST',
				success:function(data){
					location.href = location.href;
				}
			})
		});
		$('.kst_invoicevendor').blur(function(){
			var val = $(this).val();
			$.ajax({
				url:'<?=base_url('data/input_inv');?>' + '/' + $(this).attr('id'),
				data:'inv=' + val,
				type:'POST',
				success:function(data){
				location.href = location.href;
				//alert(data);
				}
			})
		});
		$('.kst_invoicevendor_').blur(function(){
			var val = $(this).val();
			$.ajax({
				url:'<?=base_url('data/input_inv_');?>' + '/' + $(this).attr('id'),
				data:'inv=' + val,
				type:'POST',
				success:function(data){
					location.href = location.href;
				}
			})
		});
		$('.kst_resi').blur(function(){
			var val = $(this).val();
			$.ajax({
				url:'<?=base_url('data/input_resi');?>' + '/' + $(this).attr('id'),
				data:'resi=' + val,
				type:'POST',
				success:function(data){
				location.href = location.href;
				//alert(data);
				}
			})
		});
		$('.kst_resi_').blur(function(){
			var val = $(this).val();
			$.ajax({
				url:'<?=base_url('data/input_resi_');?>' + '/' + $(this).attr('id'),
				data:'resi=' + val,
				type:'POST',
				success:function(data){
					location.href = location.href;
				}
			})
		});
		$('.set_dp').click(function(){
			var id = $(this).attr('id');
			var html = $('.pop_up').html();
			$('#myModal').modal('show');
			$('.modal-dialog').addClass('modal-sm');
			$('.modal-title').text('Set Date Promised');
			$('.modal-body').html(html);
			$('form').submit(function(){
				var datas = $(this).serialize()+'&c_orderline_id='+id;
				$.ajax({
					url:'<?=base_url("data/create_dp_po");?>',
					type:"POST",
					data:datas,
					success:function(data){
						if(data == 1)
							location.href = location.href;
					}
				})
				return false;
			})
			return false;
		})
	})
</script>