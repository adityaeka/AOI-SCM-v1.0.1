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
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script type="text/javascript">
  	$(function(){

  	})
  </script>
</head>
<body class="hold-transition login-page">
<div class="login-box" style="margin-top: 100px; ">
  <div class="login-logo" style="border:0px solid #000; width: 500px; margin-left: -100px;">
    <span style="font-size: 30px;"> <b>PURCHASE ORDER</b> SYSTEM</span><br>
    PT. APPAREL ONE INDONESIA
  </div>
  <div class="login-box-body" style="width: 300px;">
    <p class="login-box-msg">Username dan Password</p>
    <form class="submit" action="check" method="POST">
      <div class="form-group has-feedback">
        <input type="hidden" class="form-control" value="<?=$callback;?>" name="callback">
        <input type="text" class="form-control" placeholder="Username" name="username" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
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
</html>