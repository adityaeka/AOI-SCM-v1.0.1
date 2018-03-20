<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Receive extends CI_Controller {
	
	function __construct()
    {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$CI = &get_instance();
  		$this->db2 = $CI->load->database('db2',TRUE);

  		$CIS = &get_instance();
  		$this->dc = $CIS->load->database('dc',TRUE);
    }
   	function index(){
		$data['title_page'] = "RECEIVE";
		$data['desc_page']	= "SCAN";
		$data['content']	= "receive/scan";
		$this->load->view('layout',$data);
    }
    function view_temp(){
    	$this->load->view('admin/receive/temp_view');
    }
    function confirm(){
    	if($_GET['whs'] == 1){
			$this->db->join('m_material','m_material.barcode_id = temp_receive.barcode_id');
	    	$this->db->join('po_detail','po_detail.po_detail_id = m_material.po_detail_id');
			$this->db->distinct();
			$this->db->select('po_detail.c_orderline_id');
			$c_ol= $this->db->where('user_id',$this->session->userdata('user_id'))->get('temp_receive');
			foreach($c_ol->result() as $a){
				$cek = $this->db->where('c_orderline_id',$a->c_orderline_id)->get('m_received_number');
				if($cek->num_rows() == 0){
					$c_oli[$a->c_orderline_id] = 1;		
					$this->db->insert('m_received_number',array('c_orderline_id'=>$a->c_orderline_id,'last' => 1));		
				}else{
					foreach($cek->result() as $c_ol2){
						$c_oli[$a->c_orderline_id] = $c_ol2->last+1;
						$this->db->where('c_orderline_id',$a->c_orderline_id)->update('m_received_number',array('last'=>$c_ol2->last+1));
					}
				}
			}

			foreach($c_oli as $a => $b){
				$this->db->join('m_material','m_material.barcode_id = temp_receive.barcode_id');
				$this->db->join('po_detail','po_detail.po_detail_id = m_material.po_detail_id');
				$this->db->order_by('created_time','DESC');
				$this->db->where('po_detail.c_orderline_id',$a);
				$temp = $this->db->where('user_id',$this->session->userdata('user_id'))->get('temp_receive');
				foreach($temp->result() as $temps){
					$data = array(
						'barcode_id' => $temps->barcode_id,
						'user_id'	 => $temps->user_id,
						'validasi'   => $b
					);
					$this->db->where('barcode_id',$temps->barcode_id)->delete('temp_receive');
					$this->db->insert('m_received',$data);
				}
			}
		}else{
			$id_before = 0;
			$this->db->join('po_detail','po_detail.po_detail_id = temp_receive.barcode_id');
			$this->db->select('*,temp_receive.barcode_id as b_id');
			$this->db->where('user_id',$this->session->userdata('user_id'));
			$get = $this->db->get('temp_receive');
			foreach($get->result() as $gets){		
				if($gets->status_carton  == 'f'){
					
					$this->db->join('po_detailline','po_detailline.po_detailline_id::text = temp_receive_line.po_detailline_id');
					$ceknum = $this->db->where('po_detail_id',$gets->b_id)->get('temp_receive_line');
					$ceknum1 = $ceknum->num_rows();
					if($ceknum1 == 0){
						$data = array(
							'barcode_id' => $gets->b_id,
							'user_id'	 => $gets->user_id,
							'validasi'   => 1
						);
						$wms  = array(
							'barcode_id' 					=> $gets->po_detail_id,
							'poreference'					=> $gets->pobuyer,
							'm_product_category_value_fp'	=> $gets->category,
							'componentvalue'				=> $gets->item,
							'qtyrequired'					=> $gets->qty_upload,
							'name'							=> $gets->uomsymbol,
							'documentno'					=> $gets->documentno,
							'user_id'						=> $this->session->userdata('user_id'),
							'kst_etadate'					=> $gets->kst_etadate
						);
						$this->db->where('barcode_id',$gets->b_id)->delete('temp_receive');
						$this->dc->insert('material_arrival_new',$wms);
						$this->db->insert('m_received',$data);
					}else{
					$wms = array();
						$data = array(
							'barcode_id' => $gets->b_id,
							'user_id'	 => $gets->user_id,
							'validasi'   => 1
						);
						foreach($ceknum->result() as $line){
							$wms[]  = array(
								'barcode_id' 					=> $line->po_detailline_id,
								'poreference'					=> $line->poreference,
								'm_product_category_value_fp'	=> $gets->category,
								'componentvalue'				=> $gets->item,
								'qtyrequired'					=> $line->qty,
								'kst_joborder'					=> $line->kst_joborder,
								'style'							=> $line->style,
								'name'							=> $gets->uomsymbol,
								'documentno'					=> $gets->documentno,
								'user_id'						=> $this->session->userdata('user_id'),
								'kst_etadate'					=> $gets->kst_etadate
							);
							$this->db->where('po_detailline_id',$line->po_detailline_id)->update('po_detailline',array('receive'=>$line->qty,'flag_received'=>'t'));
							$delete_line[] = $line->po_detailline_id;
						}

						$this->db->where_in('po_detailline_id',$delete_line)->delete('temp_receive_line');
						$this->db->where('barcode_id',$gets->b_id)->delete('temp_receive');
						$this->dc->insert_batch('material_arrival_new',$wms);
						$this->db->insert('m_received',$data);
					}
				}else{
					if($id_before != $gets->barcode_id){
						$count = $this->db->where('barcode_id',$gets->barcode_id)->get('temp_receive')->num_rows();
						$cek_carton = $this->db->where('po_detail_id',$gets->barcode_id)->get('po_detail')->result()[0]->qty_carton;
							if($count == $cek_carton){
								$data = array(
								'barcode_id' => $gets->barcode_id,
								'user_id'	 => $gets->user_id,
								'validasi'   => 1
							);
							$wms  = array(
								'barcode_id' 					=> $gets->po_detail_id,
								'poreference'					=> $gets->pobuyer,
								'm_product_category_value_fp'	=> $gets->category,
								'componentvalue'				=> $gets->item,
								'qtyrequired'					=> $gets->qty_upload,
								'name'							=> $gets->uomsymbol,
								'documentno'					=> $gets->documentno,
								'user_id'						=> $this->session->userdata('user_id'),
								'kst_etadate'					=> $gets->kst_etadate
							);
							$this->db->where('barcode_id',$gets->barcode_id)->delete('temp_receive');
							$this->dc->insert('material_arrival_new',$wms);
							$this->db->insert('m_received',$data);
						}else{
							echo "Belum semua carton di scan!";
							header("Refresh:2; url=".base_url('receive'), true, 303);
						}
					}
					$id_before = $gets->barcode_id;		
				}
			}

		}
		redirect('receive');
    }
    function set_temp(){
    	$data = $_POST;
    	$id = substr($data['barcode_id'],0,2);
    	
    	if($id == 'PS'){
    		$a = $this->db->where('barcode_id',$data['barcode_id'])->get('po_detail');
    		if($a->num_rows() > 0){
    			$data['barcode_id'] = $a->result()[0]->po_detail_id;
    		}else{
    			$data['barcode_id'] = 12345667;
    		}
    	}

    	$data['user_id'] = $this->session->userdata('user_id');
    	//cek karton
    	$cart = explode('-', $data['barcode_id']);
    	if(sizeof($cart) > 1){
    		$data['barcode_id'] 	= $cart[0];
    		$data['status_carton']	= 't';
    		$data['no_carton']		= $cart[1];
    	}
    	//cek fabrik / accesories
    	$type = substr($data['barcode_id'],0,1);
    	//cek yang sudah ada di temporari
    	$temp = $this->db->where('user_id',$data['user_id'])->get('temp_receive');
    	if($temp->num_rows() > 0)
    		$status = substr($temp->result()[0]->barcode_id,0,1);
    	else
    		$status = $type;

    	if($type == $status){ //if type yang ada di temporary sama dengan yang di scan.
	    	if($type == 1){ //if fabric
		    	$cek1 = $this->db->where('barcode_id',$data['barcode_id'])->get('m_material')->num_rows();
		    	$cek2 = $this->db->where('barcode_id',$data['barcode_id'])->get('temp_receive')->num_rows();
		    	$cek3 = $this->db->where('barcode_id',$data['barcode_id'])->get('m_received')->num_rows();
		    	if($cek1 == 1 && $cek2 == 0 && $cek3 == 0){
		    		$this->db->insert('temp_receive',$data);
		    		echo 1;
		    	}else{
		    		if($cek2 == 1){
		    			echo 2;
		    		}else if($cek3 == 1){
		    			echo 3;
		    		}else{
		    			echo 0;
		    		}
		    	}
		    }else{ //if accesories
		    	$cek_line = $this->db->where('po_detail_id',$data['barcode_id'])->join('po_detailline','po_detailline.c_orderline_id = po_detail.c_orderline_id')->get('po_detail')->num_rows();
		    	if($cek_line <= 1){
			    	$cek1 = $this->db->where('po_detail_id',$data['barcode_id'])->get('po_detail')->num_rows();
			    	if(sizeof($cart) > 1)
			    	$this->db->where('no_carton',$cart[1]);
			    	$cek2 = $this->db->where('barcode_id',$data['barcode_id'])->get('temp_receive')->num_rows();
			    	
			    	$cek3 = $this->db->where('barcode_id',$data['barcode_id'])->get('m_received')->num_rows();
			    	if($cek1 == 1 && $cek2 == 0 && $cek3 == 0){
			    		$this->db->insert('temp_receive',$data);
			    		echo 1;
			    	}else{
			    		if($cek2 == 1){
			    			echo 2;
			    		}else if($cek3 == 1){
			    			echo 3;
			    		}else{
			    			echo 0;
			    		}
			    	}
			    }else{
			    	echo 10;
			    }
		    }
		}else{
			echo 4;
		}
    }

    function data(){
    	echo "<pre>";
    	$a = $this->dc->limit(1)->get('material_arrival_new')->result();
    	print_r($a);

    	$b = $this->db->limit(1)->get('po_detail')->result();
    	print_r($b);

    }
    
    function view_detailline(){
    	$this->db->where('po_detail_id',$_POST['barcode_id']);
    	$this->db->join('po_detailline','po_detailline.c_orderline_id = po_detail.c_orderline_id');
    	$data = $this->db->get('po_detail');
    	$this->load->view('admin/receive/detailline',array('data'=>$data,'po_detail_id'=>$_POST['barcode_id']));
    }

    function save_temp_detailline(){
    	foreach($_POST['data'] as $a => $b){
    		$datas[] = array(
    			'user_id' 			=> $this->session->userdata('user_id'),
    			'po_detailline_id'	=> $a,
    			'po_detail_id'		=> $_POST['po_detail_id'],
    			'qty'				=> $b
    		);
    	}
    	$this->db->where('po_detail_id',$_POST['po_detail_id'])->delete('temp_receive_line');
	    $a = $this->db->insert_batch('temp_receive_line',$datas);
		
    	$this->db->where('barcode_id',$_POST['po_detail_id'])->delete('temp_receive');
    	$data['user_id'] = $this->session->userdata('user_id');
    	$data['barcode_id']  = $_POST['po_detail_id'];
    	if($a){
			$cek1 = $this->db->where('po_detail_id',$_POST['po_detail_id'])->get('po_detail')->num_rows();
			$cek3 = $this->db->where('barcode_id',$_POST['po_detail_id'])->get('m_received')->num_rows();
			if($cek1 == 1){
				$this->db->insert('temp_receive',$data);
				echo 1;
			}else{
				if($cek2 == 1){
					echo 2;
				}else if($cek3 == 1){
					echo 3;
				}else{
					echo 0;
				}
			}
    	}
    	redirect(base_url('receive'));
    }
}