<?php
  if(isset($_POST['c_bpartner_id']) && $_POST['c_bpartner_id'] != NULL){
    $this->db->where('c_bpartner_id',$_POST['c_bpartner_id']);
    $c_bpartner_id = $_POST['c_bpartner_id'];
  }else{
    $c_bpartner_id = '';
  }

        $this->db->order_by('awb','desc');
  $report = $this->db->get('adt_awb');
        $this->db->order_by('nama','asc');
  $supplier = $this->db->get('m_user');
?>
<div class="row">
  <div class="col-sm-3">
    <form method="POST" action="">
      <label>Supplier</label>
      <select class="form-control" name="c_bpartner_id">
        <option value="">Pilih Nama Supplier</option>
        <?php
          foreach ($supplier->result() as $dt) {
            echo "<option value='".$dt->user_id."'>".$dt->nama."</option>";
          }
        ?>
      </select>
      <label></label>
      <button class="btn btn-flat btn-primary btn-block">Search</button>
      <br>
    </form>
  </div>
  <?php
    if(isset($_POST['c_bpartner_id'])){
      ?>
        <div class="col-sm-9">
          <br>
          <a href="<?=base_url('admin/xls_pilih_awb?c_bpartner_id='.$c_bpartner_id);?>" class="btn btn-flat btn-success pull-right"><i class='fa fa-download'></i> DOWNLOAD</a>
        </div>
      <?php
    }
  ?>
</div>  


<?php
  if($report->num_rows() > 0){
?>
<table class="table table-striped table-bordered" id="tablesss">
  <thead class="bg-purple">
    <tr>
      <th style="width: 20px">#</th>
      <th>AWB</th>
      <th>Packing List</th>
      <th>Supplier</th>
      <th>PO</th>
      <th>Category</th>
      <th>Qty Ordered</th>
      <th>Qty Entered</th>
      <th>Qty Upload</th>
      <th>Uom</th>
      <th>Qty Package</th>
    </tr>
  </thead>
  <tbody>
  <?php
    $nomor=1;
    foreach($report->result() as $po){
  ?>
    <tr>
      <td><?=$nomor++;?></td>
      <td><?=$po->awb;?></td>
      <td><?=$po->no_packinglist;?></td>
      <td><?=$po->supplier;?></td>
      <td><?=$po->documentno;?></td>
      <td><?=$po->product_category;?></td>
      <td><?=number_format($po->qtyordered,2);?></td>
      <td><?=number_format($po->qtyentered,2);?></td>
      <td><?=number_format($po->qty_upload,2);?></td>
      <td><?=$po->uomsymbol;?></td>
      <td><?=$po->qty_carton;?></td>
    </tr>
  <?php
    }
  ?>
  </tbody>
</table>
<?php }else{
  echo "<strong class='text-danger'>No data found</strong>";
} ?>
<script type="text/javascript">
      $(function(){
        $('#tablesss').DataTable({
            'paging':true,
            'scrollX':false
        });

        var url = location.href;
          url = url.split('#');
        if(url[1] != undefined && url[1] != ''){
          detail(url[1]);
        }
      });
    </script>