<?php
	if (!$sudah_konek) require "./bin/setup.php";    
	if (!isset($_SESSION[is_admin])) header("Location: ./login.php");
	require "./bin/exec.php";
	$to=$converter->decode($_GET['to']);			
	/*switch ($_SESSION[tab])
	{
		case '2' : 	$aktif2='class="active"'; break;
		case '3' : 	$aktif3='class="active"'; break;
		case '4' : 	$aktif4='class="active"'; break;
		default	 :  $aktif1='class="active"'; break;
	}	*/
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>TSOD 7.0 | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <!-- jQuery 3 -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>

    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">

        <header class="main-header no-print">

            <!-- Logo -->
            <a href="index2.html" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <!--<img src="assets/cslogo50px50px.png" />-->
                <span class="logo-mini"></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>TSOD</b> v7.0</span>
            </a>

            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell-o"></i>
                                <span class="label label-warning">10</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 10 notifications</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                                                page and may cause design problems
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-users text-red"></i> 5 new members joined
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-user text-red"></i> You changed your username
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">View all</a></li>
                            </ul>
                        </li>
                        <!-- Control Sidebar Toggle Button -->
                        <li>
                            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                        </li>
                    </ul>
                </div>

            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MAIN NAVIGATION</li>
                    <li><a href="./ "><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
                    <li><a href="./?to=<?= $resetlogin ?>"><i class="fa fa-user-md"></i> <span> Reset Login</span></a></li>
                    <li><a href="./?to=<?= $viewujian ?>"><i class="fa fa-play-circle"></i> <span> On Progres</span></a></li>
<?php                    
$li_1='<li>'; $li_2=$li_1; $li_3=$li_1;
$li_4=$li_1; 	$li_5=$li_1; $li_6=$li_1;
$li_7=$li_1;  $li_8=$li_1; $li_8=$li_1;
$li_11=$li_1; $li_12=$li_1; $li_13=$li_1; 
$li_14=$li_1; $li_15=$li_1; $li_16=$li_1; 
$li_17=$li_1; $li_18=$li_1; $li_19=$li_1; 
$li='</li>'; $a=''; $b=''; $c='';
switch($to) {
    case 'add_kelas' 		: $li_3='<li class="active">'; 
	                          $a='active'; break;
    case 'add_test' 		: $li_1='<li class="active">'; 
                              $a='active'; break;
    case 'add_modul' 		: $li_2='<li class="active">'; 
				              $a='active'; break;
    case 'add_ruang' 		: $li_4='<li class="active">'; 
							  $a='active'; break;
    case 'add_petugas'	    : $li_5='<li class="active">'; 
				              $a='active'; break;
    case 'add_soal' 		: $li_6='<li class="active">'; 
							  $a='active'; break;
    case 'add_user' 		: $li_7='<li class="active">'; 
							  $a='active'; break;
    case 'list_test' 		: $li_11='<li class="active">'; 
							  $b='active'; break;
    case 'list_petugas'     : $li_12='<li class="active">'; 
							  $b='active'; break;
    case 'list_q' 			: $li_13='<li class="active">'; 
							  $b='active'; break;
    case 'list_soal' 		: $li_14='<li class="active">'; 
							  $b='active'; break;
    case 'list_analisis'	: $li_19='<li class="active">'; 
							  $b='active'; break;
    case 'view_result'      : $c='active'; break;    
}     
switch($_GET[filter]) {
    case 'mapel' 		: $li_15='<li class="active">'; break;
    case 'sekolah' 		: $li_16='<li class="active">'; break;
    case 'kelas' 		: $li_17='<li class="active">'; break;           
    case 'all' 		    : $li_18='<li class="active">'; break;           
}
                           
