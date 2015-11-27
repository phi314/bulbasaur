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
            case 'tambah_pembayaran':
                $tanggal = escape($_POST['tanggal']);
                $q_t_pembayaran = sprintf("INSERT INTO pembayaran(nama, jumlah, tanggal, id_guru, is_aktif, keterangan, created_at)
                                        VALUES('%s', '%d', '$tanggal', '%s', '%s', '%s', '%s')",
                                        escape($_POST['nama']),
                                        escape($_POST['jumlah']),
                                        $logged_id,
                                        1,
                                        escape($_POST['keterangan']),
                                        now()
                );

                $r_t_pembayaran = mysql_query($q_t_pembayaran);

                if(!$r_t_pembayaran)
                    $error = 'Gagal Tambah pembayaran';
                else
                {
                    $id = mysql_insert_id();



                    // refresh page
                    redirect("pembayaran_detail.php?id=$id");
                }
                break;
        }
    }

    require_once('inc/header.php');


?>
<link href="../assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />


    <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        pembayaran
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">pembayaran</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-4">

                            <!-- TO DO List -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">Listing pembayaran</h3>
                                </div><!-- /.box-header -->
                                <?php
                                    $q = "SELECT * FROM pembayaran ORDER BY created_at DESC";
                                    $r = mysql_query($q);
                                    while($d = mysql_fetch_object($r)):
                                ?>
                                    <a href="pembayaran_detail.php?id=<?php echo $d->id; ?>" class="list-group-item">
                                        <?php echo $d->nama; ?>
                                        <br>
                                        <small>
                                            <label>Tanggal Pembayaran</label>
                                            <br>
                                            <?php echo tanggal_format_indonesia($d->tanggal); ?>
                                            <br>
                                            Jumlah <?php echo format_rupiah($d->jumlah); ?>
                                        </small>
                                        <div class="pull-right"><i class="fa fa-chevron-circle-right"></i> </div>
                                    </a>

                                <?php endwhile; ?>
                            </div><!-- /.box -->
                        </section><!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-8 connectedSortable">

                            <!-- Kategori List List -->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">Tambah pembayaran</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" class="form-control" name="nama" required="">
                                        </div>
                                        <div class="form-group">
                                            <label>Jumlah</label>
                                            <input type="text" class="form-control" name="jumlah" required="">
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal</label><br>
                                            <input type="text" class="form-control tanggal" name="tanggal" placeholder="" required="">
                                        </div>
                                        <div class="form-group">
                                            <label>Keterangan</label>
                                            <textarea class="form-control" name="keterangan" id="keterangan" ></textarea>
                                        </div>
                                        <br>
                                        <button class="btn btn-primary">Simpan</button>
                                        <input type="hidden" name="key" value="<?php echo crypt('romanov', '$1$sinkyousei$'); ?>">
                                        <input type="hidden" name="submit_type" value="tambah_pembayaran">
                                    </form>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </section><!-- right col -->
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->

<?php include('inc/footer.php'); ?>
<script src="../assets/js/plugins/datepicker/bootstrap-datepicker.js"></script>

<script type="text/javascript">
    $('.tanggal').datepicker({
        format: 'yyyy-mm-dd'
    })
</script>
