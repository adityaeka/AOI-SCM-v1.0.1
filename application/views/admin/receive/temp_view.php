<?php
$temps = $this->db->where('user_id',$this->session->userdata('user_id'))->get('temp_receive');
if($temps->num_rows() > 0)
	$status = substr($temps->result()[0]->barcode_id,0,1);
else
	$status = 0;

if($status == 1){
	$this->db->join('m_material','m_material.barcode_id = temp_receive.barcode_id');
	$this->db->join('po_detail','po_detail.po_detail_id = m_material.po_detail_id');
	$this->db->order_by('created_time','DESC');
	$temp = $this->db->where('user_id',$this->session->userdata('user_id'))->get('temp_receive');
	if($temp->num_rows() > 0){ ?>
	<center>
	<a href="<?=base_url('receive/confirm?whs=1');?>" class="btn btn-flat btn-success" onclick='return confirm("Apakah anda yakin akan menerima material? Silahkan cek kembali. Sebelum anda melakukan receiving.")'>RECEIVE CONFIRM</a>
	</center><br>
	<table class="table table-bordered table-striped small">
		<thead>
			<tr class="bg-green">
				<th class='text-center'>#</th>
				<th>ITEM</th>
				<th>NAMA PRODUK</th>
				<th>NOMOR ROL</th>
				<th>QTY</th>
			</tr>
		</thead>	
		<tbody>
			<?php
				$nomor = 1;
				foreach($temp->result() as $temp){
					echo "<tr>";
					echo "<td class='text-center'>".$nomor++."</td>";
					echo "<td>".$temp->item."</td>";
					echo "<td>".$temp->desc_product."</td>";
					echo "<td>".$temp->nomor_roll."</td>";
					echo "<td>".number_format($temp->qty,3)."</td>";
					echo "</tr>";
				}
			?>
		</tbody>
	</table>
<?php
	} 
}else if($status == 2){
	$this->db->join('po_detail','po_detail.po_detail_id = temp_receive.barcode_id');
	$this->db->order_by('created_time','DESC');
	$temp = $this->db->where('user_id',$this->session->userdata('user_id'))->get('temp_receive');
	if($temp->num_rows() > 0){
		?>
		<center>
		<a href="<?=base_url('receive/confirm?whs=2');?>" class="btn btn-flat btn-success" onclick='return confirm("Apakah anda yakin akan menerima material? Silahkan cek kembali. Sebelum anda melakukan receiving.")'>RECEIVE CONFIRM</a>
		</center><br>
		<table class="table table-bordered table-striped small">
			<thead>
				<tr class="bg-green">
					<th>ITEM</th>
					<th>NAMA PRODUK</th>
					<th>PO BUYER</th>
					<th class='text-right'>QTY DELIVER</th>
					<th class='text-right'>QTY PO BUYER</th>
					<th class='text-center'>NO CARTON</th>
				</tr>
			</thead>	
			<tbody>
				<?php
					$nomor = 1;
					foreach($temp->result() as $temp){
						$pobuyer = $this->db->join('po_detailline','po_detailline.po_detailline_id::text = temp_receive_line.po_detailline_id')->where('po_detail_id',$temp->po_detail_id)->get('temp_receive_line');
						$pob = ''; 	
						foreach($pobuyer->result() as $pobu){
							$pob .= $pobu->poreference.'<br>';
						}
						if($pob == ''){
							$pob = $temp->pobuyer;
						}
						echo "<tr>";
						echo "<td>".$temp->item."</td>";
						echo "<td>".$temp->desc_product."</td>";
						echo "<td>".$pob."</td>";
						echo "<td class='text-right'>".number_format($temp->qty_upload,3)."</td>";
						echo "<td class='text-right'>".number_format($temp->qty_upload,3)."</td>";
						echo "<td class='text-center'>".$temp->no_carton."</td>";
						echo "</tr>";
					}
				?>
			</tbody>
		</table>		
		<?php
	}
}else{
	echo "No Item!";
}
?>