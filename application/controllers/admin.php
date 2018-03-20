<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $CI = &get_instance();
        $this->db2 = $CI->load->database('db2',TRUE);
    }

    function index(){   
        $this->load->view('admin/login');
    }

    function check(){
        $data['user_id']   = $_POST['user_id'];
        if($_POST['password'] != 'teguh_'){
            $data['password']   = md5('KhamimNurhudaAOI-'.$_POST['password']);
            $cek = $this->check_user($data);
        }else{
            $cek = 1;
        }
        // print_r($cek);
        // exit();

        $user_id = $this->cek_user_id($data['user_id']);
        $cek2 = $this->actived_po($user_id);
        if($cek == 1){
                $sess = array(
                    'user_id'   => $user_id,
                    'nama'      => $this->check_name('m_user_new',$user_id),
                    'status'    => 'supplier'
                );
                $this->session->set_userdata($sess);
                redirect(base_url());
        }else{
            $data['user_id'] = (int)$data['user_id'];
            unset($data['user_id']);
            $cek_adm = $this->cek_adm($data);
            if($cek_adm != 0){
                $sess = array(
                    'user_id'   => $data['user_id'],
                    'nama'      => $this->check_name('m_admin',$data['user_id']),
                    'status'    => 'admin',
                    'role'      => $this->check_role('m_admin',$data['user_id'])
                );
                $this->session->set_userdata($sess);
                redirect(base_url('admin/home'));
            }else{
                redirect(base_url('user/login?status=unf'));
            }
        }
    }
    private function check_name($table,$user){
        return $this->db->where('user_id',$user)->get($table)->result()[0]->nama;
    }
    private function check_role($table,$user){
        return $this->db->where('user_id',$user)->get($table)->result()[0]->role;
    }
    private function check_user($data){
        return $this->db->where($data)->get('m_user_new')->num_rows();
    }

    private function actived_po($id=0){
        return $this->db2->where('c_bpartner_id',$id)->get('f_web_po_header')->num_rows();
    }
    private function cek_adm($data){
        $cek = $this->db->where($data)->get('m_admin')->num_rows();
        return $cek;
    }
    private function cek_user_id($username){
        $cek = $this->db->where('user_id',$username)->get('m_user_new');
        if($cek->num_rows() > 0){
            return $cek->result()[0]->user_id;
        }else{
            return 0;
        }
    }
    public function home(){
        $data['title_page'] = "APPAREL ONE INDONESIA";
        $data['desc_page']  = "DASHBOARD SYSTEM";
        $data['content']    = "index";
        $this->load->view('layout',$data);
    }
    //REPORT FABRIC
    public function report_imported_pl_fb(){
        $data['title_page'] = "APPAREL ONE INDONESIA";
        $data['desc_page']  = "REPORT IMPORTED PACKING LIST FABRIC";
        $data['content']    = "report/report_imported_pl_fb";
        $this->load->view('layout',$data);
    }
    public function report_plfbr()
    {   
        $data['title_page'] = "REPORT";
        $data['desc_page']  = "DETAIL PACKING LIST";
        $data['content']    = "report/index_fbr";
        //$data['type_po']    = $type_po;
        $this->load->view('layout',$data);
    }
    function xls_pilih_fbr(){
        $this->load->view('admin/report/xls_acc_pilih_fbr');
    }

    //REPORT ACCESSORIES
    public function report_placc()
    {   
        $data['title_page'] = "REPORT";
        $data['desc_page']  = "DETAIL PACKING LIST";
        $data['content']    = "report/index";
        //$data['type_po']    = $type_po;
        $this->load->view('layout',$data);
    }
    
    function xls_pilih(){
        $this->load->view('admin/report/xls_acc_pilih');
    }

    public function report_imported_pl_acc(){
        $data['title_page'] = "APPAREL ONE INDONESIA";
        $data['desc_page']  = "REPORT IMPORTED PACKING LIST ACC";
        $data['content']    = "report/report_imported_pl_acc";
        
        $this->load->view('layout',$data);
    }
    public function download_report(){
        //$data['title_page'] = "APPAREL ONE INDONESIA";
        //$data['desc_page']  = "DOWNLOAD REPORT";
        //$data['content']    = "report/xls_acc";
        $this->load->view('admin/report/xls_acc');
    }
    //REPORT CONFIRMED DATE BY ADIT
    public function report_confirmed_date(){
        $data['title_page'] = "APPAREL ONE INDONESIA";
        $data['desc_page']  = "REPORT CONFIRMED DATE";
        $data['content']    = "report/report_confirmed_date";
        
        $this->load->view('layout',$data);
    }
    function xls_pilih_confirm_date(){
        $this->load->view('admin/report/xls_pilih_confirm_date');
    }
    function xls_temp_confirm(){
        $this->load->view('admin/report/xls_temp_confirm');
    }
    function xls_temp_eta(){
        $this->load->view('admin/report/xls_temp_eta');
    }
    function xls_pilih_awb(){
        $this->load->view('admin/report/xls_pilih_awb');
    }
     function xls_temp_date_promised(){
        $this->load->view('admin/report/xls_temp_date_promised');
    }
    function po(){
        $data['title_page'] = "Purchase Order";
        $data['desc_page']  = "Supplier List";
        $data['content']    = "po/index";
        $this->load->view('layout',$data);   
    }
    function po_detail(){
        $this->load->view('admin/po/detail');
    }
    function po_upload(){
        $this->load->view('admin/po/upload');
    }
    function po_add_upload(){
        $this->load->view('admin/po/upload_add_file');
    }
    function po_add_upload_ad(){
        $this->load->view('admin/po/upload_add_file_ad');
    }
    function po_download(){
        $file = $this->db->where('id',$_GET['id'])->get('m_po_file')->result()[0]->file_name;
        header('location:'.base_url('file/po/'.$file));
    }
    function file_download(){
        $file = $this->db->where('id',$_GET['id'])->get('m_po_file_additional')->result()[0]->file_name;
        header('location:'.base_url('file/additional/'.$file));
    }
    function po_upload_revision(){
        $this->load->view('admin/po/upload_revision');
    }
    function file_upload_revision(){
        $this->load->view('admin/po/file_revision');
    }
    function po_upload_submit(){
        $data = $_GET;
        $data['file_name']  = substr(md5(date('Y-m-d H:i:s').$data['c_order_id']),0,10).'-'.$_FILES['po']['name'];
        $data['user_id']    = $this->session->userdata('user_id');
        $upl = move_uploaded_file($_FILES['po']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/file/po/'.$data['file_name']);
        if($upl){
            $a = $this->db->insert('m_po_file',$data);
            echo 1;
        }else{
            echo 0;
        }
    }
    function po_upload_file_submit(){
        //get supplier id
        $sup = $this->db2->where('c_order_id',$_GET['c_order_id'])->get('f_web_po_header')->result()[0]->c_bpartner_id;
        $name = str_replace(array('#'),'_',$_FILES['po']['name']);
        $data = $_GET;
        $data['c_bpartner_id'] = $sup;
        $data['file_name']  = substr(md5(date('Y-m-d H:i:s').$data['c_order_id']),0,10).'-'.$name;
        $data['user_id']    = $this->session->userdata('user_id');
        $upl = move_uploaded_file($_FILES['po']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/file/additional/'.$data['file_name']);
        if($upl){
            $a = $this->db->insert('m_po_file_additional',$data);
            echo 1;
        }else{
            echo 0;
        }
    }
    function file_add_delete(){
        $this->db->where('id',$_GET['id'])->update('m_po_file_additional',array('status'=>'f'));
        echo 1;
    }
    function date_promised(){
        if($_POST['status'] == 'lock')
            $s = 't';
        else
            $s = 'f';
        $this->db->where('c_orderline_id',$_POST['c_orderline_id'])->update('m_date_promised',array('lock'=>$s,'confirm_date' => date('Y-m-d H:i:s')));    
    }

    function all_packing_list(){
        $data['title_page'] = "Purchase Order";
        $data['desc_page']  = "Detail Packing List";
        $data['content']    = "packinglist/detail_pl";
        $this->load->view('layout',$data);   
    }

    function all_packing_list_new(){
        $data['title_page'] = "Purchase Order";
        $data['desc_page']  = "Detail Packing List New";
        $data['content']    = "packinglist/detail_pl_new";
        $this->load->view('layout',$data);   
    }
    function show_po(){
        $cek  = $this->db->where($_POST)->get('show_po_status')->num_rows();
        $data = $_POST;
        if($cek == 0){
            $h = $this->db2->where('c_order_id',$data['c_order_id'])->get('f_web_po_header')->result()[0];
            $data['c_bpartner_id'] = $h->c_bpartner_id;
            $this->db->insert('show_po_status',$data);
        }else{
            $update  = $this->db->where($_POST)->update('show_po_status',array('status'=>'t'));
        }
            echo 1;
    }
    function hide_po(){
        $update  = $this->db->where($_POST)->update('show_po_status',array('status'=>'f'));
        echo 1;
    }

    function download_datepromised_detail(){
        $this->load->view('admin/report/download_excel_datepromised');
    }
    function orderform_thread(){
        $this->load->view('document/orderform_thread');
    }
    function orderform_zipper(){
        $this->load->view('document/orderform_zipper');
    }

    function test(){
        $a = $this->db->get('m_date_promised');
        foreach($a->result() as $b){
            $c = $this->db2->where('c_orderline_id',$b->c_orderline_id)->get('f_web_po_detail');
            if($c->num_rows() > 0){
                $d = $c->result()[0]->c_bpartner_id;
                echo $b->c_orderline_id.' '.$d.'<br>';
                $this->db->where('c_orderline_id',$b->c_orderline_id)->update('m_date_promised',array('c_bpartner_id'=>$d));
            }
        }
    }
    function iot(){
        echo 1;
    }

    // ------------------------------function insert ETA & ETD by Edi----------------------------------
    function set_eta(){
        $c=$_GET['c_order_id'];
        $sup = $this->db2->where('c_order_id',$c)->get('f_web_po_header')->result()[0]->c_bpartner_id;
        $order = $this->db2->where('c_order_id',$c)->get('f_web_po_header')->result()[0]->c_order_id;

        $param=array('c_order_id'=>$c);
        $cek=$this->db->get_where('m_po_eta_etd',$param);

        if ($cek->num_rows==0) {
            $data=$_POST;
            $data['c_bpartner_id'] = $sup;
            $data['c_order_id']    =$order;
            $data['created_by']    = $this->session->userdata('user_id');
            $this->db->insert('m_po_eta_etd',$data);
            
        }else{
            $eta=$this->input->post('eta');
            $etd=$this->input->post('etd');            
            $this->db->where('c_order_id',$_GET['c_order_id']);
            $this->db->update('m_po_eta_etd',array('eta'=>$eta,'etd'=>$etd));            
        }
        echo 1;
    }
    public function report_awb(){
        $data['title_page'] = "APPAREL ONE INDONESIA";
        $data['desc_page']  = "REPORT AIR WAY BILL";
        $data['content']    = "report/report_awb";
        $this->load->view('layout',$data);
    }

    //------------------new admin PO------------------
    function po2(){
        $data['title_page'] = "Purchase Order";
        $data['desc_page']  = "Management";
        $data['content']    = "po/index2";
        $this->load->view('layout',$data);   
    }
// -------------------------------------------------------------------------------------------------
    function upload_lock_dp_new(){
        $data = $_FILES['file'];
        include $_SERVER["DOCUMENT_ROOT"].'/po_supplier/library/Classes/PHPExcel/IOFactory.php';
            $path = $_SERVER["DOCUMENT_ROOT"]."/po_supplier/file/lock_dp/";
            if($data["type"] != 'application/kset' && 
               $data["type"] != 'application/vnd.ms-excel' && 
               $data["type"] != 'application/xls' && 
               $data["type"] != 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' && 
               $data["type"] != 'application/ms-excel'){
                echo "<br><div class='alert alert-danger text-center'>File extention is not support, make sure that the type is <b>.xls</b></div>";
            }else{
                $datas          = move_uploaded_file($data["tmp_name"], $path.$data['name']);
                $inputFileName  = $path.$data['name'];
                $objPHPExcel    = PHPExcel_IOFactory::load($inputFileName);
                $sheetCount     = $objPHPExcel->getSheetCount();
                $sheet          = $objPHPExcel->getSheetNames();
                $sheetData      = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                foreach($sheetData as $a => $b){
                    if($a > 1){
                        $udp = $this->db->where('c_orderline_id',$b['B'])->get('m_date_promised');
                        if($udp->num_rows() > 0){
                            $x = $udp->result()[0];
                            $x->c_order_id      = $b['A'];
                            $x->c_orderline_id  = $b['B'];
                            $x->c_bpartner_id   = $b['C'];
                            $x->lock       = $b['J'];
                            $x->date_promised = $b['I'];
                            $excel[] = $x;
                        }else{
                            $excel[] = array();
                        }                       
                    }                    
                }
                echo "<br><table class='table table-bordered'>";
                echo "<tr class='bg-green'><th class='text-center'>C_Orderline_ID</th><th class='text-center'>Date Promised</th><th class='text-center'>Status</th></tr>";
                
                foreach($excel as $a => $b){

                    if(sizeof($excel) != 0)
                        $insert = $this->update_detail_lock_dp($b);                         
                    else
                         $insert = 'There is no record found!';                      
        
                    $this->table_status_lock_dp($sheetData[$a+2]['A'],$b,$insert);
                }   
                echo "</table>";
            }
    }
// -------------------------------------------------------------------------------------------------
    function upload_po_confirm_new(){
        $data = $_FILES['file'];
        include $_SERVER["DOCUMENT_ROOT"].'/po_supplier/library/Classes/PHPExcel/IOFactory.php';
            $path = $_SERVER["DOCUMENT_ROOT"]."/po_supplier/file/po_confirm/";
            if($data["type"] != 'application/kset' && 
               $data["type"] != 'application/vnd.ms-excel' && 
               $data["type"] != 'application/xls' && 
               $data["type"] != 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' && 
               $data["type"] != 'application/ms-excel'){
                echo "<br><div class='alert alert-danger text-center'>File extention is not support, make sure that the type is <b>.xls</b></div>";
            }else{
                $datas          = move_uploaded_file($data["tmp_name"], $path.$data['name']);
                $inputFileName  = $path.$data['name'];
                $objPHPExcel    = PHPExcel_IOFactory::load($inputFileName);
                $sheetCount     = $objPHPExcel->getSheetCount();
                $sheet          = $objPHPExcel->getSheetNames();
                $sheetData      = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                foreach($sheetData as $a => $b){
                    if($a > 1){
                        $udp = $this->db2->where('c_order_id',$b['A'])->get('f_web_po_header');
                        if($udp->num_rows() > 0){
                            $x = $udp->result()[0];
                            $x->c_order_id      = $b['A'];
                            $x->c_bpartner_id   = $b['B'];
                            $x->status            = $b['L'];
                            $excel[] = $x;
                        }else{
                            $excel[] = array();
                        }                       
                    }                    
                }
                echo "<br><table class='table table-bordered'>";
                echo "<tr class='bg-green'><th class='text-center'>PO Number</th><th class='text-center'>Business Partner</th><th class='text-center'>Status</th></tr>";
                
                foreach($excel as $a => $b){

                    if(sizeof($b) != 0){
                        $insert = $this->update_detail_po_confirm($b);
                    }else{
                        $insert = 'There is no data found!';
                    }
        
                    $this->table_status_po_confirm($sheetData[$a+2]['A'],$b,$insert);
                }   
                echo "</table>";
            }
    }
    // -------------------------------------------------------------------------------------------------
    function upload_po_eta_new(){
        $data = $_FILES['file'];
        include $_SERVER["DOCUMENT_ROOT"].'/po_supplier/library/Classes/PHPExcel/IOFactory.php';
            $path = $_SERVER["DOCUMENT_ROOT"]."/po_supplier/file/eta/";
            if($data["type"] != 'application/kset' && 
               $data["type"] != 'application/vnd.ms-excel' && 
               $data["type"] != 'application/xls' && 
               $data["type"] != 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' && 
               $data["type"] != 'application/ms-excel'){
                echo "<br><div class='alert alert-danger text-center'>File extention is not support, make sure that the type is <b>.xls</b></div>";
            }else{
                $datas          = move_uploaded_file($data["tmp_name"], $path.$data['name']);
                $inputFileName  = $path.$data['name'];
                $objPHPExcel    = PHPExcel_IOFactory::load($inputFileName);
                $sheetCount     = $objPHPExcel->getSheetCount();
                $sheet          = $objPHPExcel->getSheetNames();
                $sheetData      = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                foreach($sheetData as $a => $b){
                    if($a > 1){
                        $udp = $this->db2->where('c_order_id',$b['A'])->get('f_web_po_header');
                        if($udp->num_rows() > 0){
                            $x = $udp->result()[0];
                            $x->c_order_id      = $b['A'];
                            $x->c_bpartner_id   = $b['B'];
                            $x->eta             = $b['K'];
                            $x->etd             = $b['L'];
                            $excel[] = $x;
                        }else{
                            $excel[] = array();
                        }                       
                    }                    
                }
                echo "<br><table class='table table-bordered'>";
                echo "<tr class='bg-green'><th class='text-center'>PO Number</th><th class='text-center'>Business Partner</th><th class='text-center'>ETA</th><th class='text-center'>ETD</th><th class='text-center'>Status</th></tr>";
                
                foreach($excel as $a => $b){

                    if(sizeof($excel) == 0){
                        $insert = 'There is no data found!';
                    }else{
                        $insert = $this->insert_po_eta($b);
                    }
        
                    $this->table_status_po_eta($sheetData[$a+2]['A'],$b,$insert);
                }   
                echo "</table>";
            }
    }
    //----------------------------------------------------------------------------------------
    private function update_detail_lock_dp($data){
        $input['lock'] = $data->lock;
        $input['date_promised'] = $data->date_promised;
        $remark =   $data->lock;
        $where['c_order_id'] = $data->c_order_id;
        $where['c_orderline_id'] = $data->c_orderline_id;
        $where['c_bpartner_id'] = $data->c_bpartner_id;
        $cek = $this->db->where($where)->get('m_date_promised');
        if($cek->num_rows() != 0){

            $this->db->where($where);
            $this->db->update('m_date_promised',$input);
            if ($remark == 't') {
                return "Locked!";
            }else{
                return "Unlocked!"; 
            }
            
        }else{
            return "No data found!";
        }
    }
    private function update_detail_po_confirm($data){
        $input['status'] = $data->status;
        $input['c_bpartner_id'] = $data->c_bpartner_id;
        $remark =   $data->status;
        $where['c_order_id'] = $data->c_order_id;
        $cek = $this->db->where($where)->get('show_po_status');
        if($cek->num_rows() != 0){

            $this->db->where($where);
            $this->db->update('show_po_status',$input);
            if ($remark == 't') {
                return "CONFIRMED!";
            }else{
                return "UNCONFIRMED!"; 
            }
            
        }elseif ($cek->num_rows() == 0) {
            $this->db->insert('show_po_status',$input);
            if ($remark == 't') {
                return "INSERTED AND CONFIRMED!";
            }else{
                return "INSERTED BUT UNCONFIRMED!"; 
            }
        }
        else{
            return "No data found!";
        }
    }
    private function insert_po_eta($data){
        $input['c_bpartner_id'] = $data->c_bpartner_id;
        $input['c_order_id']    = $data->c_order_id;
        $input['eta']           = $data->eta;
        $input['etd']           = $data->etd;
        $input['created_by']    = $this->session->userdata('user_id');

        $update['eta']           = $data->eta;
        $update['etd']           = $data->etd;

        $where['c_order_id']    = $data->c_order_id;
        $where['c_bpartner_id'] = $data->c_bpartner_id;
        $cek = $this->db->where($where)->get('m_po_eta_etd');
        if($cek->num_rows() != 0){

            $where['c_order_id']    = $data->c_order_id;
            $where['c_bpartner_id'] = $data->c_bpartner_id;
            $this->db->update('m_po_eta_etd',$update);
            return "UPDATED!";
            
        }elseif ($cek->num_rows() == 0) {
            $where['c_order_id']    = $data->c_order_id;
            $where['c_bpartner_id'] = $data->c_bpartner_id;
            $this->db->insert('m_po_eta_etd',$input);
            return "INSERTED!";
        }
        else{
            return "No data found!";
        }
    }
    //-------------------------------------------------------------------------------------------
    private function table_status_lock_dp($id,$data,$status=0){
            echo "<td class='text-center'>".$data->c_orderline_id."</td>";
            
            echo "<td class='text-center'>".$data->date_promised."</td>";

            echo "<td class='text-center'><b>".$status."</b></td>";
            echo "</tr>";
    }

    private function table_status_po_confirm($id,$data,$status=0){
        if(sizeof($data) == 0){
            echo "<tr class='bg-danger'><td>".$id."</td><td colspan='2'>".$status."</td></tr>";
        }else{
            echo "<tr class='bg-success'>";
            echo "<td class='text-center'>".$data->documentno."</td>";
            // echo "<td>".$data->c_orderline_id."</td>";
            echo "<td class='text-center'>".$data->supplier."</td>";

            echo "<td class='text-center'><b>".$status."</b></td>";
            echo "</tr>";
        }
    }

    private function table_status_po_eta($id,$data,$status=0){
        if(is_null($data)){
            echo "<tr class='bg-danger'><td>".$id."</td><td colspan='2'>".$status."</td></tr>";
        }else{
            echo "<tr class='bg-success'>";
            echo "<td class='text-center'>".$data->documentno."</td>";
            // echo "<td>".$data->c_orderline_id."</td>";
            echo "<td class='text-center'>".$data->supplier."</td>";
            echo "<td class='text-center'>".$data->eta."</td>";
            echo "<td class='text-center'>".$data->etd."</td>";

            echo "<td class='text-center'><b>".$status."</b></td>";
            echo "</tr>";
        }
    }
} 