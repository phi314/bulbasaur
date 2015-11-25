<?php
    ob_start();
    session_start();
    require_once('../lib/connection.php');
    require_once('../lib/unleashed.lib.php');
    require_once('../lib/login.php');

    $user_id = $_SESSION['logged_id'];
    $now = now();
    $date_now = date('y-m-d');


    // submitter
    if(array_key_exists('key', $_POST))
    {
        $submit_type = $_POST['submit_type'];
        switch($submit_type)
        {
            case 'tambah_absensi':

                $keterangan = escape($_POST['keterangan']);
                $q_val = mysql_query("SELECT * FROM absensi WHERE id_guru='$user_id' AND tanggal='$date_now' AND keterangan='$keterangan'");

                if(mysql_num_rows($q_val) > 0)
                {
                    $error = $keterangan.' pada tanggal '.$now.' sudah ada.';
                }
                else
                {
                    $q_t_event = sprintf("INSERT INTO absensi(id_guru, tanggal, keterangan, created_at)
                                        VALUES('%s', '%s', '%s', '%s')",
                        $_SESSION['logged_id'],
                        now(),
                        $keterangan,
                        now()
                    );

                    $r_t_event = mysql_query($q_t_event);
                    if(!$r_t_event)
                        $error = 'Gagal Tambah Absensi';
                    else
                    {
                        $id = mysql_insert_id();
                        redirect("abasensi_detail.php?id=$id");
                    }
                }

                break;
        }
    }

    require_once('inc/header.php');


?>

    <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Absensi
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">Absensi</li>
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
                        <section class="col-lg-8">

                            <!-- TO DO List -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">List Absensi</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table datatable">
                                        <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Keterangan / Pelajaran</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody id="list-absensi">
                                        <?php
                                        $date_now = date('y-m-d');
                                        $q_absensi = mysql_query("SELECT absensi.*
                                                                    FROM absensi
                                                                    ORDER BY created_at DESC");

                                        while($d_absensi = mysql_fetch_object($q_absensi)):
                                            ?>
                                            <tr id="<?php echo $d_absensi->id; ?>">
                                                <td><?php echo tanggal_format_indonesia($d_absensi->tanggal); ?></td>
                                                <td><?php echo $d_absensi->keterangan; ?></td>
                                                <td>
                                                    <a href="absensi_detail.php?id=<?php echo $d_absensi->id; ?>" class="btn btn-xs btn-success">detail</a>
                                                </td>
                                            </tr>
                                        <?php
                                        endwhile;
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- /.box -->
                        </section><!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-4 connectedSortable">

                            <!-- Kategori List List -->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">Tambah Absensi</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <div class="form-control-static"><?php echo tanggal_format_indonesia(now()); ?></div>
                                        </div>
                                        <div class="form-group">
                                            <label>Keterangan</label>
                                            <textarea class="form-control" name="keterangan" id="keterangan" required=""></textarea>
                                        </div>
                                        <br>
                                        <button class="btn btn-primary">Simpan</button>
                                        <input type="hidden" name="key" value="<?php echo crypt('romanov', '$1$sinkyousei$'); ?>">
                                        <input type="hidden" name="submit_type" value="tambah_absensi">
                                    </form>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </section><!-- right col -->
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->

<?php include('inc/footer.php'); ?>
<script src="../assets/js/bootstrap-datetimepicker.js"></script>

<script type="text/javascript">
    $('.waktu').datetimepicker()
</script>
