<?php

ob_start();
session_start();
require_once('../lib/connection.php');
require_once('../lib/unleashed.lib.php');
require_once('../lib/login.php');

require_once('inc/header.php');

$status = FALSE;
$success = '';
$error = '';

if(isset($_SESSION['id_pembayaran']))
{
    redirect('transaksi_create.php');
}

?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Tambah Transaksi
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Transaksi</li>
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

        <?php if(!empty($_GET['add']) AND !empty($_GET['nama']) AND empty($_POST)): ?>
            <div class="alert alert-success">
                <i class="fa fa-info"></i>
                <strong>Berhasil Tambah Fasilitas <?php echo $_GET['nama']; ?></strong>
            </div>
            <script>

            </script>
        <?php endif; ?>

        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-12">
                <div class="box box-warning">
                    <div class="box-header">
                        <i class="fa fa-calendar"></i>
                        <h3 class="box-title">Pilih Pembayaran</h3>
                    </div>
                    <div class="box-body">
                        <table class="table datatable-simple">
                            <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jumlah</th>
                                <th>Pilih</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $qpembayaran = mysql_query("SELECT * FROM pembayaran WHERE nama!='Topup' ORDER BY created_at DESC");
                                while($pembayaran = mysql_fetch_object($qpembayaran)):
                            ?>
                            <tr>
                                <td><?php echo $pembayaran->nama; ?></td>
                                <td><?php echo format_rupiah($pembayaran->jumlah); ?></td>
                                <td>
                                    <form action="transaksi_create.php" method="post">
                                        <button class="btn btn-warning" name="id" value="<?php echo $pembayaran->id; ?>">Pilih</button>
                                        <input type="hidden" name="submit_type" value="add_session_id_pembayaran">
                                        <input type="hidden" name="key" value="bulbasaur">
                                    </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div><!-- /.distro -->
                </div>
            </section><!-- /.Left col -->

        </div><!-- /.row (main row) -->
    </section><!-- /.content -->

<?php include('inc/footer.php'); ?>

<script type="text/javascript">
    $('#table-items').dataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": false,
        "bSort": false,
        "bInfo": false,
        "bAutoWidth": false,
        "iDisplayLength": 100
    });
</script>