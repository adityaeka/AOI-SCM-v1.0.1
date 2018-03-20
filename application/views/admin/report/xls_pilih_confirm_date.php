<?php    
  if(isset($_GET['c_bpartner_id']) && $_GET['c_bpartner_id'] != NULL){
    $this->db2->where('c_bpartner_id',$_GET['c_bpartner_id']);
  }
 
  if(isset($_GET['last_confirm_date']) && $_GET['last_confirm_date'] != NULL){
    $this->db2->where('date(last_confirm_date)',$_GET['last_confirm_date']);
  }
             
  $data_all= $this->db2->get('adt_date_promised_detail_report')->result();

  header("Content-Type:application/vnd.ms-excel");
  header('Content-Disposition:attachment; filename="Report_Date_Promised_Detail.xls"');
?>

<table border="1px">
  <thead>
    <th style="width: 20px">#</th>
      <th>Supplier</th>
      <th>Purchase Order</th>
      <th>PO Buyer</th>
      <th>Category</th>
      <th>Item Code</th>
      <th>Product Code</th>
      <th>Qty Ordered</th>
      <th>Uom</th>
      <th>Request Arrival Date</th>
      <th>Date Confirmed</th>
  </thead>
  <tbody>
    <?php
      $nomor=1;
      foreach($data_all as $po){ 
    ?>
      <tr>        
        <td><?=$nomor++;?></td>
      <td><?=$po->supplier;?></td>
      <td><?=$po->documentno;?></td>
      <td><?=$po->pobuyer;?></td>
      <td><?=$po->category;?></td>
      <td><?=$po->item;?></td>
      <td><?=$po->desc_product;?></td>
      <td><?=number_format($po->qtyordered,2);?></td>
      <td><?=$po->uomsymbol;?></td>
      <td style="mso-number-format:'Short Date'"><?=$po->datepromised;?></td>
      <td style="mso-number-format:'Short Date'"><?=$po->last_confirm_date;?></td>
      </tr>
    <?php }?>
  </tbody>
</table>