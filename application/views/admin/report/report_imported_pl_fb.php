<div class="pad margin no-print">
	<div class="callout callout-info" style="margin-bottom: 0!important;">
        <h4><i class="fa fa-info"></i> nformation:</h4>
        Menampilkan Data dengan ETA (Estimated Time Arrival) Hari Ini.
    </div>
</div>

<div class="row">
	<div class="col-sm-12">
		<table class="table table-striped table-bordered" id="tables">
			<thead class="bg-green">
				<tr>
					<th style="width: 20px">#</th>
					<th>Supplier</th>
					<th>Packing List</th>
					<th>Invoice</th>
					<th>Date Required</th>
			    	<th>Date Promised</th>
					<th>PO Supplier</th>
					<th>Category</th>
					<th>Item</th>
					<th>Qty Order</th>
					<th>Qty Upload</th>
					<th>FOC</th>
				</tr>
			</thead>
			<tbody>
				<?php
			$nomor=1;
			$users = $this->db->get('adt_report_imported_pl_fb');
			foreach($users->result() as $po){
			?>
				<tr>
					<td><?=$nomor++;?></td>
					<td><?=$po->supplier;?></td>
					<td><?=$po->no_packinglist;?></td>
					<td><?=$po->kst_invoicevendor;?></td>
					<td><?=$po->date_required;?></td>
					<td><?=$po->date_promised;?></td>
					<td><?=$po->documentno;?></td>
					<td><?=$po->category;?></td>
					<td><?=$po->item;?></td>
					<td><?=$po->qtyordered;?></td>
					<td><?=$po->qty_upload;?></td>
					<td><?=$po->foc;?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>