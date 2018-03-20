<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class label extends CI_Controller {
	
	function __construct()
    {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$CI = &get_instance();
  		$this->db2 = $CI->load->database('db2',TRUE);
	}

	public function label_fabric($orderline)
	{
		$data['po_detail'] = $orderline;
		$this->load->view('supplier/label/label_product',$data);
	}

	public function label_acc($id)
	{
		$data['po_detail_id'] = $id;
		$this->load->view('supplier/label/label_product_acc',$data);
	}


	public function acc()
	{
		$data['nopl'] 	= $_GET['nopl'];
		$data['sj'] 	= $_GET['sj'];
		$data['inv'] 	= $_GET['inv'];
		$data['awb'] 	= $_GET['awb'];
		$this->load->view('supplier/label/label_product_acc_new',$data);
	}
	public function sml()
	{
		$data['nopl'] 	= $_GET['nopl'];
		$data['sj'] 	= $_GET['sj'];
		$data['inv'] 	= $_GET['inv'];
		$data['awb'] 	= $_GET['awb'];
		$this->load->view('supplier/label/label_product_sml',$data);
	}
	public function accs()
	{
		$data['nopl'] 	= $_GET['nopl'];
		$data['sj'] 	= $_GET['sj'];
		$data['inv'] 	= $_GET['inv'];
		$data['awb'] 	= $_GET['awb'];
		$this->load->view('supplier/label/label_product_acc_news',$data);
	}

	public function label_fb_new($nopl, $sj, $inv, $awb)
	{
		$data['nopl'] = $nopl;
		$data['sj'] = $sj;
		$data['inv'] = $inv;
		$data['awb'] = $awb;
		$this->load->view('supplier/label/label_product_fb_new',$data);
	}
	function test_pobuyer($corderline=0){
		$x = $this->db->query('select c_orderline_id from po_detail');
		foreach($x->result() as $y){
			$a = $this->db2->where('c_orderline_id',$y->c_orderline_id)->get('f_web_po_detail_line');
			foreach($a->result() as $b){
				unset($b->qty,$b->documentno,$b->c_order_id, $b->m_product_category_value_fp, $b->componentvalue,$b->name);
				$cek = $this->db->where('c_orderline_id',$y->c_orderline_id)->where('poreference',$b->poreference)->get('po_detailline')->num_rows();
				if($cek == 0){
					$this->db->insert('po_detailline',$b);
					echo 1;
				}else{
					echo 2;
				}
			}
			echo "<br>";
		}
	}

}