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
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $q_transaksi = mysql_query("SELECT transaksi.*, siswa.nama as nama_siswa, pembayaran.nama as nama_pembayaran
                                                            FROM transaksi
                                                            JOIN siswa ON siswa.id=transaksi.id_siswa
                                                            JOIN pembayaran ON pembayaran.id=transaksi.id_pembayaran
                                                            ORDER BY created_at DESC");
                                        while($transaksi = mysql_fetch_object($q_transaksi)):
                                            ?>
                                            <tr class="<?php echo $transaksi->tipe == 'in' ? 'success' : 'danger' ?>">
                                                <td><?php echo tanggal_format_indonesia($transaksi->tanggal); ?></td>
                                                <td><?php echo $transaksi->tipe; ?></td>
                                                <td><?php echo $transaksi->nama_siswa; ?></td>
                                                <td><?php echo $transaksi->jumlah; ?></td>
                                                <td><?php echo $transaksi->nama_pembayaran; ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div><!-- /.distro -->
                            </div><!-- /.box -->
                        </section><!-- /.Left col -->
                </section><!-- /.content -->

<?php include('inc/footer.php'); ?>
