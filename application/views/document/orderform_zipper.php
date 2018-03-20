<?php
   $this->db2->where('c_order_id',$_GET['c_order_id']);
    $data_all= $this->db2->get('f_web_orderform_zipper')->result();

  header("Content-Type:application/vnd.ms-excel");
  header('Content-Disposition:attachment; filename="order_form_zipper_'.date('d-m-Y').'.xls"');
?>

<table border="1px">
  <thead style="background-color: yellow">
  	<th>C_ORDERLINE_ID</th>
    <th>BUYER</th>
    <th>STYLE</th>
    <th>SEASON</th>
    <th>YEAR</th>
    <th>MONTH</th>
    <th>ORDER TYPE</th>
    <th>PO CUSTOMER</th>
    <th>PO BUYER</th>
    <th style="background-color: green">CUSTOMER PO NUMBER</th>
    <th>PRODUCT CODE</th>
    <th style="background-color: green">ITEM CODE</th>
    <th>INSERTION</th>
    <th>RUBBER COLOR</th>
    <th style="background-color: green">SPECIAL FEATURE</th>
    <th style="background-color: green">ITEM YKK</th>
    <th>TAPE COLOR</th>
    <th style="background-color: green">COLOR YKK</th>
    <th>LENGTH</th>
    <th>LUNIT</th>
    <th>QTY</th>
    <th>QUNIT</th>
    <th>REQUEST DATE</th>
    <th>UNIT PRICE</th>
    
  </thead>
  <tbody>
    <?php foreach($data_all as $data){ ?>
      <tr>
        <td style="background-color: yellow">
          <?php echo $data->c_orderline_id;?>
        </td>
        <td>
          <?php echo $data->brand;?>
        </td>
        <td>
          <?php echo $data->style;?>
        </td>
        <td>
          <?php echo $data->season;?>
        </td>
        <td>
          <?php echo $data->year;?>
        </td>
        <td>
          <?php echo $data->bulan;?>
        </td>
        <td>
          <?php echo $data->order_type;?>
        </td>
        <td>
          <?php echo $data->po_customer;?>
        </td>
        <td style="mso-number-format:'\@'">
          <?php echo $data->po_buyer;?>
        </td>
        <td style="background-color: green">
          
        </td>
        <td>
          <?php echo $data->product_code;?>
        </td>
        <td style="background-color: green">
          <?php echo $data->item_code;?>
        </td>
        <td>
          <?php echo $data->insertion;?>
        </td>
        <td>
          <?php echo $data->rubber_color;?>
        </td>
        <td style="background-color: green">
          <?php echo $data->special_feature;?>
        </td>
        <td style="background-color: green">
          <?php echo $data->item_ykk;?>
        </td>
        <td>
          <?php echo $data->tape_color;?>
        </td>
         <td style="background-color: green">
          <?php echo $data->color_ykk;?>
        </td>
        <td style="mso-number-format:'\@'">
          <?php echo $data->length;?>
        </td>
        <td>
          <?php echo $data->lunit;?>
        </td>
        <td>
          <?php echo number_format($data->qty,0);?>
        </td>
        <td>
          <?php echo $data->qunit;?>
        </td>
        <td style="mso-number-format:'Short Date'">
          <?=($data->datepromised == NULL) ? '-' : $data->datepromised;?>
        </td>
        <td style="mso-number-format:'0\.0000'">
        	<?php echo number_format($data->priceentered,4);?>
        </td>
      </tr>
    <?php }?>
  </tbody>
</table>