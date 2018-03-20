<?php
$user = $this->session->userdata('user_id');
$this->db2->where('c_bpartner_id',$user);
$this->db2->where('c_order_id',$c_order);

$users = $this->db2->get('f_web_po_detail');
if($users->num_rows() != 0){
	if($users->result()[0]->type_po == 1){
		$this->load->view($this->session->userdata('status').'/data/po_detail_fb',array('data' => $users->result()));
	}else{
		$this->load->view($this->session->userdata('status').'/data/po_detail_acc',array('data' => $users->result(), 'c_order' => $c_order));
	}
}else{
	echo "<div class='alert alert-info'>No data found, <b><u><a href='".base_url('data/po')."'>Please go back</a></u></b></div>";
}
?>