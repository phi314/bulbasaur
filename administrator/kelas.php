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
            case 'tambah_kelas':

                $q_t_kelas = sprintf("INSERT INTO kelas(tingkat, nama, tahun, id_guru, created_at)
                                        VALUES('%s', '%s', '%s', '%s', '%s')",
                                        escape($_POST['tingkat']),
                                        escape($_POST['nama']),
                                        escape($_POST['tahun']),
                                        escape($_SESSION['logged_id']),
                                        now()
                );

                $r_t_kelas = mysql_query($q_t_kelas);

                dump(mysql_error());
                if(!$r_t_kelas)
                    $error = 'Gagal Tambah kelas';
                else
                {
                    redirect('kelas.php?sukses_tambah_kelas=true');
                }
                break;
        }
    }

    require_once('inc/header.php');

?>


    <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Kelas
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">Kelas</li>
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
                                    <h3 class="box-title">List Kelas</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table datatable-simple">
                                        <thead>
                                        <tr>
                                            <th>Tingkat</th>
                                            <th>Nama</th>
                                            <th>Tahun</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $q = "SELECT * FROM kelas ORDER BY tingkat, tahun ASC";
                                        $r = mysql_query($q);
                                        while($d = mysql_fetch_object($r)):
                                        ?>
                                            <tr>
                                                <td><?php echo $d->tingkat; ?></td>
                                                <td><?php echo $d->nama; ?></td>
                                                <td><?php echo $d->tahun; ?></td>
                                                <td>
                                                    <div class="btn-group btn-group-xs">
                                                        <a href="kelas_detail.php?id=<?php echo $d->id; ?>" class="btn btn-warning"><i class="fa fa-edit"></i> </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- /.box -->
                        </section><!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-5 connectedSortable">
                            <?php if($_SESSION['logged_is_admin']): ?>
                            <!-- Kategori List List -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">Tambah Kelas</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label>Tingkat</label>
                                            <select name="tingkat" class="form-control">
                                                <option value="">--Pilih Tingkat--</option>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" class="form-control" name="nama" required="">
                                        </div>
                                        <div class="form-group">
                                            <label>Tahun</label>
                                            <input type="text" class="form-control" name="tahun" required="">
                                        </div>
                                        <button class="btn btn-primary">Simpan</button>
                                        <input type="hidden" name="key" value="<?php echo crypt('romanov', '$1$sinkyousei$'); ?>">
                                        <input type="hidden" name="submit_type" value="tambah_kelas">
                                    </form>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </section><!-- right col -->
                        <?php endif; ?>
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->

<?php include('inc/footer.php'); ?>
