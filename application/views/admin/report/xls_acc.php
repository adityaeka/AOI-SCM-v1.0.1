<?php

    $data_all= $this->db->get('adt_report_imported_pl_acc')->result();

  header("Content-Type:application/vnd.ms-excel");
  header('Content-Disposition:attachment; filename="Report_Imported_PackingList_acc.xls"');
?>

<table border="1px">
  <thead>
    <th>SUPPLIER</th>
    <th>PACKINGLIST</th>
    <th>INVOICE</th>
    <th>PO SUPPLIER</th>
    <th>CATEGORY</th>
    <th>ITEM CODE</th>
    <th>PRODUCT</th>
    <th>DATE REQUIRED</th>
    <th>DATE PROMISED</th>
    <th>EX FACTORY DATE</th>
    <th>QTY ORDER</th>
    <th>QTY DELIVERED</th>
    <th>FOC</th>
    <th>UOM</th>
    <th>QTY CARTON</th>
  </thead>
  <tbody>
    <?php foreach($data_all as $data){ ?>
      <tr>              
        <td>
          <?php echo $data->supplier;?>
         </td>
        <td>
          <?php echo $data->no_packinglist;?>
        </td>
         <td>
          <?php echo $data->kst_invoicevendor;?>
        </td>
        <td>
          <?php echo $data->documentno;?>
        </td>
        <td>
          <?php echo $data->category;?>
        </td>
        <td>
          <?php echo $data->item;?>
        </td>
        <td>
          <?php echo $data->desc_product;?>
        </td>
        <td>
          <?php echo $data->date_required;?>
        </td>
        <td>
          <?php echo $data->date_promised;?>
        </td>
        <td>
          <?php echo $data->exfctdate;?>
        </td>
        <td>
          <?php echo $data->qtyentered;?>
        </td>
        <td>
          <?php echo $data->qty_upload;?>
        </td>       
        <td>
          <?php echo $data->foc;?>
        </td>
        <td>
          <?php echo $data->uomsymbol;?>
        </td>
        <td>
          <?php echo $data->qty_carton;?>
        </td>
      </tr>
    <?php }?>
  </tbody>
</table>