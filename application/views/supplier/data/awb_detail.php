<?php
	$this->db->where('no_packinglist',$id);
	$a = $this->db->get('adt_awb_detail');
	if($a->result()[0]->type_po == 2){
		foreach($a->result() as $b){ ?>
		
		<tr class="_<?=$id;?>">
			<td class="text-center"><input type="checkbox" class="c_<?=$b->no_packinglist;?>" onclick='activated(<?=$b->no_packinglist;?>)'></td>
			<td><?=$b->no_packinglist;?></td>
			<td><?=$b->docno;?></td>
			<td><?=$b->desc_product;?></td>
			<td><?=number_format($b->qtyentered,2);?></td>
			<td class="text-center"><?=$b->uomsymbol;?></td>
			<td class="text-center"><?=$dpr;?></td>
			<td>
				<input name='<?=$b->c_orderline_id;?>[qd]' class="inp qd_<?=$b->c_orderline_id;?>" val="<?=number_format($b->qtyentered,2,'.','');?>" type="number" disabled required>
			</td>
			<td>
				<input name="<?=$b->c_orderline_id;?>[foc]" class="inp foc_<?=$b->c_orderline_id;?>" type="number" disabled required>
			</td>
			<td>
				<input name="<?=$b->c_orderline_id;?>[car]" class="inp car_<?=$b->c_orderline_id;?>" type="number" disabled required>
			</td>
		</tr>
		<?php
		}
	}else{
		foreach($a->result() as $b){
		$warna = $this->db->where('c_orderline_id',$b->c_orderline_id)->get('po_detail')->num_rows();
		?>
		<tr class="_<?=$id;?> <?php if($warna > 0){echo 'bg-yellow'; } ?>">
			<td class="text-center"><input type="checkbox" class="c_<?=$b->c_orderline_id;?>" onclick='activated(<?=$b->c_orderline_id;?>)'></td>
			<td><?=$b->documentno;?></td>
			<td><?=$b->item;?></td>
			<td><?=$b->desc_product;?></td>
			<td><?=number_format($b->qtyentered,2);?></td>
			<td class="text-center"><?=$b->uomsymbol;?></td>
			<td></td>
			<td class="text-center">
				<input name="<?=$b->c_orderline_id;?>[foc]" class="inp foc_<?=$b->c_orderline_id;?>" type="number" disabled required>
			</td>
			<td>
				<input name="<?=$b->c_orderline_id;?>" class="inp imp imp_<?=$b->c_orderline_id;?>" type="file" multiple disabled required>	
			</td>
		</tr>
		<?php
		}
	}
?>