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
            case 'tambah_guru':

                $nama = escape($_POST['nama']);
                $password = sha1($nama.now().rand());

                $q_t_guru = sprintf("INSERT INTO guru(nip, nama, jk, username, password, id_guru, created_at)
                                        VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%d')",
                                        escape($_POST['nip']),
                                        escape($nama),
                                        escape($_POST['jk']),
                                        escape($_POST['username']),
                                        escape($_POST['password']),
                                        $_SESSION['logged_id'],
                                        now()
                );

                $r_t_guru = mysql_query($q_t_guru);
                if(!$r_t_guru)
                    $error = 'Gagal Tambah Guru';
                else
                {
                    redirect('guru.php?sukses_tambah_guru=true');
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
                        <section class="col-lg-7">

                            <!-- TO DO List -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">List Guru</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered datatable-simple">
                                        <thead>
                                        <tr>
                                            <th>NIP</th>
                                            <th>NAMA</th>
                                            <th>JK</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $q = "SELECT * FROM guru WHERE is_active=1 ORDER BY nama ASC";
                                        $r = mysql_query($q);
                                        while($d = mysql_fetch_object($r)):
                                            ?>
                                            <tr>
                                                <td><?php echo $d->nip; ?></td>
                                                <td><?php echo $d->nama; ?></td>
                                                <td><?php echo jk($d->jk); ?></td>
                                            </tr>

                                        <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- /.box -->
                        </section><!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-5 connectedSortable">

                            <!-- Kategori List List -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">Tambah Guru</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label>NIP</label>
                                            <input type="text" class="form-control" name="nip" required="">
                                        </div>
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" class="form-control" name="nama" required="">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">Jenis Kelamin</label>
                                            <select name="jk" required class="form-control">
                                                <option value="">--Pilih Jenis Kelamin--</option>
                                                <option value="l">Laki-Laki</option>
                                                <option value="p">Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" class="form-control" name="username" required="">
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="text" class="form-control" name="password" required="">
                                        </div>
                                        <button class="btn btn-primary">Simpan</button>
                                        <input type="hidden" name="key" value="<?php echo crypt('romanov', '$1$sinkyousei$'); ?>">
                                        <input type="hidden" name="submit_type" value="tambah_guru">
                                    </form>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </section><!-- right col -->
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->

<?php include('inc/footer.php'); ?>
