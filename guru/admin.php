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
        $q = "SELECT id, nama, username FROM admin WHERE username='$username' AND password='$password_enc' LIMIT 1";
        $r = mysql_query($q);

        $user = mysql_fetch_object($r);

        // jika user valid
        if($user != FALSE)
        {
            // set Session
            $_SESSION['id'] = $user->id;
            $_SESSION['nama'] = $user->nama;
            $_SESSION['username'] = $user->username;
            $_SESSION['logged_in'] = TRUE;
            $_SESSION['usertype'] = 'superadmin';

            redirect('home.php');
        }
        else
        {
            redirect('loginsuper.php?error_login=1');
        }
    }
?>

<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>AdminLTE | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/universal.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/main.admin.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <style type="text/css">
            .form-box .header {
                background-color: #f56954;
            }
        </style>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="../assets/js/html5shiv.js"></script>
        <script src="../assets/js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header">Administrator</div>
            <form action="" method="post">
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Username"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>          
                    <div class="form-group">
                        <input type="checkbox" name="remember_me"/> Remember me
                    </div>
                </div>
                <div class="footer">
                    <div class="text-danger">
                        <?php echo isset($_GET['error_login']) ? 'Anda salah memasukan username atau password' : ''; ?>
                    </div>
                    <input type="hidden" value="<?php echo sha1(date('ymdhis')); ?>" name="key">
                    <button type="submit" class="btn bg-red btn-block">Login</button>

                    <p><a href="#">Lupa password</a></p>
                    
                </div>
            </form>
        </div>

        <script src="../assets/js/vendor/jquery-1.10.2.min.js"></script>
        <script src="../assets/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>