<?php    

  if(isset($_GET['exfctdate']) && $_GET['exfctdate'] != NULL){
    $this->db->where('exfctdate',$_GET['exfctdate']);
    $exfctdate = $_GET['exfctdate'];
  }else{
    $exfctdate = '';
  }

  if(isset($_GET['kst_etadate']) && $_GET['kst_etadate'] != NULL){
    $this->db->where('kst_etadate',$_GET['kst_etadate']);
    $kst_etadate = $_GET['kst_etadate'];
  }else{
    $kst_etadate = '';
  }
  
  if(isset($_GET['c_bpartner_id']) && $_GET['c_bpartner_id'] != NULL){
    $this->db->where('c_bpartner_id',$_GET['c_bpartner_id']);
    $c_bpartner_id = $_GET['c_bpartner_id'];
  }else{
    $c_bpartner_id = '';
  }

  $data_all= $this->db->get('adt_report_imported_pl_fb')->result();

  header("Content-Type:application/vnd.ms-excel");
  header('Content-Disposition:attachment; filename="Report_Imported_PackingList_acc.xls"');
?>

<table border="1px">
  <thead>
    <th style="width: 20px">#</th>
      <th>Ex Factory Date (ETD)</th>
      <th>Estimated Time Arrival (ETA)</th>
      <th>Supplier</th>
      <th>PO Supplier</th>
      <th>Packing List</th>
      <th>Invoice</th>
      <th>Category</th>
      <th>Item</th>
      <th>Request Arrival Date</th>
      <th>Date Promised</th>
      <th>Qty Order</th>
      <th>Qty Delivery</th>
      <th>FOC</th>
      <th>UoM</th>
      <th>Qty Package</th>
  </thead>
  <tbody>
    <?php
      $nomor=1;
      foreach($data_all as $data){ 
    ?>
      <tr>              
        <td><?=$nomor++;?></td>
        <td style="mso-number-format:'Short Date'"><?=$data->exfctdate;?></td>
        <td style="mso-number-format:'Short Date'"><?=$data->kst_etadate;?></td>
        <td><?=$data->supplier;?></td>
        <td><?=$data->documentno;?></td>
        <td><?=$data->no_packinglist;?></td>
        <td><?=$data->kst_invoicevendor;?></td>
        <td><?=$data->category;?></td>
        <td><?=$data->item;?></td>
        <td style="mso-number-format:'Short Date'"><?=($data->request_arrival_date == NULL) ? '-' : $data->request_arrival_date;?></td>
        <td style="mso-number-format:'Short Date'"><?=($data->date_promised == NULL) ? '-' : $data->date_promised;?></td>
        <td><?=number_format($data->qtyentered,2);?></td>
        <td><?=$data->qty_upload;?></td>
        <td><?=$data->foc;?></td>
        <td><?=$data->uomsymbol;?></td>
        <td><?=$data->qty_carton;?></td>
      </tr>
    <?php }?>
  </tbody>
</table>