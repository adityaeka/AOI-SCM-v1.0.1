<?php    
    if(isset($_GET['c_bpartner_id']) && $_GET['c_bpartner_id'] != NULL){
      $this->db->where('c_bpartner_id',$_GET['c_bpartner_id']);
    }
             
  $data_all= $this->db->get('adt_temp_date_promised')->result();

  header("Content-Type:application/vnd.ms-excel");
  header('Content-Disposition:attachment; filename="Template Upload Lock Date Promised.xls"');
?>

<table border="1px">
  <thead>
      <th>c_order_id</th>
      <th>c_orderline_id</th>
      <th>c_bpartner_id</th>
      <th>Supplier</th>
      <th>Purchase Order</th>
      <th>Item</th>
      <th>Category</th>
      <th>Date Required</th>
      <th style="background-color: yellow;">Date Promised</th>
      <th style="background-color: yellow;">Lock</th>
      <th>Lock Status</th>    
  </thead>
  <tbody>
    <?php
      $nomor=1;
      foreach($data_all as $po){ 
    ?>
      <tr>        
        <td><?=$po->c_order_id;?></td>
        <td><?=$po->c_orderline_id;?></td>
        <td><?=$po->c_bpartner_id;?></td>
        <td><?=$po->supplier;?></td>
        <td><?=$po->documentno;?></td>
        <td><?=$po->item;?></td>
        <td><?=$po->category;?></td>
        <td><?=$po->date_required;?></td>
        <td style="mso-number-format:'Short Date'"><?=$po->date_promised;?></td>
        <td><?=$po->lock;?></td>
        <td><?=$po->lock_status;?></td>
      </tr>
    <?php }?>
  </tbody>
</table>