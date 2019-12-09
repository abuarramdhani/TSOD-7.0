<?php
	if(!defined('gaklangsung'))
	die("<h3>Akses terbatas!</h3>");		
	$msg=$converter->decode($_GET[msg]);
?>
<!doctype html>
<html class="no-js" lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<script src="./assets/js/SpryValidationTextField.js" type="text/javascript"></script>
<link href="./assets/css/SpryValidationTextField.css" rel="stylesheet" type="text/css">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>PUSPENDIK - CBT Application | </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        function disableBackButton() {
            window.history.forward();
        }
        setTimeout("disableBackButton()", 0);

    </script>

    <style>
        .no-close .ui-dialog-titlebar-close {
            display: none;
        }

        <?php if ($msg !=2) {
            ?>input.username {
                background: #fff;
            }
            <?php
        }
        else {
            ?>input.username {
                background: #FFB7B7;
            }
            <?php
        }

        if ($msg !=3) {
            ?>input.password {
                background: #fff;
            }
            <?php
        }

        else {
            ?>input.password {
                background: #FFB7B7;
            }
            <?php
        }
        ?>
    </style>

    <link href="./assets/css/fonts.css" rel="stylesheet" />
    <link href="./assets/css/main.css" rel="stylesheet" />
</head>

<body>


    <main>

        <header>
            <nav class="navbar">
                <div class="container">
                    <a class="navbar-brand" href="#">PUSPENDIK - CBT APPLICATION</a>
                    <div class="pull-right bg-dark">
                        <div class="access-panel">
                            <div class="ac-avatar"></div>
                            <div class="ac-info">
                                <span class="ac-welcome">Selamat Datang</span>

                                <span class="ac-name"></span> </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <div class="container">
            <div class="main-content">


                <div class="page-column">
                    <?php if (!empty($msg)) { ?>
                    <div class="alert alert-danger" role="alert" style="font-size: 16px;">
                        <div class="validation-summary-valid" data-valmsg-summary="true">
                            <?php
    if ($msg==2) echo "Username tidak terdaftar!!!";
	elseif ($msg==3) echo "Password tidak valid!!!";
	elseif ($msg==4) echo "Password Admin tidak valid!!!";
?>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="page-col-small col-centered login-wrapper">
                        <h1 class="panel-title page-label" align="center">Halaman diakses tanpa Exambro</h1><br/>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h1 class="panel-title page-label">User Login</h1>
                            </div>
                            <div class="panel-body">
                                <div class="inner-content">
                                    <form action="ceklogin2.php" method="post">
                                        <div class="form-horizontal">
                                            <div class="form-group error">
                                                <label class="col-sm-3 control-label" for="UserName">User name</label>
                                                <div class="col-sm-9 input-wrapper">
                                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span><span id="sprytextfield1">
                                                        <input class="form-control" name="username" type="text" value="" />
                                                    </span> </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" for="Password">Password</label>
                                                <div class="col-sm-9 input-wrapper">
                                                    <span class="glyphicon glyphicon-lock" aria-hidden="true"></span><span id="sprytextfield2">
                                                        <input class="form-control" name="password" type="text" value="" />
                                                    </span></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" for="Password">Password Admin</label>
                                                <div class="col-sm-9 input-wrapper">
                                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span><span id="sprytextfield2">
                                                        <input class="form-control" name="passadmin" type="password" value="" />
                                                    </span></div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-9 text-right">
                                                    <button type="submit" class="btn btn-success btn-block doblockui">LOGIN</button>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12 text-center">
                                                    <a href="testbrowser.php" id="test" style=" color:#000; font-size:12px;">[ Klik disini untuk melakukan download aplikasi ]</a> </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="wysiwyg-content"> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
            </div>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>SMKN 1 Banyuwangi, has-no-Copyrights</p>
        </div>
    </footer>
    <script type="text/javascript">
        <!--
        var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "custom", {
            pattern: "00-0000-0000-0",
            useCharacterMasking: true
        });
        var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "custom", {
            pattern: "00-00-0000",
            useCharacterMasking: true
        });
        //-->

    </script>
</body>

</html>
