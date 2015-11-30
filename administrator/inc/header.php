<?php
    require_once('../lib/connection.php');
    require_once('../lib/unleashed.lib.php');

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>RFID | Administrator</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="<?php echo base_url(); ?>assets/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Date Picker -->
    <link href="<?php echo base_url(); ?>assets/css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="<?php echo base_url(); ?>assets/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- Datetable -->
    <link href="<?php echo base_url(); ?>assets/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="<?php echo base_url(); ?>assets/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url(); ?>assets/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/context.standalone.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/universal.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/main.admin.css" rel="stylesheet" type="text/css" />


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="<?php echo base_url(); ?>assets/js/html5shiv.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/respond.min.js"></script>
    <![endif]-->



</head>
<body class="skin-blue fixed">
<!-- header logo: style can be found in header.less -->
    <header class="header">
        <a href="index.html" class="logo">
            <!-- Add the class icon to your logo image or logo icon to add the margining -->
            RFID System
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-right">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-user"></i>
                            <span><?php echo $logged_name; ?> <i class="caret"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header bg-light-blue">
                                <?php
                                    // jika ada foto
                                    $foto_profile = !empty($user->foto) ? $user->foto : FALSE;
                                    //jika tidak ada foto
                                    if(!$foto_profile)
                                    {
                                        // jika laki-laki
                                        if($user->jk == 'perempuan')
                                            $foto_profile = 'no-foto-2.png';
                                        // jika perempuan
                                        else
                                            $foto_profile = 'no-foto-1.png';
                                    }
                                ?>
                                <img src="../assets/img/foto_petugas/<?php echo $foto_profile; ?>" class="img-circle" alt="User Image" />
                                <p>
                                    <?php
                                        echo $logged_name;
                                    ?>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="guru_detail.php?id=<?php echo $logged_id; ?>" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="logout.php" class="btn btn-default btn-flat">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li>
                    <a href="home.php">
                        <i class="fa fa-home"></i> <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href="siswa.php">
                        <i class="fa fa-users"></i> <span>Siswa</span>
                    </a>
                </li>
                <li>
                    <a href="guru.php">
                        <i class="fa fa-user"></i> <span>Guru</span>
                    </a>
                </li>
                <li>
                    <a href="kelas.php">
                        <i class="fa fa-building"></i> <span>Kelas</span>
                    </a>
                </li>
                <?php if($_SESSION['logged_user_level'] == '2'): ?>
                <li>
                    <a href="transaksi.php">
                        <i class="fa fa-database"></i> <span>Transaksi</span>
                    </a>
                </li>
                <li>
                    <a href="pembayaran.php">
                        <i class="fa fa-calendar"></i> <span>Pembayaran</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">
