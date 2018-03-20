<?php
if($_SERVER['REQUEST_SCHEME'] == 'http' && $_SERVER['HTTP_HOST'] == 'po.aoi.co.id'){
    header('location:https://po.aoi.co.id'.$_SERVER['PATH_INFO']);
}
$this->Addons->nologin();
$user_id = $this->session->userdata('user_id');
$nama    = $this->session->userdata('nama');
$status  = $this->session->userdata('status');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PURCHASE ORDER SYSTEM - PT. APPAREL ONE INDONESIA</title>	
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 
    <link rel="shortcut icon" href="<?php echo base_url();?>/assets/img/aoi-logo-min.jpg">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/wms_aoi.css');?>"> 
    <link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/css/bootstrap.min.css"); ?>">  
    <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css');?>">      
    <link rel="stylesheet" href="<?php echo base_url("assets/dist/css/AdminLTE.min.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/dist/css/skins/_all-skins.min.css");?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/css/wms_aoi.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/plugins/datatables/dataTables.bootstrap.css");?>">
    <script src="<?php echo base_url("assets/plugins/jQuery/jQuery-2.1.4.min.js");?>"></script>
    <script src="<?php echo base_url("assets/bootstrap/js/bootstrap.min.js");?>"></script>
    <script src="<?php echo base_url("assets/plugins/slimScroll/jquery.slimscroll.min.js");?>"></script>
    <script src="<?php echo base_url("assets/plugins/fastclick/fastclick.js");?>"></script>
    <script src="<?php echo base_url("assets/plugins/datatables/dataTables.bootstrap.css");?>"></script>
    <script src="<?php echo base_url("assets/dist/js/app.min.js");?>"></script>
    <script src="<?php echo base_url("assets/plugins/datatables/jquery.dataTables.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/datatables/dataTables.bootstrap.min.js"); ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/bootstrap/css/bootstrap-datepicker.min.css');?>">
    <script type="text/javascript" src="<?=base_url('assets/bootstrap/js/bootstrap-datepicker.min.js');?>"></script>
    <script type="text/javascript">
      $(function(){
          $('.treeview-menu li a[href~="' + location.href + '"]').parent('li').parent('.treeview-menu').parent('li').addClass("active");
          $('li a[href~="' + location.href + '"]').parent('li').addClass("active");
          $( document ).ajaxStart(function() {
              $(".loading").fadeIn();
          }).ajaxStop(function(){
              $(".loading").fadeOut();
          }); 

          $('#datepicker').datepicker({
              format: "yyyy-mm-dd"
          });
          
          $('#datepicker2').datepicker({
              format: "yyyy-mm-dd"
          });

          $('#tables').DataTable({
            "paging"      : true,
            "lengthChange": true,
            "searching"   : true,
            "processing": true, 
            "serverSide": true, 
          });

          var url = location.href;
            url = url.split('#');
          if(url[1] != undefined && url[1] != ''){
            detail(url[1]);
          }
      });
    </script>
</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="loading" style="position: fixed; bottom: 10px; right: 10px; z-index: 1000; display: none">
  <img src="<?php echo base_url();?>/assets/img/loading.gif">
</div>
<div class="wrapper">
  <header class="main-header">
    <a href="/" class="logo">
      <span class="logo-mini"><b>PO</b>S</span>
      <span class="logo-lg"><b>PURCHASE</b>ORDER</span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">      
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">            
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">              
              <span class="hidden-xs" class=""><?=$nama;?></span>
            </a>            
          </li>    
          <?php
          if($status == 'supplier'){
          ?>
          <li>
            <a title="Unread new file attachment" href="#"><i class="fa fa-file-text-o"></i><span class="label label-danger">
              <?php
                  echo $this->db->where('c_bpartner_id',$this->session->userdata('user_id'))->where('read','f')->get('m_po_file_additional')->num_rows();
              ?>
            </span></a>
          </li>
          <li>
            <a title="New confirmed date promised" href="#"><i class="fa fa-calendar"></i><span class="label label-danger">
              <?php
                  echo $this->db->distinct()->select('c_orderline_id')->where('c_bpartner_id',$this->session->userdata('user_id'))->where('read','f')->get('m_date_promised')->num_rows();
              ?>
            </span></a>
          </li>
          <?php } ?>
        </ul>
      </div>
    </nav>
  </header>
  <aside class="main-sidebar">    
    <?php $this->load->view('sidebar');?>    
  </aside>
  <div class="content-wrapper">    
    <section class="content-header">
      <h1>
        <?php echo $title_page; ?>
        <small><?php echo $desc_page;?></small>
      </h1>
    </section>    
    <section class="content">      
      	<?php $this->load->view($status.'/'.$content); ?>
    </section>    
  </div>
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.00
    </div>
    <strong>Copyright &copy; <?php echo date("Y"); ?> <a target="_blank" href="http://aoi.co.id">PURCHASE ORDER SYSTEM - APPAREL ONE INDONESIA, PT</a></strong>
  </footer>  
</div>
</body>
</html>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body"></div> 
      <div class="modal-footer"></div>     
    </div>
  </div>
</div>
<div class="modal fade" id="myModal_" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body"></div> 
      <div class="modal-footer"></div>     
    </div>
  </div>
</div>