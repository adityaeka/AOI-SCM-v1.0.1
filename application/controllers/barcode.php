<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Barcode extends CI_Controller {
  
  function __construct()
    {
    parent::__construct();
    date_default_timezone_set('Asia/Jakarta');
    $CI = &get_instance();
      $this->db2 = $CI->load->database('db2',TRUE);
    }
    function index(){
        echo $this->convert(1234.22121);
    }
    function convert( $num = '' )
      {
          $num    = ( string ) ( ( int ) $num );
         
          if( ( int ) ( $num ) && ctype_digit( $num ) )
          {
              $words  = array( );
             
              $num    = str_replace( array( ',' , ' ' ) , '' , trim( $num ) );
             
              $list1  = array('','one','two','three','four','five','six','seven',
                  'eight','nine','ten','eleven','twelve','thirteen','fourteen',
                  'fifteen','sixteen','seventeen','eighteen','nineteen');
             
              $list2  = array('','ten','twenty','thirty','forty','fifty','sixty',
                  'seventy','eighty','ninety','hundred');
             
              $list3  = array('','thousand','million','billion','trillion',
                  'quadrillion','quintillion','sextillion','septillion',
                  'octillion','nonillion','decillion','undecillion',
                  'duodecillion','tredecillion','quattuordecillion',
                  'quindecillion','sexdecillion','septendecillion',
                  'octodecillion','novemdecillion','vigintillion');
             
              $num_length = strlen( $num );
              $levels = ( int ) ( ( $num_length + 2 ) / 3 );
              $max_length = $levels * 3;
              $num    = substr( '00'.$num , -$max_length );
           $num_levels = str_split( $num , 3 );
             
              foreach( $num_levels as $num_part )
              {
                  $levels--;
                  $hundreds   = ( int ) ( $num_part / 100 );
                  $hundreds   = ( $hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ( $hundreds == 1 ? '' : 's' ) . ' ' : '' );
                  $tens       = ( int ) ( $num_part % 100 );
                  $singles    = '';
                 
                  if( $tens < 20 )
                  {
                      $tens   = ( $tens ? ' ' . $list1[$tens] . ' ' : '' );
                  }
                  else
                  {
                      $tens   = ( int ) ( $tens / 10 );
                      $tens   = ' ' . $list2[$tens] . ' ';
                      $singles    = ( int ) ( $num_part % 10 );
                      $singles    = ' ' . $list1[$singles] . ' ';
                  }
                  $words[]    = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_part ) ) ? ' ' . $list3[$levels] . ' ' : '' );
              }
             
              $commas = count( $words );
             
              if( $commas > 1 )
              {
                  $commas = $commas - 1;
              }
             
              $words  = implode( ', ' , $words );
             
              //Some Finishing Touch
              //Replacing multiples of spaces with one space
              $words  = trim( str_replace( ' ,' , ',' , trim_all( ucwords( $words ) ) ) , ', ' );
              if( $commas )
              {
                  $words  = str_replace_last( ',' , ' and' , $words );
              }
             
              return $words;
          }
          else if( ! ( ( int ) $num ) )
          {
              return 'Zero';
          }
          return '';
      }

function send_mail(){
  //panggil table supplier, terus didalam perulangan supplier kui, panggil funcgsi mail
  //$this->mail($a->c_bpartner_id,date,email, name supplier);
  //
  // $this->db->where('nama','ICT');
  $this->db->where('email !=','');
  $data = $this->db->get('m_user');
  foreach ($data->result() as $x) {
    $this->mail($x->email, $x->user_id);
  }
  
}

function  mail($email, $bpartner){
  $config['protocol'] = 'smtp';
  $config['smtp_host']  = 'mail.aoi.co.id';
  $config['smtp_port']  = 25;
  $config['smtp_user']  = 'po.system@aoi.co.id';
  $config['smtp_pass']  = 'AoiMail!16';
  $config['priority'] = 1;
  $config['mailtype'] = 'html';
  $config['charset']  = 'ISO-8859-1';
  $config['wordwrap'] = TRUE;

  $this->email->initialize($config);
  $this->email->from('no-reply@aoi.co.id','PO SCM SYSTEM');
  $this->email->to($email);
  $this->email->subject('PO Notifications System');
  $this->email->message($this->data_kirim($bpartner,date('Y-m-d')));
  if ($this->data_kirim_kosong($bpartner,date('Y-m-d'))) {
  $send = $this->email->send();
  //print_r($send);exit();
  }
}

private function data_kirim_kosong($supplier, $tanggal)
{
  $this->db2->where('c_bpartner_id',$supplier);
  $this->db2->where('date(last_confirm_date)',$tanggal);
  $data_all= $this->db2->get('adt_date_promised_detail')->num_rows();
  return $data_all;
}

private function data_kirim($supplier,$tanggal){
$this->db2->where('c_bpartner_id',$supplier);
$this->db2->where('date(last_confirm_date)',$tanggal);
$data_all= $this->db2->get('adt_date_promised_detail')->result();

$data = '
<table border="1px">
  <thead>
    <th style="width: 20px">#</th>
      <th>Purchase Order</th>
      <th>PO Buyer</th>
      <th>Category</th>
      <th>Created by</th>
  </thead>
  <tbody>';
      $nomor=1;
      foreach($data_all as $po){ 
      $data .= '<tr>';        
      $data .= '<td>'.$nomor++.'</td>';
      $data .= '<td>'.$po->documentno.'</td>';
      $data .= '<td>'.$po->pobuyer.'</td>';
      $data .= '<td>'.$po->category.'</td>';
      $data .= '<td>'.$po->createdby.'</td>';
      $data .= '</tr>';
     }
  $data .='</tbody>';
  $data .='</table>';
return $data;
}
}