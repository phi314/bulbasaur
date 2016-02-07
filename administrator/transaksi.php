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

$id = '';
$filter_string = '';
$dual_table = FALSE;

if(isset($_GET['filter'])){
    $filter = $_GET['filter'];
    $filter_exp = explode('-', $filter);
    $filter = $filter_exp[0];
    $id = !empty($filter_exp[1]) ? $filter_exp[1] : 0;
    $filter_string = !empty($filter_exp[2]) ? $filter_exp[2] : "";

    switch($filter)
    {
        case 'topup':
            $query = "SELECT transaksi.*, siswa.nama as nama_siswa, pembayaran.nama as nama_pembayaran
                                                            FROM transaksi
                                                            JOIN siswa ON siswa.id=transaksi.id_siswa
                                                            JOIN pembayaran ON pembayaran.id=transaksi.id_pembayaran
                                                            WHERE pembayaran.id = '1'
                                                            ORDER BY transaksi.created_at DESC";
            break;
        case 'already':
            $query = "SELECT transaksi.*, siswa.nama as nama_siswa, pembayaran.nama as nama_pembayaran
                                                            FROM transaksi
                                                            JOIN siswa ON siswa.id=transaksi.id_siswa
                                                            JOIN pembayaran ON pembayaran.id=transaksi.id_pembayaran
                                                            WHERE pembayaran.id = '$id'
                                                            ORDER BY transaksi.created_at DESC";

            $dual_table = TRUE;
            break;
        default:
            $query = "SELECT transaksi.*, siswa.nama as nama_siswa, pembayaran.nama as nama_pembayaran
                                                            FROM transaksi
                                                            JOIN siswa ON siswa.id=transaksi.id_siswa
                                                            JOIN pembayaran ON pembayaran.id=transaksi.id_pembayaran
                                                            ORDER BY transaksi.created_at DESC";

    }


    $q_transaksi = mysql_query($query);
}

?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Transaksi
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

        <div class="row">
            <div class="col-md-5">
                <a class="btn btn-primary" href="transaksi_choose.php"><i class="fa fa-plus"></i> Tambah Transaksi</a>
                <a class="btn btn-warning" href="transaksi_topup.php"><i class="fa fa-angle-double-up"></i> Top-up Saldo</a>

            </div>
            <div class="col-md-7">
                <form action="transaksi_export_excel.php" method="get" class="pull-right">
                    <div class="form-inline">
                        <label>Bulan</label>
                        <select name="bulan" class="form-control">
                            <option value="">--Pilih Bulan--</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                        <button class="btn btn-warning"><i class="fa fa-print"></i> Export</button>
                    </div>
                </form>
            </div>
        </div>


        <div class="h3"></div>

        <div class="row">
            <div class="col-md-12">
                <form action="" class="form-inline">
                    <label>Filter:</label>
                    <?php
                    $q_pembayaran = mysql_query("SELECT * FROM pembayaran WHERE id != '1' ORDER BY tanggal DESC");

                    ?>
                    <select name="filter" class="form-control">
                        <option value=""></option>
                        <option value="topup-1-Top Up">Top Up</option>
                        <optgroup label="Siswa telah melakukan pembayaran">
                            <?php while($data_pembayaran_telah = mysql_fetch_object($q_pembayaran)): ?>
                                <option value="already-<?php echo $data_pembayaran_telah->id; ?>-<?php echo $data_pembayaran_telah->nama; ?>"><?php echo $data_pembayaran_telah->nama; ?> - <?php echo tanggal_format_indonesia($data_pembayaran_telah->tanggal); ?></option>
                            <?php endwhile; ?>
                        </optgroup>
                    </select>
                    <button class="btn btn-success">Apply</button>
                    <?php echo $filter_string; ?>
                </form>
            </div>
        </div>

        <div class="h3"></div>

        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-12">
                <div class="box box-success">
                    <div class="box-header">
                        <i class="fa fa-tree"></i>
                        <h3 class="box-title">Transaksi</h3>
                    </div>
                    <div class="box-body">
                        <table class="table datatable-simple">
                            <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Tipe</th>
                                <th>Nama Siswa</th>
                                <th>Jumlah</th>
                                <th>Pembayaran</th>
                                <th>Cetak</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                                while($transaksi = mysql_fetch_object($q_transaksi)):
                            ?>
                            <tr class="<?php echo $transaksi->tipe == 'in' ? 'success' : 'danger' ?>">
                                <td><?php echo tanggal_format_indonesia($transaksi->tanggal); ?></td>
                                <td><?php echo $transaksi->tipe; ?></td>
                                <td><a href="siswa_detail.php?id=<?php echo $transaksi->id_siswa; ?>"><?php echo $transaksi->nama_siswa; ?></a></td>
                                <td><?php echo format_rupiah($transaksi->jumlah); ?></td>
                                <td><?php echo $transaksi->nama_pembayaran; ?></td>
                                <td><a href="detail_transaksi_export_pdf.php?id=<?php echo $transaksi->id; ?>&id_siswa=<?php echo $transaksi->id_siswa; ?>" class="btn btn-xs btn-info"><i class="fa fa-print"></i> </a> </td>
                            </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div><!-- /.distro -->
                </div>
            </section><!-- /.Left col -->
        </div>

        <?php if($dual_table): ?>
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-12">
                <div class="box box-success">
                    <div class="box-header">
                        <i class="fa fa-tree"></i>
                        <h3 class="box-title"> Siswa yg Belum melakukan Transaksi</h3>
                    </div>
                    <div class="box-body">
                        <table class="table datatable-simple">
                            <thead>
                            <tr>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $q_transaksi_notyet = mysql_query("SELECT siswa.id, siswa.nama as nama_siswa, siswa.nis
                                                                    FROM siswa
                                                                    LEFT JOIN transaksi ON siswa.id=transaksi.id_siswa AND id_pembayaran='$id'
                                                                    WHERE transaksi.id_siswa IS NULL ");

                            while($transaksi_notyet = mysql_fetch_object($q_transaksi_notyet)):
                                ?>
                                <tr>
                                    <td><?php echo $transaksi_notyet->nis; ?></td>
                                    <td><a href="siswa_detail.php?id=<?php echo $transaksi_notyet->id; ?>"><?php echo $transaksi_notyet->nama_siswa; ?></a></td>
                                </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div><!-- /.distro -->
                </div>
            </section><!-- /.Left col -->
        </div>
        <?php endif; ?>
    </section>

<?php include('inc/footer.php'); ?>

<script type="text/javascript">
    $('#table-items').dataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": false,
        "bSort": false,
        "bInfo": false,
        "bAutoWidth": true,
        "iDisplayLength": 100
    });
</script>