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

        <a class="btn btn-primary" href="transaksi_create.php"><i class="fa fa-plus"></i> Tambah Transaksi</a>
        <a class="btn btn-warning" href="transaksi_topup.php"><i class="fa fa-angle-double-up"></i> Top-up Saldo</a>

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

                        <table class="table datatable-simple">
                            <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                                <th>Tipe</th>
                                <th>Event</th>
                                <th>Guru</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $facilities = mysql_query("SELECT * FROM transaksi ORDER BY created_at DESC");
                                while($facility = mysql_fetch_object($facilities)):

                                $highligtht = '';
                                // untuk highlight
                                if(!empty($_GET['id']) AND empty($_POST))
                                {
                                    // jika id sama dengan GET id
                                    if($facility->id == $_GET['id'])
                                        $highligtht = 'list-group-item-success';
                                }

                            ?>
                            <tr class="<?php echo $highligtht; ?>">
                                <td><?php echo $facility->nama; ?></td>
<!--                                <td>-->
<!--                                    <div class="btn-group">-->
<!--                                        <button class="btn btn-xs btn-warning">Update</button>-->
<!--                                        <button class="btn btn-xs btn-danger">Hapus</button>-->
<!--                                    </div>-->
<!--                                </td>-->
                            </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div><!-- /.distro -->
                </div>
            </section><!-- /.Left col -->

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