<?php 
if($_SERVER['REQUEST_SCHEME'] == 'http' && $_SERVER['HTTP_HOST'] == 'po.aoi.co.id'){
    header('location:https://po.aoi.co.id'.$_SERVER['PATH_INFO']);
}
$this->Addons->islogin();
if(isset($_GET['callback']) == 1){
  $callback = $_GET['callback'];
}else{
  $callback = base_url();
}
?>
<!DOCTYPE html>
<html>
<div class="col-sm-6">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PURCHASE ORDER SYSTEM :: PT. APPAREL ONE INDONESIA</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?=base_url('assets/bootstrap/css/bootstrap.min.css');?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?=base_url('assets/dist/css/AdminLTE.min.css');?>">
  <link rel="stylesheet" href="<?=base_url('assets/plugins/iCheck/square/blue.css');?>">
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="shortcut icon" href="https://po.aoi.co.id/assets/img/aoi-logo.jpg">
    <link rel="stylesheet" href="<?php echo base_url("assets/plugins/datatables/dataTables.bootstrap.css");?>">
    <script src="<?php echo base_url("assets/plugins/slimScroll/jquery.slimscroll.min.js");?>"></script>
    <script src="<?php echo base_url("assets/plugins/datatables/dataTables.bootstrap.css");?>"></script>
    <script src="<?php echo base_url("assets/plugins/datatables/jquery.dataTables.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/datatables/dataTables.bootstrap.min.js"); ?>"></script>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script type="text/javascript">
      $(function(){
        $('#tables').DataTable({
            'paging':true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true
        });
        $('#tables2').DataTable({
            'paging'      : false,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : false,
            'info'        : false,
            'autoWidth'   : false,
        });

        var url = location.href;
          url = url.split('#');
        if(url[1] != undefined && url[1] != ''){
          detail(url[1]);
        }
      });
    </script>
</head>
<body class="hold-transition login-page">
<div class="login-box" style="margin-top: 130px; ">
  <div class="login-logo" style="border:0px solid #000; width: 500px; margin-left: -100px;">
    <span style="font-size: 30px;"> <b>PURCHASE ORDER</b> SYSTEM</span><br>
    PT. APPAREL ONE INDONESIA<br>
    <span style="font-size: 24px;"><b>FOR ADMIN</b></span>
  </div>
  <div class="login-box-body" style="width: 300px;">
    <p class="login-box-msg">Username dan Password</p>
    <form class="submit" action="admin/check" method="POST">
      <div class="form-group has-feedback">
        <input type="hidden" class="form-control" value="<?=$callback;?>" name="callback">
        <input id="number" type="number" class="form-control" placeholder="User ID" name="user_id" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <button type="submit" class="btn btn-default bg-purple btn-flat btn-block">LOGIN</button>
    </form>
  </div>
</div>
<script src="<?=base_url('assets/plugins/jQuery/jQuery-2.2.0.min.js');?>"></script>
<script src="<?=base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>
</body>
</div>
<div class="col-sm-6" style="margin-top: 110px">
  <!-- <div class="container" style="margin-top: 100px">
  <div class="text-right">
    <a href="#demo" class="btn glyphicon glyphicon-chevron-down" data-toggle="collapse"></a>
      <div id="demo" class="collapse collapse-left"> -->
  <table class="table table-bordered" id="tables">
    <thead class="bg-purple" ">
      <tr>
        <th style="width: 4px">#</th>
        <th>User ID</th>
        <th>Username</th>
      </tr>
    </thead>
    <tbody>
     <?php
        $nomor=1;
        $users = $this->db->get('m_user_new');
        foreach($users->result() as $u){
    ?>
    <tr>
        <td><?=$nomor++;?></td>
        <td><?=$u->user_id;?></a></td>
        <td><?=$u->nama;?></td>
    <?php
        }
    ?>
    </tr>
    </tbody>
  </table>
      </div>
  </div>
</div>
</div>
</div>
</html>
