<?php
    ob_start();
    session_start();
    require_once("../lib/connection.php");
    require_once("../lib/unleashed.lib.php");

    // jika sudah login otomatis ke halaman home
    if(isset($_SESSION['logged_in']))
        redirect('home.php');


    if(array_key_exists('key', $_POST))
    {
        $username = escape($_POST['username']);
        $password = escape($_POST['password']);
        $password_enc = sha1($password);
        // cek user valid
        $q = "SELECT id, nama, username, is_admin FROM guru WHERE username='$username' AND password='$password_enc' AND is_active=1 LIMIT 1";
        $r = mysql_query($q);

        $user = mysql_fetch_object($r);

        // jika user valid
        if($user != FALSE)
        {
            // set Session
            $id = $user->id;
            $_SESSION['logged_id'] = $id;
            $_SESSION['logged_nama'] = $user->nama;
            $_SESSION['logged_username'] = $user->username;
            $_SESSION['logged_in'] = TRUE;
            $_SESSION['logged_is_admin'] = $user->is_admin;

            redirect('home.php');
        }
        else
        {
            redirect('index.php?error_login=1');
        }
    }
?>

<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>SMKN 6 Garut</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/universal.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/main.admin.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo base_url(); ?>assets/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <style type="text/css">
            .form-box .header {
                background-color: #0073b7;
            }
        </style>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="<?php echo base_url(); ?>assets/js/html5shiv.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header">TATA USAHA | SMKN 6</div>
            <form action="" method="post">
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Username"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>          
                </div>
                <div class="footer">
                    <div class="text-danger">
                        <?php echo isset($_GET['error_login']) ? 'Anda salah memasukan username atau password' : ''; ?>
                    </div>
                    <input type="hidden" value="<?php echo sha1(date('ymdhis')); ?>" name="key">
                    <button type="submit" class="btn bg-blue btn-block">Login</button>

                </div>
            </form>
        </div>

        <script src="../assets/js/vendor/jquery-1.10.2.min.js"></script>
        <script src="../assets/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>