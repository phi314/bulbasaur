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

// post tambah
if(array_key_exists('key', $_POST))
{
    $submit_type = $_POST['submit_type'];
    // Ajax Add
    if($submit_type == 'add_facility')
    {
        $nama = escape($_POST['nama']); // nama fasilitas
        $cek1 = get_row_by_id('fasilitas', 'nama', $nama);
        // jika belum ada fasilitas dengan nama yg diinputkan
        if($cek1 == FALSE)
        {
            // simpan data ke database
            $q = sprintf("INSERT INTO fasilitas(
                        nama,
                        created_date
                        )
                        VALUES(UPPER('%s'),'%s')",
                $nama,
                now()
            );

            // jalankan query
            $r = mysql_query($q);

            // jika kesalahan query atau database
            if(!$q)
            {
                $status = FALSE;
                $error = 'Kesalahan Database';
            }
            else
            {
                $status = TRUE;
                $error = '';
                $id = mysql_insert_id();
                redirect('fasilitas.php?add=true&nama='.$nama.'&id='.$id);
            }
        }
        else
        {
            $status = FALSE;
            $error = 'Fasilitas '.$nama.', sudah ada';
        }
    }
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
                </div>
            </section><!-- /.Left col -->
        </div>
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