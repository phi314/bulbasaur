<?php
    ob_start();
    session_start();
    require_once('../lib/connection.php');
    require_once('../lib/unleashed.lib.php');
    require_once('../lib/login.php');

    require_once('inc/header.php');

?>


    <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                        <small>Home</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-7">

                            <!-- Event List -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">Transaksi Terakhir</h3>
                                </div><!-- /.box-header -->
                                <?php
                                $q = "SELECT * FROM transaksi ORDER BY created_at DESC LIMIT 20";
                                $r = mysql_query($q);
                                while($d = mysql_fetch_object($r)):
                                    ?>
                                    <a href="event_detail.php?id=<?php echo $d->id; ?>" class="list-group-item">
                                        <?php echo $d->nama; ?>
                                        <br>
                                        <small>
                                            <label>Waktu Event</label>
                                            <br>
                                            <?php echo tanggal_format_indonesia($d->waktu, TRUE); ?>
                                            <br>
                                            Lama <?php echo $d->lama; ?> Hari
                                        </small>
                                        <div class="pull-right"><i class="fa fa-chevron-circle-right"></i> </div>
                                    </a>

                                <?php endwhile; ?>
                            </div><!-- /.box -->
                        </section><!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-5 connectedSortable">

                            <div class="box box-success">
                                <div class="box-header">
                                    <i class="fa fa-dashboard"></i>
                                    <h3 class="box-title">Peninjauan</h3>
                                </div>
                                <div class="box-body list-group">
                                    <div class="list-group-item">Siswa 20</div>
                                    <div class="list-group-item">Guru 9</div>
                                    <div class="list-group-item">Transaksi 345</div>
                                </div>
                            </div>

                        </section><!-- right col -->
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->

<?php include('inc/footer.php'); ?>
