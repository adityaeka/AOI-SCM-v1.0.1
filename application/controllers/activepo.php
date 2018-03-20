<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Activepo extends CI_Controller {
 
    function __construct(){
        parent::__construct();
        $this->load->model('Activepo_model');
    }
 
    function index(){
        $this->load->view('activepo_view');
    }
 
    function get_data_user()
    {
        $list = $this->Activepo_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $po) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $po->documentno;
            $row[] = $po->category;
            $row[] = $po->create_po;
 
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Activepo_model->count_all(),
            "recordsFiltered" => $this->Activepo_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }
 
}