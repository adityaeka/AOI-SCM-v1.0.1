<?php

    $this->db2->where('c_bpartner_id',$_GET['c_bpartner_id']);
    $data_all= $this->db2->get('f_web_po_datepromised_detail')->result();

  header("Content-Type:application/vnd.ms-excel");
  header('Content-Disposition:attachment; filename="date_promised_detail.xls"');
?>

<table border="1px">
  <thead style="background-color: yellow">
    <th>SUPPLIER</th>
    <th>PURCHASE ORDER (PO)</th>
    <th>PO BUYER</th>
    <th>CATEGORY</th>
    <th>ITEM CODE</th>
    <th>PRODUCT CODE</th>
    <th>QTY ORDERED</th>
    <th>UOM</th>
    <th>REQUEST ARRIVAL DATE</th>
    <th>DATE PROMISED</th>
    <th>STATUS</th>
  </thead>
  <tbody>
    <?php foreach($data_all as $data){ ?>
      <tr>
        <td>
          <?php echo $data->supplier;?>
        </td>
        <td>
          <?php echo $data->documentno;?>
        </td>
        <td style="mso-number-format:'\@'">
          <?php echo $data->pobuyer;?>
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
          <?php echo $data->qtyentered;?>
        </td>
        <td>
          <?php echo $data->uomsymbol;?>
        </td>
        <td>
          <?php echo $data->datepromised;?>
        </td>
        <td>
          <?php echo $data->date_promised;?>
        </td>
        <td>
          <?php echo $data->status_dp;?>
        </td>
      </tr>
    <?php }?>
  </tbody>
</table>