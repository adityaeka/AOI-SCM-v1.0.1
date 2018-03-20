<?php    
    if(isset($_GET['c_bpartner_id']) && $_GET['c_bpartner_id'] != NULL){
      $this->db2->where('c_bpartner_id',$_GET['c_bpartner_id']);
    }
             
  $data_all= $this->db2->get('adt_excel_dp')->result();

  header("Content-Type:application/vnd.ms-excel");
  header('Content-Disposition:attachment; filename="Template Upload PO Confirmation.xls"');
?>

<table border="1px">
  <thead>
      <th>c_order_id</th>
      <th>c_bpartner_id</th>
      <th>type_po</th>
      <th>m_warehouse_id</th>
      <th>Supplier</th>
      <th>Purchase Order</th>
      <th>Category</th>
      <th>Warehouse</th>
      <th>Created PO</th>
      <th>Document Status</th>
      <th style="background-color: yellow;">ETA</th>
      <th style="background-color: yellow;">ETD</th>
  </thead>
  <tbody>
    <?php
      $nomor=1;
      foreach($data_all as $po){ 
    ?>
      <tr>        
        <td><?=$po->c_order_id;?></td>
        <td><?=$po->c_bpartner_id;?></td>
        <td><?=$po->type_po;?></td>
        <td><?=$po->m_warehouse_id;?></td>
        <td><?=$po->supplier;?></td>
        <td><?=$po->documentno;?></td>
        <td><?=$po->category;?></td>
        <td><?=$po->warehouse;?></td>
        <td style="mso-number-format:'Short Date'"><?=$po->create_po;?></td>
        <td><?=$po->docstatus;?></td>
        <td><?=$po->eta;?></td>
        <td><?=$po->etd;?></td>
      </tr>
    <?php }?>
  </tbody>
</table>