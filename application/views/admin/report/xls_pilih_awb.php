<?php    
  if(isset($_GET['c_bpartner_id']) && $_GET['c_bpartner_id'] != NULL){
    $this->db->where('c_bpartner_id',$_GET['c_bpartner_id']);
  }            
  $data_all= $this->db->get('adt_awb')->result();

  header("Content-Type:application/vnd.ms-excel");
  header('Content-Disposition:attachment; filename="Report_AWB.xls"');
?>

<table border="1px">
  <thead>
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
  </thead>
  <tbody>
    <?php
      $nomor=1;
      foreach($data_all as $po){ 
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
    <?php }?>
  </tbody>
</table>