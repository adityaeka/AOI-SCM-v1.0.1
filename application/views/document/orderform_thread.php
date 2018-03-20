<?php
    $this->db2->order_by('description');
    $this->db2->where('c_order_id',$_GET['c_order_id']);
    $data_all= $this->db2->get('kst_thread_order_v')->result();

  header("Content-Type:application/vnd.ms-excel");
  header('Content-Disposition:attachment; filename="order_form_thread_'.date('d-m-Y').'.xls"');
?>

<table border="1px">
  <thead style="background-color: yellow">
    <th>SHIP TO</th>
    <th>MATERIAL CODE</th>
    <th>SUPPLIER COLOR</th>
    <th>P/O No</th>
    <th>REQUEST ARRIVAL DATE</th>
    <th>QTY ORDER</th>
    <th>UoM</th>
    <th>COLOR</th>
    <th>PO BUYER</th>
  </thead>
  <tbody>
    <?php foreach($data_all as $data){ ?>
      <tr>
        <td>
          <?php echo "AOI";?>
         </td>
        <td>
          <?php echo $data->description;?>
        </td>
        <td>
          
        </td>
        <td>
          <?php echo $data->documentno;?>
        </td>
        <td style="mso-number-format:'Short Date'">
          <?=($data->datepromised == NULL) ? '-' : $data->datepromised;?>
        </td>
        <td>
          <?php echo $data->qtyentered;?>
        </td>
        <td>
          <?php echo $data->uom;?>
        </td>
        <td>
          <?php echo $data->color;?>
        </td>
        <td style="mso-number-format:'\@'">
          <?php echo $data->poreference;?>
        </td>
      </tr>
    <?php }?>
  </tbody>
</table>