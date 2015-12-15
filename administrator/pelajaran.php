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
            case 'tambah_pelajaran':

                $nama = escape($_POST['nama']);
                $password = sha1($nama.now().rand());

                $q_t_pelajaran = sprintf("INSERT INTO pelajaran(nama)
                                        VALUES('%s')",
                                        escape($nama)
                );

                $r_t_pelajaran = mysql_query($q_t_pelajaran);
                if(!$r_t_pelajaran)
                    $error = 'Gagal Tambah pelajaran';
                else
                {
                    redirect('pelajaran.php?sukses_tambah_pelajaran=true');
                }
                break;
        }
    }

    require_once('inc/header.php');

?>


    <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        pelajaran
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">pelajaran</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <?php if(!empty($error)): ?>
                        <div class="alert alert-danger">
                            <i class="fa fa-warning"></i>
                            <strong><?php echo $error; ?></strong>
                        </div>
                        <script>

                        </script>
                    <?php endif; ?>

                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-7">

                            <!-- TO DO List -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">List pelajaran</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered datatable-simple">
                                        <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>NAMA</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $q = "SELECT * FROM pelajaran ORDER BY nama ASC";
                                        $r = mysql_query($q);
                                        $no = 1;
                                        while($d = mysql_fetch_object($r)):
                                            ?>
                                            <tr>
                                                <td><a href="pelajaran_detail.php?id=<?php echo $d->id; ?>"><?php echo $no++; ?></a></td>
                                                <td><?php echo $d->nama; ?></td>
                                            </tr>

                                        <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- /.box -->
                        </section><!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-5 connectedSortable">
                            <?php if($logged_user_level == '1'): ?>
                            <!-- Kategori List List -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">Tambah pelajaran</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" class="form-control" name="nama" required="">
                                        </div>
                                        <button class="btn btn-primary">Simpan</button>
                                        <input type="hidden" name="key" value="<?php echo crypt('romanov', '$1$sinkyousei$'); ?>">
                                        <input type="hidden" name="submit_type" value="tambah_pelajaran">
                                    </form>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            <?php endif; ?>
                        </section><!-- right col -->
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->

<?php include('inc/footer.php'); ?>
