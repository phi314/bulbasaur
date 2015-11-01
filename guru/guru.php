<?php
    ob_start();
    session_start();
    require_once('../lib/connection.php');
    require_once('../lib/unleashed.lib.php');
    require_once('../lib/login.php');


    // submitter
    if(array_key_exists('key', $_POST))
    {
        $submit_type = $_POST['submit_type'];
        switch($submit_type)
        {
            case 'tambah_petugas':

                $nama = strtoupper(escape($_POST['nama']));
                $username = substr($nama, 0, 5).substr($_POST['tgl_lahir'], 3, 2).substr($_POST['tgl_lahir'], 8, 2);
                $password = sha1($username.rand());
                $tanggal_lahir = date('Y-m-d', strtotime($_POST['tgl_lahir']));

                $q_t_petugas = sprintf("INSERT INTO petugas(nama, jk, tempat_lahir, tanggal_lahir, alamat, kota, telepon, email, username, password, create_date)
                                        VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
                                        escape($nama),
                                        escape($_POST['jk']),
                                        escape($_POST['t_lahir']),
                                        $tanggal_lahir,
                                        escape($_POST['alamat']),
                                        escape($_POST['kota']),
                                        escape($_POST['telepon']),
                                        escape($_POST['email']),
                                        $username,
                                        $password,
                                        now()
                );

                $r_t_petugas = mysql_query($q_t_petugas);
                if(!$r_t_petugas)
                    $error = 'Gagal Tambah Petugas';
                else
                {
                    $id = mysql_insert_id();
                    // buat log file
                    $file_path = '../lib/tamankota-log.txt';
                    $message = "[".now()."]Tambah data petugas $id oleh $logged_id pass = Xcs$password";
                    add_log($file_path, $message);
                    // refresh page
                    redirect('petugas.php?sukses_tambah_petugas=true');
                }
                break;
        }
    }

    require_once('inc/header.php');

?>


    <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Guru
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">Guru</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-12">

                            <!-- TO DO List -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">List Guru</h3>
                                </div><!-- /.box-header -->
                                <?php
                                    $q = "SELECT * FROM guru WHERE is_active=1 ORDER BY nama ASC";
                                    $r = mysql_query($q);
                                    while($d = mysql_fetch_object($r)):
                                ?>
                                    <a href="guru_detail.php?id=<?php echo $d->id; ?>" class="list-group-item">
                                        <?php echo $d->nama; ?> <em>(<?php echo $d->nip; ?>)</em>
                                        <div class="pull-right"><i class="fa fa-chevron-circle-right"></i> </div>
                                    </a>

                                <?php endwhile; ?>
                            </div><!-- /.box -->
                        </section><!-- /.Left col -->
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->

<?php include('inc/footer.php'); ?>
