<?php
$role = $this->session->userdata('role');
?>
<section class="sidebar">
    <ul class="sidebar-menu">
        <li class="header" align="center"><img height="55px" src="<?php echo base_url();?>/assets/img/aoi-logo-min.jpg"></li>
        <?php
        if($this->session->userdata('status') == 'supplier'){
        ?>
        <li class="header">PURCHASE ORDER</li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-sign-in"></i> <span>Data</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="<?php echo base_url('data/po');?>"><i class="fa fa-file-o"></i> Active PO</a></li>
                <li><a href="<?php echo base_url('data/activepo');?>"><i class="fa fa-file-o"></i> Testing Active PO</a></li>
                <li><a href="<?php echo base_url('data/filter_dp');?>"><i class="fa fa-file-text-o"></i> Date Promised</a></li>
            </ul>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-truck"></i> <span>Delivery</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
               <!--  <li hidden><a href="<?php echo base_url('data/new_pl');?>"><i class="fa fa-plus"></i> Create Packing List</a></li> -->
                <li><a href="<?php echo base_url('data/new_pl2');?>"><i class="fa fa-plus"></i> Create Packing List</a></li>
                <li><a href="<?php echo base_url('data/down_temp_pl');?>"><i class="fa fa-download"></i> Download Template Upload PL</a></li>
                <li><a href="<?php echo base_url('data/pl_list');?>"><i class="fa fa-file-text-o"></i> Packing List</a></li>
                <li><a href="<?php echo base_url('data/accordion_menu');?>"><i class="fa fa-file-text-o"></i> Accordion</a></li>
                <!-- <li><a href="<?php echo base_url('data/awb');?>"><i class="fa fa-paper-plane"></i> Input AWB</a></li> -->
            </ul>
        </li>


        <li class="treeview">
            <a href="#">
                <i class="fa fa-clone"></i> <span>Report</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="<?php echo base_url('data/report_status_po_sum');?>"><i class="fa fa-comments-o"></i> Report Outstanding PO Fabric</a></li>
            </ul>
            <ul class="treeview-menu">
                <li><a href="<?php echo base_url('data/report_status_po_sum_acc');?>"><i class="fa fa-comments-o"></i> Report Outstanding PO Acc</a></li>
                
            </ul>
        </li>


        <?php if($this->session->userdata('user_id') == '1001120'){ ?>
        <?php 
        }
        }if($role == 5){?>
            <li class="treeview">
            <a href="#">
                <i class="fa fa-file-text-o"></i> <span>Report AWB</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="<?php echo base_url('admin/report_awb');?>"><i class="fa fa-paper-plane"></i> Download Report AWB</a></li>
            </ul>
        </li>
       <?php }else{
        ?>

        <?php if($role == 4){ ?>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-sign-in"></i> <span>Receive</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="<?php echo base_url('receive');?>"><i class="fa fa-qrcode"></i> Scan Material</a></li>
                <li><a href="<?php echo base_url('receive/material');?>"><i class="fa fa-list"></i> Received Material</a></li>
            </ul>
        </li>
        <?php 
        } 
        if($role == 3 || $role == 2 || $role == 1){
        ?>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-file-text-o"></i> <span>Purchase Order</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <!-- <ul class="treeview-menu">
                <li><a href="<?php echo base_url('admin/po');?>"><i class="fa fa-qrcode"></i> List PO</a></li>
            </ul> -->
            <ul class="treeview-menu">
                <li><a href="<?php echo base_url('admin/po2');?>"><i class="fa fa-qrcode"></i> List PO</a></li>
            </ul>
        </li>
<!-- --------------------------Testing------------------------------------------------------ -->
        <li class="treeview">
            <a href="#">
                <i class="fa fa-file-text-o"></i> <span>Testing Purchase Order</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="<?php echo base_url('admin/testing1');?>"><i class="fa fa-qrcode"></i> List PO</a></li>
            </ul>
        </li>
<!-- --------------------------Testing------------------------------------------------------ -->

        <li class="treeview">
            <a href="#">
                <i class="fa fa-sign-in"></i> <span>Report</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-download"></i> <span>Accessories</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                       <li><a href="<?php echo base_url('admin/report_imported_pl_acc');?>"><i class="fa fa-qrcode"></i> Report Imported PL Acc</a></li>
                       <li><a href="<?php echo base_url('admin/report_placc');?>"><i class="fa fa-download"></i>Monitoring Kedatangan</a></li>
                    </ul>
                </li>
                
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-download"></i> <span>Fabric</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo base_url('admin/report_imported_pl_fb');?>"><i class="fa fa-qrcode"></i> Report Imported PL Fabric</a></li>
                        <li><a href="<?php echo base_url('admin/report_plfbr');?>"><i class="fa fa-download"></i> Monitoring Kedatangan</a></li>
                       
                    </ul>
                </li>
                <li>
                    <a href="<?php echo base_url('admin/report_confirmed_date');?>"><i class="fa fa-qrcode"></i> Report Confirmed Date</a></li>
                </li>
                <li>
                    <a href="<?php echo base_url('admin/report_awb');?>"><i class="fa fa-paper-plane"></i> Report AWB</a></li>
                </li>
                <!--li><a href="<?php echo base_url('admin/report_imported_pl_fb');?>"><i class="fa fa-qrcode"></i> Report Imported PL Fabric</a></li>
                <li><a href="<?php echo base_url('admin/report_imported_pl_acc');?>"><i class="fa fa-qrcode"></i> Report Imported PL Acc</a></li>
                <li><a href="<?php echo base_url('admin/download_report');?>"><i class="fa fa-qrcode"></i> Download Report</a></li-->
               
            
                
            </ul>
        </li>

        <?php } 
    } ?>
        <li class="header">USER</li>
        <li><a href="<?=base_url('user/setting');?>"><i class="fa fa-gears"></i> <span>Setting</span></a></li>
        <li><a href="<?=base_url('user/logout');?>"><i class="fa fa-power-off"></i> <span>Logout</span></a></li>
        <li class="header">ONLINE : 
        <?php
            $last = strtotime(date('Y-m-d H:i:s'))-600;
            echo $this->db->distinct()->select('ip_address')->where('last_activity >',$last)->get('ci_sessions')->num_rows().' Users';
        ?>
        </li>
    </ul>
    <br>
    <!--center><img src="<?=base_url('assets/comodo.png')?>"></center-->
</section>