?>    
                    <li class="treeview <?= $c ?> ">
                        <a href="#">
                            <i class="fa fa-edit"></i> <span>Hasil Ujian</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <?= $li_15 ?><a href="./?to=<?= $viewresult ?>&filter=mapel"><i class="fa fa-folder-o"></i> per Mapel </a>
                            <?= $li ?>                        
                            <?= $li_16 ?><a href="./?to=<?= $viewresult ?>&filter=sekolah"><i class="fa fa-folder-o"></i> per Sekolah </a>
                            <?= $li ?>                        
                            <?= $li_17 ?><a href="./?to=<?= $viewresult ?>&filter=kelas"><i class="fa fa-folder-o"></i> per Kelas </a>
                            <?= $li ?>                        
                            <?= $li_18 ?><a href="./?to=<?= $viewresult ?>&filter=all"><i class="fa fa-folder-o"></i> Keseluruhan</a>
                            <?= $li ?>
                        </ul>
                    </li>
                    
                    <li class="treeview-menu">
                        <a href="#"><i class="fa fa-child"></i> 
                            <span> Test Result</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angel-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="./to=<?= $view_result ?>">
                                <i class="fa fa-folder-o"></i> Mapel opo...
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <li><a href="./?to=<?= $upload ?>"><i class="fa fa-cloud-upload"></i> <span> Kirim Hasil</span></a></li>
                    <li><a href="./?to=<?= $printresult ?>"><i class="fa fa-print"></i> <span> Export Hasil</span></a></li>
                    <?php
                           if ($_SESSION['user_id']<10) { 
                    ?>
                    <li class="treeview <?= $a ?> ">
                        <a href="#">
                            <i class="fa fa-edit"></i> <span>Basic Input</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <?= $li_1?><a href="./?to=<?= $addtest ?>"><i class="fa fa-calendar"></i> Jadwal Ujian</a>
                            <?= $li ?>
                            <?= $li_2?><a href="./?to=<?= $addmodul ?>"><i class="fa fa-book"></i> Modul</a>
                            <?= $li ?>
                            <?= $li_3?><a href="./?to=<?= $addkelas ?>"><i class="fa fa-group "></i> Kelas</a>
                            <?= $li ?>
                            <?= $li_4?><a href="./?to=<?= $addruang ?>"><i class="fa fa-university"></i> Ruang</a>
                            <?= $li ?>
                            <?= $li_5?><a href="./?to=<?= $addpetugas ?>"><i class="fa fa-user-secret"></i> Petugas Ruang</a>
                            <?= $li ?>
                            <?= $li_7?><a href="./?to=<?= $adduser ?>"><i class="fa fa-user-plus"></i> Users</a>
                            <?= $li ?>
                            <?= $li_6?><a href="./?to=<?= $addsoal ?>"><i class="fa fa-plus-square-o"></i> Soal Ujian</a>
                            <?= $li ?>
                        </ul>
                    </li>
                    <li class="treeview <?= $b ?> ">
                        <a href="#">
                            <i class="fa fa-table"></i> <span>laporan</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <?= $li_11 ?><a href="./?to=<?= $listtest ?>"><i class="fa fa-calendar"></i> Lap. Jadwal Ujian</a>
                            <?= $li ?>
                            <?= $li_12 ?><a href="./?to=<?= $listpetugas ?>"><i class="fa fa-user-secret"></i> Lap. Petugas Ruang</a>
                            <?= $li ?>
                            <?= $li_13 ?><a href="./?to=<?= $listq ?>"><i class="fa fa-user-plus"></i> Lap. Users</a>
                            <?= $li ?>
                            
                            <?= $li_14 ?><a href="./?to=<?= $listsoal ?>"><i class="fa fa-plus-square-o"></i> Lap. Soal Ujian</a>
                            <?= $li ?>
                            
                            <?= $li_19 ?><a href="./?to=<?= $analisissoal ?>"><i class="fa fa-plus-square-o"></i> Analisis Soal</a>
                            <?= $li ?>
                        </ul>
                    </li><?php } ?>
                    <li><a href="./?to=<?= $download ?>"><i class="fa fa-cloud-download"></i> <span> Sinkron Data</span></a></li>
