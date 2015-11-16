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

                    <div class="row">
                        <div class="col-md-12">
                            <!-- right col (We are only adding the ID to make the widgets sortable)-->

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

                        </div>
                    </div>

                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-12">

                            <!-- Event List -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">Transaksi Terakhir</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table datatable-simple">
                                        <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Tipe</th>
                                            <th>Nama Siswa</th>
                                            <th>Jumlah</th>
                                            <th>Pembayaran</th>
                                            <th>Guru</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $q_transaksi = mysql_query("SELECT * FROM transaksi ORDER BY created_at DESC");
                                        while($transaksi = mysql_fetch_object($q_transaksi)):
                                            ?>
                                            <tr class="">
                                                <td><?php echo tanggal_format_indonesia($transaksi->tanggal); ?></td>
                                                <td><?php echo $transaksi->tipe; ?></td>
                                                <td><?php echo $transaksi->id_siswa; ?></td>
                                                <td><?php echo $transaksi->jumlah; ?></td>
                                                <td><?php echo $transaksi->id_pembayaran; ?></td>
                                                <td><?php echo $transaksi->id_guru; ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div><!-- /.distro -->
                            </div><!-- /.box -->
                        </section><!-- /.Left col -->
                </section><!-- /.content -->

<?php include('inc/footer.php'); ?>
