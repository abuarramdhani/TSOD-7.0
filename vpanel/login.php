<?php
	require_once("./bin/setup.php");
	require_once("./bin/exe.php");
	if(!isset($_SESSION[is_login]))  $_SESSION[sts]='';
	//echo $_GET[msg]; exit;
	$msg=$converter->decode($_GET[msg]);
	$_SESSION[darilogin]=true;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="./bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="./bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="./plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>TSoD</b> v7.0</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">
			<?php if(empty($msg)) echo "Sign in to start your session"; else echo $msg; ?></p>

    <form action="./ceklogin.php" method="post">
      <div class="form-group has-feedback">
        <input name="username" type="text" class="form-control" placeholder="User">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input name="password" type="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
			<?php
				$r1=rand(10,20);
				$r2=rand(1,9);
				$r3=rand(0,1);
//--------------------				
				if ($r1 % $r2 == 0 && $r2!=1)
				{
					$tampil="$r1 / $r2 = ?";	
					$_SESSION[cap]=$r1/$r2;
				}
				elseif ($r1<12)
				{
					$tampil="$r1 x $r2 = ?";	
					$_SESSION[cap]=$r1*$r2;
				}
//--------------------				
				elseif ($r3==0)
				{
					$tampil="$r1 + $r2 = ?";	
					$_SESSION[cap]=$r1+$r2;
				}
				else
				{
					$tampil="$r1 - $r2 = ?";	
					$_SESSION[cap]=$r1-$r2;					
				}
			?>
			<div class="form-group has-feedback">
        <input type="text" name="calc" class="form-control" placeholder="<?php echo $tampil ?>">
        <span class="glyphicon glyphicon-th form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
           
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <!-- /.social-auth-links -->
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="./bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="./bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="./plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
