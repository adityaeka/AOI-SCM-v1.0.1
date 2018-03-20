<style type="text/css">
	.download{
		width: 110px;
		height: 30px;
		float: right;
		border: 1px solid black;
		shape-margin: 10px;
	}
</style>
<div class="pad margin no-print">
	<div class="callout callout-info" style="margin-bottom: 0!important;">
        <h4><i class="fa fa-info"></i> nformation:</h4>
        Menampilkan Data dengan ETA (Estimated Time Arrival) Hari Ini.
    </div>
</div>

<div class="row">
	<div class="col-sm-12">
		<table class="table table-striped table-bordered" id="tablesss">
			<thead class="bg-green">
				<tr>
					<th style="width: 20px">#</th>
					<th>Supplier</th>
					<th>Packing List</th>
					<th>Invoice</th>
					<th>PO Supplier</th>
					<th>Category</th>
					<th>Item Code</th>
					<th>Request Arrival Date</th>
			    	<th>Date Promised</th>
			    	<th>Ex Factory Date</th>
			    	<th>ETA</th>
					<th>Qty Order</th>
					<th>Qty Delivery</th>
					<th>FOC</th>
					<th>UoM</th>
					<th>Qty Carton</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$nomor=1;
			$this->db->where('kst_etadate', date("Y-m-d"));
			$users = $this->db->get('adt_report_imported_pl_acc');
			foreach($users->result() as $po){
			?>
				<tr>
					<td><?=$nomor++;?></td>
					<td><?=$po->supplier;?></td>
					<td><?=$po->no_packinglist;?></td>
					<td><?=$po->kst_invoicevendor;?></td>
					<td><?=$po->documentno;?></td>
					<td><?=$po->category;?></td>
					<td><?=$po->item;?></td>
					<td><?=date('d/m/Y', strtotime($po->request_arrival_date));?></td>
					<td><?=date('d/m/Y', strtotime($po->date_promised));?></td>
					<td><?=date('d/m/Y', strtotime($po->exfctdate));?></td>
					<td><?=date('d/m/Y', strtotime($po->kst_etadate));?></td>
					<td><?=number_format($po->qtyentered,2);?></td>
					<td><?=$po->qty_upload;?></td>
					<td><?=$po->foc;?></td>
					<td><?=$po->uomsymbol;?></td>
					<td><?=$po->qty_carton;?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
      $(function(){
        $('#tablesss').DataTable({
            'paging':true,
            'scrollX': true
        });

        var url = location.href;
          url = url.split('#');
        if(url[1] != undefined && url[1] != ''){
          detail(url[1]);
        }
      });
    </script>