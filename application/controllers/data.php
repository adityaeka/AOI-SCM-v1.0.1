<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Data extends CI_Controller {	
	function __construct()
    {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$CI = &get_instance();
  		$this->db2 = $CI->load->database('db2',TRUE);
    }

	public function index(){
		$data['title_page'] = "DATA";
		$data['desc_page']	= "HASIL UPLOAD";
		$data['content']	= "data/index";
		$this->load->view('layout',$data);
	}

	public function home(){
		$data['title_page'] = "PURCHASE ORDER";
		$data['desc_page']	= "WELCOME";
		$data['content']	= "data/home";
		$this->load->view('layout',$data);	
	}

	public function po(){
		$data['title_page'] = "PURCHASE ORDER";
		$data['desc_page']	= "ACTIVE";
		$data['content']	= "data/po";
		$this->load->view('layout',$data);	
	}

	function po_detail($c_order_id=0){
		$data['title_page'] = "PURCHASE ORDER";
		$data['desc_page']	= "DETAIL";
		$data['content']	= "data/po_detail";
		$data['c_order']	= $c_order_id;
		$this->load->view('layout',$data);	
	}

	function form_upload($id=0,$c_order=0){
		?>
		<form method="POST" action="<?=base_url('data/upload_pl/'.$id.'/'.$c_order);?>" enctype="multipart/form-data">
			<label>Packing List</label>
			<input type="file" name="data" class="form-control" placeholder="Insert Quantity FOC" required>
			<br>	
			<button class="btn btn-success" name="upload">Save Changes</button>
		</form>
		<?php	
	}

	function input_nopl($id){
		$data = $this->db2->where('c_orderline_id',$id)->get('f_web_po_detail')->result()[0];
		$data->no_packinglist = $_POST['nopl'];
		$po_header = $this->db->where('c_order_id',$data->c_order_id)->get('po_header')->num_rows();
		if($po_header == 0){
			$header = $this->db2->where('c_order_id',$data->c_order_id)->get('f_web_po_header')->result()[0];
			$insert_header = $this->db->insert('po_header',$header);
		}
		$po_detail = $this->db->where('c_orderline_id',$data->c_orderline_id)->get('po_detail')->num_rows();
		if($po_detail == 0){
			$this->db->insert('po_detail',$data);
		}else{
			$this->db->where('c_orderline_id',$data->c_orderline_id)->update('po_detail',$data);
		}
	}
	function input_nopl_($id){
		$data['no_packinglist'] = $_POST['nopl'];
		$this->db->where('po_detail_id',$id)->update('po_detail',$data);
	}
	function upload_pl($id=0){
		if($id != 0){
			include $_SERVER["DOCUMENT_ROOT"].'/library/Classes/PHPExcel/IOFactory.php';
			if(isset($_POST["upload"])){
				$path = $_SERVER["DOCUMENT_ROOT"]."/file/";
				if($_FILES["data"]["type"] != 'application/kset' && 
				   $_FILES["data"]["type"] != 'application/vnd.ms-excel' && 
				   $_FILES["data"]["type"] != 'application/xls' && 
				   $_FILES["data"]["type"] != 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' && 
				   $_FILES["data"]["type"] != 'application/ms-excel'){
					echo "<div class='alert alert-danger text-center'>File tidak support, pastikan <b>.xls</b></div>";
					echo "<div><a href='import'>Back</a></div>";
				}else{
					$data 			= move_uploaded_file($_FILES["data"]["tmp_name"], $path.$_FILES['data']['name']);
					$inputFileName 	= $path.$_FILES['data']['name'];
					$objPHPExcel 	= PHPExcel_IOFactory::load($inputFileName);
					$sheetCount 	= $objPHPExcel->getSheetCount();
					$sheet 			= $objPHPExcel->getSheetNames();
					$sheetData 		= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
					$data = array();
					foreach($sheetData as $a => $b){
						if($a > 1){
							$data = array(
								'po_detail_id' 		=> $id,
								'nomor_roll' 		=> $b['A'],
								'qty'	 	 		=> $b['B'],
								'uomsymbol'			=> $b['C'],
								'batch_number'	 	=> $b['D']
							);
							$this->db->insert('m_material',$data);
						}
					}
				}
			}
			redirect(base_url('data/po_detail/'.$c_order.'?status=success'));
		}
	}
	function new_pl_submit(){
		$type = $_POST['type_po'];
		unset($_POST['type_po']);
		$data = $_POST;
		$no_packinglist 		= $data['no_packinglist'];
		$kst_suratjalanvendor	= $data['kst_suratjalanvendor'];
		$kst_invoicevendor		= $data['kst_invoicevendor'];
		$kst_resi				= $data['kst_resi'];
		$kst_etddate			= $data['kst_etddate'];
		$kst_etadate			= $data['kst_etadate'];
		unset($data['no_packinglist'], $data['kst_suratjalanvendor'], $data['kst_invoicevendor'], $data['kst_resi'],$data['kst_etddate'], $data['kst_etadate']);
		foreach ($data as $a => $b) {
			$c_orderline[] = $a;
		}
		if(isset($c_orderline)){
			$this->db2->where_in('c_orderline_id',$c_orderline);
			$asli = $this->db2->get('f_web_po_detail');
			foreach($asli->result() as $b){
				//----------------------------------------------------------------------------------------
				$po_header = $this->db->where('c_order_id',$b->c_order_id)->get('po_header');
				if($po_header->num_rows() == 0){
					$aa = $this->db2->where('c_order_id',$b->c_order_id)->get('f_web_po_header')->result()[0];
					$this->db->insert('po_header',$aa);
				}
				$this->copy_line($b->c_orderline_id);
				$b->no_packinglist 			= $no_packinglist;
				$b->kst_suratjalanvendor 	= $kst_suratjalanvendor;
				$b->kst_invoicevendor 		= $kst_invoicevendor;
				$b->kst_resi				= $kst_resi;
				$b->kst_etddate				= $kst_etddate;
				$b->kst_etadate				= $kst_etadate;	
				if($type == 2){
					$b->qty_upload 			= $data[$b->c_orderline_id]['qd'];
					$b->qty_carton 			= $data[$b->c_orderline_id]['car'];
				}
				$b->foc 					= $data[$b->c_orderline_id]['foc'];
				$ins = $this->db->insert('po_detail',$b);
				if($type == 1){
					$where['c_order_id'] 	 = $b->c_order_id;
					$where['c_orderline_id'] 	 = $b->c_orderline_id;
					$where['no_packinglist'] = $b->no_packinglist;
					$file = $_FILES[$b->c_orderline_id];
					$cek_id = $this->db->where($where)->order_by('po_detail_id','DESC')->limit(1)->get('po_detail')->result()[0]->po_detail_id;
					$this->upload_pl_fb($cek_id,$file);
				}
				/////
			}
		}
		redirect(base_url('data/pl_list'));
	}
	function upload_pl_fb($id=0,$data){
		if($id != 0){
			include $_SERVER["DOCUMENT_ROOT"].'/po_supplier/library/Classes/PHPExcel/IOFactory.php';
			$path = $_SERVER["DOCUMENT_ROOT"]."/po_supplier/file/";
			if($data["type"] != 'application/kset' && 
			   $data["type"] != 'application/vnd.ms-excel' && 
			   $data["type"] != 'application/xls' && 
			   $data["type"] != 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' && 
			   $data["type"] != 'application/ms-excel'){
				echo "<div class='alert alert-danger text-center'>File tidak support, pastikan <b>.xls</b></div>";
				echo "<div><a href='import'>Back</a></div>";
			}else{
				$datas 			= move_uploaded_file($data["tmp_name"], $path.$data['name']);
				$inputFileName 	= $path.$data['name'];
				$objPHPExcel 	= PHPExcel_IOFactory::load($inputFileName);
				$sheetCount 	= $objPHPExcel->getSheetCount();
				$sheet 			= $objPHPExcel->getSheetNames();
				$sheetData 		= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
				$datas = array();
				foreach($sheetData as $a => $b){
					if($a > 1){
						$datas = array(
							'po_detail_id' 		=> $id,
							'nomor_roll' 		=> $b['A'],
							'qty'	 	 		=> $b['B'],
							'uomsymbol'			=> $b['C'],
							'batch_number'	 	=> $b['D']
						);
						$this->db->insert('m_material',$datas);
					}
					$a = $this->db->select_sum('qty')->where('po_detail_id',$id)->get('m_material')->result();
					foreach($a as $ba){
						$this->db->where('po_detail_id',$id)->update('po_detail',array('qty_upload'=>$ba->qty));
					}
				}
			}
		}
	}
	function input_qty($id=0){
		$data = $this->db2->where('c_orderline_id',$id)->get('f_web_po_detail')->result()[0];
		$data->qty_upload = $_POST['qty'];
		$po_header = $this->db->where('c_order_id',$data->c_order_id)->get('po_header')->num_rows();
		if($po_header == 0){
			$header = $this->db2->where('c_order_id',$data->c_order_id)->get('f_web_po_header')->result()[0];
			$insert_header = $this->db->insert('po_header',$header);
		}
		$po_detail = $this->db->where('c_orderline_id',$data->c_orderline_id)->get('po_detail')->num_rows();
		if($po_detail == 0){
			$this->db->insert('po_detail',$data);
		}else{
			$this->db->where('c_orderline_id',$data->c_orderline_id)->update('po_detail',$data);
		}
	}
	function input_qty_($id=0){
		$data['qty_upload'] = $_POST['qty'];
		$this->db->where('po_detail_id',$id)->update('po_detail',$data);
	}
	function input_foc($id=0){
		$data = $this->db2->where('c_orderline_id',$id)->get('f_web_po_detail')->result()[0];
		$data->foc = $_POST['foc'];
		$po_header = $this->db->where('c_order_id',$data->c_order_id)->get('po_header')->num_rows();
		if($po_header == 0){
			$header = $this->db2->where('c_order_id',$data->c_order_id)->get('f_web_po_header')->result()[0];
			$insert_header = $this->db->insert('po_header',$header);
		}
		$po_detail = $this->db->where('c_orderline_id',$data->c_orderline_id)->get('po_detail')->num_rows();
		if($po_detail == 0){
			$this->db->insert('po_detail',$data);
		}else{
			$this->db->where('c_orderline_id',$data->c_orderline_id)->update('po_detail',$data);
		}
	}
	function input_foc_($id=0){
			$data['foc'] = $_POST['foc'];
			$this->db->where('po_detail_id',$id)->update('po_detail',$data);
	}
	function input_carton($id=0){
		$data = $this->db2->where('c_orderline_id',$id)->get('f_web_po_detail')->result()[0];
		$data->qty_carton = $_POST['qty_carton'];
		$po_header = $this->db->where('c_order_id',$data->c_order_id)->get('po_header')->num_rows();
		if($po_header == 0){
			$header = $this->db2->where('c_order_id',$data->c_order_id)->get('f_web_po_header')->result()[0];
			$insert_header = $this->db->insert('po_header',$header);
		}
		$po_detail = $this->db->where('c_orderline_id',$data->c_orderline_id)->get('po_detail')->num_rows();
		if($po_detail == 0){
			$this->db->insert('po_detail',$data);
		}else{
			$this->db->where('c_orderline_id',$data->c_orderline_id)->update('po_detail',$data);
		}
	}
	function input_carton_($id=0){
		$data->qty_carton = $_POST['qty_carton'];
		$this->db->where('po_detail_id',$id)->update('po_detail',$data);
	}

	function input_sj($id){
		$data = $this->db2->where('c_orderline_id',$id)->get('f_web_po_detail')->result()[0];
		$data->kst_suratjalanvendor = $_POST['sj'];
		$po_header = $this->db->where('c_order_id',$data->c_order_id)->get('po_header')->num_rows();
		if($po_header == 0){
			$header = $this->db2->where('c_order_id',$data->c_order_id)->get('f_web_po_header')->result()[0];
			$insert_header = $this->db->insert('po_header',$header);
		}
		$po_detail = $this->db->where('c_orderline_id',$data->c_orderline_id)->get('po_detail')->num_rows();
		if($po_detail == 0){
			$this->db->insert('po_detail',$data);
		}else{
			$this->db->where('c_orderline_id',$data->c_orderline_id)->update('po_detail',$data);
		}
	}
	function input_sj_($id){
		$data['kst_suratjalanvendor'] = $_POST['sj'];
		$this->db->where('po_detail_id',$id)->update('po_detail',$data);
	}

	function input_inv($id){
		$data = $this->db2->where('c_orderline_id',$id)->get('f_web_po_detail')->result()[0];
		$data->kst_invoicevendor = $_POST['inv'];
		$po_header = $this->db->where('c_order_id',$data->c_order_id)->get('po_header')->num_rows();
		if($po_header == 0){
			$header = $this->db2->where('c_order_id',$data->c_order_id)->get('f_web_po_header')->result()[0];
			$insert_header = $this->db->insert('po_header',$header);
		}
		$po_detail = $this->db->where('c_orderline_id',$data->c_orderline_id)->get('po_detail')->num_rows();
		if($po_detail == 0){
			$this->db->insert('po_detail',$data);
		}else{
			$this->db->where('c_orderline_id',$data->c_orderline_id)->update('po_detail',$data);
		}
	}
	function input_inv_($id){
		$data['kst_invoicevendor'] = $_POST['inv'];
		$this->db->where('po_detail_id',$id)->update('po_detail',$data);
	}
	function input_resi($id){
		$data = $this->db2->where('c_orderline_id',$id)->get('f_web_po_detail')->result()[0];
		$data->kst_resi = $_POST['resi'];
		$po_header = $this->db->where('c_order_id',$data->c_order_id)->get('po_header')->num_rows();
		if($po_header == 0){
			$header = $this->db2->where('c_order_id',$data->c_order_id)->get('f_web_po_header')->result()[0];
			$insert_header = $this->db->insert('po_header',$header);
		}
		$po_detail = $this->db->where('c_orderline_id',$data->c_orderline_id)->get('po_detail')->num_rows();
		if($po_detail == 0){
			$this->db->insert('po_detail',$data);
		}else{
			$this->db->where('c_orderline_id',$data->c_orderline_id)->update('po_detail',$data);
		}
	}
	function input_resi_($id){
		$data['kst_resi'] = $_POST['resi'];
		$this->db->where('po_detail_id',$id)->update('po_detail',$data);
	}

	function detail($id=0){
		$a = $this->db->where('po_detail_id',$id)->get('m_material');
		if($a->num_rows() > 0){
		?>
		<table class="table table-striped table-bordered">
			<thead class='bg-green'>
				<th class="text-center">#</th>
				<th>ROLL NUM</th>
				<th class="text-right">QTY</th>
				<th>UOM</th>
				<th>BATCH</th>
			</thead>
			<tbody>
			<?php
			$nomor=1;
			foreach($a->result() as $b){
			?>
				<tr>
					<td class="text-center"><?=$nomor++;?></td>
					<td><?=$b->nomor_roll;?></td>
					<td class="text-right"><?=$b->qty;?></td>
					<td><?=$b->uomsymbol;?></td>
					<td><?=$b->batch_number;?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<?php
		}else{
			echo "<h3>No Material</h3>";
		}
	}
	function add_pl($id=0){
		$this->db->where('master',1);
		$this->db->where('po_detail_id',$id);
		$a = $this->db->get('po_detail');
		foreach($a->result() as $b){
			$b->master 			= 2;
			$b->no_packinglist  = NULL;
			$b->po_detail_id 	= 1;
			$b->qty_carton 		= NULL;
			$b->foc 	 		= NULL;
			$this->db->insert('po_detail',$b);
		}
		redirect(base_url('data/po_detail/'.$b->c_order_id));
	}
	function complete(){
		print_r($_GET);
	}
	function new_pl(){
		$data['title_page'] = "PACKING LIST";
		$data['desc_page']	= "Create New";
		$data['content']	= "data/new_pl";
		$this->load->view('layout',$data);
	}
	function new_pl2(){
		$data['title_page'] = "PACKING LIST";
		$data['desc_page']	= "Create New";
		$data['content']	= "data/new_pl2";
		$this->load->view('layout',$data);
	}
	function show_line(){
		$this->load->view('supplier/data/pl_itemlist',$_POST);
	}
	function show_line_awb(){
		$this->load->view('supplier/data/awb_detail',$_POST);
	}	
	//DETAIL PACKING LIST
	function pl_list(){
		$data['title_page'] = "PACKING LIST";
		$data['desc_page']	= "All";
		$data['content']	= "data/detail/pl_list";
		$this->load->view('layout',$data);
	}
	function pl_detail(){
		$this->load->view('supplier/data/detail/pl_itemdetail',$_POST);
	}
	function up_pl_qc(){
		$file = $_FILES['file'];
		$nama = substr(md5(date('Y-m-d H:i:s').'KhaMIMNurhuda'),0,10).'-'.$file['name'];
		$data = $_POST;
		$data['file'] = $nama;
		$a = $this->db->insert('packing_list_qc',$data);
		if($a)
			move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/file/qc/'.$nama);
		redirect(base_url('data/pl_list'));
	}
	function report_status_po_sum_acc(){
		$data['title_page'] = "REPORT";
		$data['desc_page']	= "Status PO Summary";
		$data['content']	= "report/status_po_sum_acc";
		$this->load->view('layout',$data);
	}
	function report_status_po_sum(){
		$data['title_page'] = "REPORT";
		$data['desc_page']	= "Status PO Summary";
		$data['content']	= "report/status_po_sum";
		$this->load->view('layout',$data);
	}
	function delete_pl_list(){
		$this->db->where('po_detail_id',$_GET['po_detail_id']);
		$this->db->update('po_detail',array('isactive'=>'false'));
		redirect (base_url('data/pl_list'));
	}

	function isactive(){
		$this->db->where('c_bpartner_id',$this->session->userdata('user_id'));
		$this->db->where('no_packinglist',$_GET['no_packinglist']);
		$this->db->where('kst_invoicevendor',$_GET['kst_invoicevendor']);
		$this->db->update('po_detail',array('isactive'=>'false'));
		redirect(base_url('data/pl_list'));
	}

	function lock(){
		$this->db->where('no_packinglist',$_GET['no_packinglist']);
		$this->db->where('kst_invoicevendor',$_GET['kst_invoicevendor']);
		$this->db->update('po_detail',array('is_locked'=>'true'));

		redirect(base_url('data/pl_list'));
	}

	function unlock(){
		$this->db->where('no_packinglist',$_GET['no_packinglist']);
		$this->db->update('po_detail',array('is_locked'=>'false'));

		redirect(base_url('data/pl_list'));
	}

	function edit_header(){
			$this->load->view('supplier/data/edit/edit_header');
	}
	function edit_header_submit(){
		$this->db->where($_POST['before'])->update('po_detail',$_POST['after']);
		unset($_POST['after']['kst_etddate'], $_POST['after']['kst_etadate'], $_POST['after']['is_edited']);


		$this->db->where($_POST['before'])->update('packing_list_qc',$_POST['after']);
		redirect(base_url('data/pl_list'));
	}
	function edit_pl_list(){
		$this->load->view('supplier/data/edit/edit_detail');
	}
	function edit_detail_submit(){
		$this->db->where($_POST['where'])->update('po_detail',$_POST['after']);
		redirect(base_url('data/pl_list'));
	}
	function download_qc_check(){
		if($_GET['token'] == $this->session->userdata('session_id')){
			unset($_GET['token']);
			echo "<pre>";
			$this->db->where($_GET);
			$a = $this->db->get('packing_list_qc');
			header("Location:".base_url('file/qc/'.$a->result()[0]->file));
		}else{
			echo "Session expired, go back and refresh the page";
		}
	}
	function update_material(){
		$this->db->where('po_detail_id',$_POST['po_detail_id'])->delete('m_material');
		$this->db->where('po_detail_id',$_POST['po_detail_id'])->update('po_detail',array('foc'=>$_POST['foc']));
		$id = $_POST['po_detail_id'];
		$data = $_POST;
		$this->upload_pl_fb($id,$_FILES['file']);
		redirect(base_url('data/pl_list'));
	}
	function create_dp_po(){
		$d = $this->db2->where('c_orderline_id',$_POST['c_orderline_id'])->get('f_web_po_detail')->result()[0];
		$data = $_POST;
		$data['c_order_id'] 	= $d->c_order_id;
		$data['c_bpartner_id'] 	= $d->c_bpartner_id;
		$this->db->insert('m_date_promised',$data);
		echo 1;
	}
	function create_dp_po_all(){
		$data = $_POST;
		$c_orderline = explode(';', $data['c_orderline_id']);
		unset($c_orderline[sizeof($c_orderline)-1], $data['c_orderline_id']);
		foreach($c_orderline as $a => $b){
			$d = $this->db2->where('c_orderline_id',$b)->get('f_web_po_detail')->result()[0];
			$data['c_order_id'] 	= $d->c_order_id;
			$data['c_bpartner_id'] 	= $d->c_bpartner_id;
			$data['c_orderline_id'] 	= $d->c_orderline_id;
			$this->db->insert('m_date_promised',$data);
		}
		redirect('data/po_detail/'.$d->c_order_id);
	}
	function print_pl(){
		$this->load->view('supplier/report/packing_list');
	}
	function po_download(){
        $file = $this->db->where('c_order_id',$_GET['id'])->limit(1)->order_by('created_date','DESC')->get('m_po_file')->result()[0]->file_name;
        header('location:'.base_url('file/po/'.$file));
    }
    function pl_list_today(){
    	$data['title_page'] = "PACKING LIST";
		$data['desc_page']	= "TODAY";
		$data['content']	= "data/detail/pl_list_today";
		$this->load->view('layout',$data);
    }
    //Document PO Per PO BUYER
    function doc_po(){
    	$this->load->view('document/po');
    }
    //Document PO Per Delivery Date
    function doc_po_delivery(){
    	$this->load->view('document/po_per_deliverydate');
    }
    function download_excel_po(){
    	$this->load->view('supplier/report/download_excel_po');
    }
    function download_excel_po_today(){
    	$this->load->view('supplier/report/download_excel_po_today');
    }
    //View PO Per PO BUYER
    function po_view(){
		$this->load->view('supplier/document/po_view');
    }
    //View PO Per DELIVERY DATE
    function po_view_deliverydate(){
		$this->load->view('supplier/document/po_view_deliverydate');
    }
    function po_file_download(){
    	print_r($_GET);
    	$file = $this->db->order_by('created_date','DESC')->limit(1)->where('status','t')->get('m_po_file_additional')->result()[0]->file_name;
    	header('location:'.base_url('file/additional/'.$file));
    }
    function list_file(){
    	$this->load->view('supplier/data/detail/po_file_add');
    }
    function download_po_file(){
    	$file = $this->db->where($_GET)->get('m_po_file_additional')->result()[0]->file_name;
    	header('location:'.base_url('file/additional/'.$file));
    }
    function po_today(){
 		$data['title_page'] = "PURCHASE ORDER";
		$data['desc_page']	= "ACTIVED TODAY";
		$data['content']	= "data/po_today";
		$this->load->view('layout',$data);
    }
    function orderform_thread(){
        $this->load->view('document/orderform_thread');
    }
    function orderform_zipper(){
        $this->load->view('document/orderform_zipper');
    }
    function upload_pl_new(){
    	$data = $_FILES['file'];
    	include $_SERVER["DOCUMENT_ROOT"].'/library/Classes/PHPExcel/IOFactory.php';
			$path = $_SERVER["DOCUMENT_ROOT"]."/file/";
			if($data["type"] != 'application/kset' && 
			   $data["type"] != 'application/vnd.ms-excel' && 
			   $data["type"] != 'application/xls' && 
			   $data["type"] != 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' && 
			   $data["type"] != 'application/ms-excel'){
				echo "<br><div class='alert alert-danger text-center'>File extention is not support, make sure that the type is <b>.xls</b></div>";
			}else{
				$datas 			= move_uploaded_file($data["tmp_name"], $path.$data['name']);
				$inputFileName 	= $path.$data['name'];
				$objPHPExcel 	= PHPExcel_IOFactory::load($inputFileName);
				$sheetCount 	= $objPHPExcel->getSheetCount();
				$sheet 			= $objPHPExcel->getSheetNames();
				$sheetData 		= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
				foreach($sheetData as $a => $b){
					if($a > 1){
						$erp = $this->db2->where('c_orderline_id',$b['A'])->get('f_web_po_detail');
						if($erp->num_rows() > 0){
							$erps = $erp->result()[0];
							$erps->no_packinglist 	= $b['F'];
							$erps->qty_carton		= $b['J'];
							$erps->barcode_id		= $b['I'];
							$erps->kst_etadate		= $b['H'];
							$erps->kst_etddate		= $b['G'];
							$erps->kst_etddate		= $b['G'];
							$erps->qty_upload		= $b['E'];
							$erps->kst_invoicevendor= $b['B'];
							$excel[] = $erps;
						}else{
							$excel[] = array();
						}
					}
				}
				echo "<br><table class='table table-bordered'>";
				echo "<tr class='bg-green'><th>c_orderline_id</th><th>Product</th><th class='text-center'>Status</th></tr>";
				foreach($excel as $a => $b){
					if(sizeof($b) != 0)
						$insert = $this->insert_detail(preg_replace('/\s+/', '', $b));
					else
						$insert = 'Product not found';
		
					$this->table_status($sheetData[$a+2]['A'],$b,$insert);
				}
				echo "</table>";
			}
    }
    private function table_status($id,$data,$status=0){
    	if(sizeof($data) == 0){
    		echo "<tr class='bg-danger'><td>".$id."</td><td colspan='2'>".$status."</td></tr>";
    	}else{
    		echo "<tr class='bg-success'>";
    		echo "<td>".$data->c_orderline_id."</td>";
    		echo "<td>".$data->desc_product."</td>";
    		echo "<td class='text-center'><b>".$status."</b></td>";
    		echo "</tr>";
    	}
    }
    private function table_status_dp($id,$data,$status=0){
    	if(sizeof($data) == 0){
    		echo "<tr class='bg-danger'><td>".$id."</td><td colspan='2'>".$status."</td></tr>";
    	}else{
    		echo "<tr class='bg-success'>";
    		echo "<td class='text-center'>".$data->documentno."</td>";
    		// echo "<td>".$data->c_orderline_id."</td>";
    		echo "<td class='text-center'>".$data->date_promised."</td>";

    		echo "<td class='text-center'><b>".$status."</b></td>";
    		echo "</tr>";
    	}
    }
    private function insert_header($data){
    	$po_header = $this->db->where('c_order_id',$data->c_order_id)->get('po_header');
		if($po_header->num_rows() == 0){
			$aa = $this->db2->where('c_order_id',$data->c_order_id)->get('f_web_po_header')->result()[0];
			$this->db->insert('po_header',$aa);
		}
    }
    private function insert_detail($data){
    	$this->insert_header($data);
    	$where['no_packinglist'] = $data->no_packinglist;
    	$where['c_orderline_id'] = $data->c_orderline_id;
    	$where['kst_invoicevendor'] = $data->kst_invoicevendor;
    	$cek = $this->db->where($where)->get('po_detail');
    	if($cek->num_rows() == 0){
    		$this->db->insert('po_detail',$data);
    		return "Success!";
    	}else{
    		return "Already Exist";
    	}
    }
    private function copy_line($corderline=0){
		$a = $this->db2->where('c_orderline_id',$corderline)->get('f_web_po_detail_line');
		foreach($a->result() as $b){
			unset($b->qty,$b->documentno,$b->c_order_id, $b->m_product_category_value_fp, $b->componentvalue,$b->name);
			$cek = $this->db->where('c_orderline_id',$corderline)->where('poreference',$b->poreference)->get('po_detailline')->num_rows();
			if($cek == 0){
				$this->db->insert('po_detailline',$b);
				return 1;
			}else{
				return 2;
			}
		}
	}
	private function insert_detail_dp($data){
    	$input['c_order_id'] = $data->c_order_id;
    	$input['c_orderline_id'] = $data->c_orderline_id;
    	$input['c_bpartner_id'] = $data->c_bpartner_id;
    	$input['date_promised'] = $data->date_promised;

    	$where['c_order_id'] = $data->c_order_id;
    	$where['c_orderline_id'] = $data->c_orderline_id;
    	$where['c_bpartner_id'] = $data->c_bpartner_id;
    	$where['date_promised'] = $data->date_promised;
    	$cek = $this->db->where($where)->get('m_date_promised');
    	if($cek->num_rows() == 0){

    		$this->db->insert('m_date_promised',$input);
    		return "Success!";
    	}else{
    		return "Already Exist";
    	}
    }
	// -------------------------------------------------------------------------------------------------
	function upload_dp_new(){
    	$data = $_FILES['file'];
    	include $_SERVER["DOCUMENT_ROOT"].'/library/Classes/PHPExcel/IOFactory.php';
			$path = $_SERVER["DOCUMENT_ROOT"]."/file/dp/";
			if($data["type"] != 'application/kset' && 
			   $data["type"] != 'application/vnd.ms-excel' && 
			   $data["type"] != 'application/xls' && 
			   $data["type"] != 'application/xlsx' && //tambahan biar bisa xlsx
			   $data["type"] != 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' && 
			   $data["type"] != 'application/ms-excel'){
				echo "<br><div class='alert alert-danger text-center'>File extention is not support, make sure that the type is <b>.xls</b></div>";
			}else{
				$datas 			= move_uploaded_file($data["tmp_name"], $path.$data['name']);
				$inputFileName 	= $path.$data['name'];
				$objPHPExcel 	= PHPExcel_IOFactory::load($inputFileName);
				$sheetCount 	= $objPHPExcel->getSheetCount();
				$sheet 			= $objPHPExcel->getSheetNames();
				$sheetData 		= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
				foreach($sheetData as $a => $b){
					if($a > 1){
						$udp = $this->db2->where('c_orderline_id',$b['B'])->get('f_web_po_detail');
						if($udp->num_rows() > 0){
							$x = $udp->result()[0];
							$x->c_order_id 		= $b['A'];
							$x->c_orderline_id 	= $b['B'];
							$x->c_bpartner_id	= $b['C'];
							$x->date_promised	= $b['D'];
							$excel[] = $x;
						}else{
							$excel[] = array();
						}						
					}
					//var_dump($sheetData);

					
				}
				echo "<br><table class='table table-bordered'>";
				echo "<tr class='bg-green'><th class='text-center'>PO Number</th><th class='text-center'>Date Promised</th><th class='text-center'>Status</th></tr>";
				
				foreach($excel as $a => $b){

					if(sizeof($b) != 0)
						$insert = $this->insert_detail_dp($b);
						
					else
						$insert = 'There is no record found!';
		
					$this->table_status_dp($sheetData[$a+2]['A'],$b,$insert);
					// echo "<pre>";
					// print_r($excel);
				}	
				echo "</table>";
			}
    }
    function awb(){
    	$data['title_page'] = "AIR WAY BILL";
		$data['desc_page']	= "Create New";
		$data['content']	= "data/new_awb";
		$this->load->view('layout',$data);
    }
    public function activepo(){
		$data['title_page'] = "PURCHASE ORDER";
		$data['desc_page']	= "ACTIVE PO";
		$data['content']	= "data/activepo";
		$this->load->view('layout',$data);	
	}
	function activepo_view(){
		$data['title_page'] = "PURCHASE ORDER";
		$data['desc_page']	= "ACTIVE PO";
		$data['content']	= "data/activepo_view";
		$this->load->view('layout',$data);		
	}
	public function filter_dp(){
		$data['title_page'] = "PURCHASE ORDER";
		$data['desc_page']	= "Download Template Date Promised";
		$data['content']	= "data/filter_dp";
		$this->load->view('layout',$data);	
	}
	function filter_dp_view(){
		$data['title_page'] = "PURCHASE ORDER";
		$data['desc_page']	= "ACTIVE PO";
		$data['content']	= "data/filter_dp_view";
		$this->load->view('layout',$data);		
	}
	function xls_filter_dp(){
		$this->load->view('supplier/report/xls_filter_dp');
	}
	public function down_temp_pl(){
		$data['title_page'] = "PURCHASE ORDER";
		$data['desc_page']	= "DOWNLOAD TEMPLATE UPLOAD PACKINGLIST";
		$data['content']	= "data/detail/down_temp_pl";
		$this->load->view('layout',$data);	
	}
	function xls_template_pl(){
		$this->load->view('supplier/report/xls_template_pl');
	}
	public function accordion_menu(){
		$data['title_page'] = "PURCHASE ORDER";
		$data['desc_page']	= "Accordion Menu";
		$data['content']	= "data/detail/accordion_menu";
		$this->load->view('layout',$data);	
	}
} 