<?php if ($_SESSION['user_id']<10) { ?>
                    <li><a href="./?to=<?= $zipping ?>"><i class="fa fa-archive"></i> <span> ZIP and Pack</span></a></li><?php } ?>
                    <li><a href="./?to=<?= $patch ?>"><i class="fa fa-stethoscope"></i> <span> Patching</span></a></li>
                    <li><a href="logout.php"><i class="fa fa-sign-out"></i> <span> Logout</span></a></li>

                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header)
            <section class="content-header no-print">
                <h1>
                    Dashboard
                    <small>Version 2.0</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section> -->
            <div class="box-body no-print">

                <?php if (!empty($_GET[msg])) { 
					$_GET[msg]=$converter->decode($_GET[msg]);
		?>
                <div id="Notify" class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
                    <?= $_GET[msg] ?>.
                </div>
                <script>
                    setTimeout(function() {
                        $("#Notify").fadeOut().empty();
                    }, 7000);

                </script>
                <?php	}	elseif (!empty($msg_er)) { 
										$_GET[er_msg]=$converter->decode($_GET[er_msg]);
		?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
                    <?= $msg_er ?>
                </div>
                <script>
                    setTimeout(function() {
                        $("#Notify").fadeOut().empty();
                    }, 15000);

                </script>
                <?php } ?>
            </div>
            <!-- Main content -->
            <div class="content">
                <?php 
                //echo $to;
				if(file_exists("./mod/$to.php")) 
					require "./mod/$to.php";
				else require "./mod/dashboard.php"; 
					//require "./view/home.php";
			?>

            </div>
            <!-- /.content -->
            <br>
            <br>
            <br>
            <br>
            <br>
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer no-print">
            <div class="pull-right hidden-xs">
                <b>Version</b> 2.4.0
            </div>
            <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
            reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Create the tabs -->
            <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
                <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <!-- Home tab content -->
                <div class="tab-pane" id="control-sidebar-home-tab">
                    <h3 class="control-sidebar-heading">Recent Activity</h3>
                    <ul class="control-sidebar-menu">
                        <li>
                            <a href="javascript:void(0)">
                                <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                                    <p>Will be 23 on April 24th</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <i class="menu-icon fa fa-user bg-yellow"></i>

                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                                    <p>New phone +1(800)555-1234</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                                    <p>nora@example.com</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <i class="menu-icon fa fa-file-code-o bg-green"></i>

                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                                    <p>Execution time 5 seconds</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- /.control-sidebar-menu -->

                    <h3 class="control-sidebar-heading">Tasks Progress</h3>
                    <ul class="control-sidebar-menu">
                        <li>
                            <a href="javascript:void(0)">
                                <h4 class="control-sidebar-subheading">
                                    Custom Template Design
                                    <span class="label label-danger pull-right">70%</span>
                                </h4>

                                <div class="progress progress-xxs">
                                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <h4 class="control-sidebar-subheading">
                                    Update Resume
                                    <span class="label label-success pull-right">95%</span>
                                </h4>

                                <div class="progress progress-xxs">
                                    <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <h4 class="control-sidebar-subheading">
                                    Laravel Integration
                                    <span class="label label-warning pull-right">50%</span>
                                </h4>

                                <div class="progress progress-xxs">
                                    <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <h4 class="control-sidebar-subheading">
                                    Back End Framework
                                    <span class="label label-primary pull-right">68%</span>
                                </h4>

                                <div class="progress progress-xxs">
                                    <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- /.control-sidebar-menu -->

                </div>
                <!-- /.tab-pane -->

                <!-- Settings tab content -->
                <div class="tab-pane" id="control-sidebar-settings-tab">
                    <form method="post">
                        <h3 class="control-sidebar-heading">General Settings</h3>

                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                Report panel usage
                                <input type="checkbox" class="pull-right" checked>
                            </label>

                            <p>
                                Some information about this general settings option
                            </p>
                        </div>
                        <!-- /.form-group -->

                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                Allow mail redirect
                                <input type="checkbox" class="pull-right" checked>
                            </label>

                            <p>
                                Other sets of options are available
                            </p>
                        </div>
                        <!-- /.form-group -->

                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                Expose author name in posts
                                <input type="checkbox" class="pull-right" checked>
                            </label>

                            <p>
                                Allow the user to show his name in blog posts
                            </p>
                        </div>
                        <!-- /.form-group -->

                        <h3 class="control-sidebar-heading">Chat Settings</h3>

                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                Show me as online
                                <input type="checkbox" class="pull-right" checked>
                            </label>
                        </div>
                        <!-- /.form-group -->

                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                Turn off notifications
                                <input type="checkbox" class="pull-right">
                            </label>
                        </div>
                        <!-- /.form-group -->

                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                Delete chat history
                                <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                            </label>
                        </div>
                        <!-- /.form-group -->
                    </form>
                </div>
                <!-- /.tab-pane -->
            </div>
        </aside>
        <!-- /.control-sidebar -->
        <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>

    </div>
    <!-- ./wrapper -->

    <!-- Bootstrap 3.3.7 -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- Sparkline -->
    <script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
    <!-- jvectormap  -->
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- SlimScroll -->
    <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- ChartJS -->
    <script src="bower_components/chart.js/Chart.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard2.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <script src="./bower_components/select2/dist/js/select2.full.min.js"></script>
    <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script>
        $(function() {
            $('#example1').DataTable()
            $('#example2').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': true,
                'autoWidth': false
            })
        })

    </script>
</body>

</html>
