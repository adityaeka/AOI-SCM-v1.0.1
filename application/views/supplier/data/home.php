<div class="row">
<?php
$this->db->where('user_id',$this->session->userdata('user_id'));
$user = $this->db->get('m_user')->result()[0];

$email = $this->db->where('user_id',$this->session->userdata('user_id'))->where('email !=', '')->get('m_user')->num_rows();
?>
        <div id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-aqua">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" style="text-align: center;">System Reminder</h4>
                    </div>
                    <div class="modal-body">
                        <p>Our system detected no registered mail from your company. Please Register your email.</p>
                        <form action="user/insert_email" method="POST">
                            <div class="form-group">
                                <input type="hidden" name="user_id" value="<?=$user->user_id;?>">
                                <input type="email" name="email" class="form-control email" placeholder="Input your email" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
            if($email == 0) { ?>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#myModal").modal('show');
                    });
                </script>
        <?php } ?>


    <div class="col-sm-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
              <h3><?=$this->db2->select('count(*)')->where('c_bpartner_id',$this->session->userdata('user_id'))->get('f_web_po_header')->result()[0]->count;?></h3>
              <p>Active Purchase Order</p>
            </div>
            <div class="icon">
                <i class="fa fa-money"></i>
            </div>
            <a href="<?=base_url('data/po');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-sm-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
              <h3>
                <?php 
                $count=0;
                $a = $this->db2->select('c_order_id')->where('c_bpartner_id',$this->session->userdata('user_id'))->get('f_web_po_header');
                foreach($a->result() as $b){
                    $show = $this->db->where('c_order_id',$b->c_order_id)->where('status','t')->where('date(created_time)',date('Y-m-d'))->get('show_po_status')->num_rows();
                    if($show !=0 )
                        $count++;
                }
                echo $count;
                ?>  
              </h3>
              <p>Purchase Order Today</p>
            </div>
            <div class="icon">
                <i class="fa fa-plus-circle"></i>
            </div>
            <a href="<?=base_url('data/po_today');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-sm-3 col-xs-6">
        <div class="small-box bg-orange">
            <div class="inner">
              <h3><?=$this->db->distinct()->select('no_packinglist')->where('c_bpartner_id',$this->session->userdata('user_id'))->where('isactive','t')->get('po_detail')->num_rows();?></h3>
              <p>Packing List</p>
            </div>
            <div class="icon">
                <i class="fa fa-file-text-o"></i>
            </div>
            <a href="<?=base_url('data/pl_list');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-sm-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?=$this->db->distinct()->select('no_packinglist')->where('isactive','t')->where('c_bpartner_id',$this->session->userdata('user_id'))->where('date(create_date)',date("Y-m-d"))->get('po_detail')->num_rows();?></h3>
              <p>Packing List Today</p>
            </div>
            <div class="icon">
                <i class="fa fa-plus-circle"></i>
            </div>
            <a href="<?=base_url('data/pl_list_today');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

