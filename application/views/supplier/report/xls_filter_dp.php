<?php
	// if(isset($_GET['c_bpartner_id']) && $_GET['c_bpartner_id'] != NULL){
 //    $this->db2->where('c_bpartner_id',$_GET['c_bpartner_id']);
	// }
	 
	// if(isset($_GET['last_confirm_date']) && $_GET['last_confirm_date'] != NULL){
	// $this->db2->where('date(last_confirm_date)',$_GET['last_confirm_date']);
	// }

	if(isset($_GET['from']) && $_GET['from'] != NULL){
    $dari   = date("Y-m-d 00:00:00",strtotime($_GET['from']));
    $this->db2->where('created_time >=',$dari);
	  }
	  if(isset($_GET['until']) && $_GET['until'] != NULL){
	    $sampai = date("Y-m-d 23:59:59",strtotime($_GET['until']));
	    $this->db2->where('created_time <=',$sampai);
	  }

    $this->db2->where('c_bpartner_id',$_GET['c_bpartner_id']);
    $data_all= $this->db2->get('rz_print_all_po_v2')->result();
    $tgl = date("Y-m-d");

  header("Content-Type:application/vnd.ms-excel");
  header('Content-Disposition:attachment; filename="purchase_order_detail.xls"');
?>

<table border="1px">
  <thead>
    <th style="background-color: green">C_ORDER ID</th>
    <th style="background-color: green">C_ORDERLINE_ID</th>
    <th style="background-color: green">C_BPARTNER_ID</th>
    <th style="background-color: gray">DATE PROMISED</th>
    <th>DATE CREATED PO</th>
    <th>PURCHASE ORDER (PO)</th>
    <th>SEASON</th>
    <th>SUPPLIER</th>
    <th>SHIP TO</th>
    <th>STYLE</th>
    <th>PO BUYER</th>
    <th>ITEM CODE</th>
    <th>PRODUCT CODE</th>
    <th>UOM</th>
    <th>QTY</th>
    <th>UNIT PRICE</th>
    <th>TOTAL AMOUNT</th>
    <th>CURRENCY</th>
    <th>REQUEST ARRIVAL DATE</th>
    <th>NOTE</th>
  </thead>
  <tbody>
    <?php foreach($data_all as $data){ ?>
      <tr>
        <td style="background-color: green">
          <?php echo $data->c_order_id;?>
         </td>
         <td style="background-color: green">
          <?php echo $data->c_orderline_id;?>
         </td>
        <td style="background-color: green">
          <?php echo $data->c_bpartner_id;?>
         </td>
         <td style="mso-number-format:'Short Date' background-color: gray;">
           <?php echo $data->date_promised;?>
         </td>
        <td style="mso-number-format:'Short Date'">
          <?php echo $data->tanggal;?>
        </td>           
        <td>
          <?php echo $data->docno;?>
         </td>
        <td>
          <?php echo $data->kst_season;?>
        </td>
        <td>
          <?php echo $data->customername;?>
        </td>
        <td>
          <?php echo $data->alamataoi;?>
        </td>
        <td>
          <?php echo $data->so;?>
        </td>
        <td style="mso-number-format:'\@'">
          <?php echo $data->poreference;?>
        </td>
        <td>
          <?php echo $data->itemcode;?>
        </td>
        <td>
          <?php echo $data->name;?>
        </td>
        <td>
          <?php echo $data->uom;?>
        </td>
        <td>
          <?php echo $data->qtyentered;?>
        </td>
        <td>
          <?php echo number_format($data->hargasatuan,4);?>
        </td>
        <td>
          <?php echo $data->total;?>
        </td>
        <td>
          <?php echo $data->iso_code;?>
        </td>
        <td style="mso-number-format:'Short Date'">
          <?=($data->datepromised_l == NULL) ? '-' : $data->datepromised_l;?>
        </td>
        <td>
          <?php echo $data->onote;?>
        </td>
      </tr>
    <?php }?>
  </tbody>
</table>