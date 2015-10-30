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
            <li><a href="transaksi.php"><i class="fa fa-database"></i> Transaksi</a></li>
            <li class="active">TopUp Saldo</li>
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

        <div class="form-group">
            <input type="text" name="rfid" class="form-control input-lg" placeholder="Tap RFID">
        </div>

        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-8">
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="fa fa-tree"></i>
                        <h3 class="box-title">Data Siswa</h3>
                    </div>
                    <div class="box-body">
                        <table id="table-items" class="table">
                            <thead>
                            <tr>
                                <th>Nama</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div><!-- /.distro -->
                </div>

                <div class="box box-primary">
                    <div class="box-header">
                        <i class="fa fa-database"></i>
                        <h3 class="box-title">Data Transaksi Siswa</h3>
                    </div>
                    <div class="box-body">
                        <table id="table-items" class="table">
                            <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Tipe</th>
                                <th>Jumlah</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div><!-- /.distro -->
                </div>
            </section><!-- /.Left col -->

            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-4">
                <?php
                    // hanya admin yg dapat menambah kategori
                    if(is_admin()):
                ?>
                <!-- Kategori List List -->
                <div class="box box-warning" id="list-tambah-fasilitas">
                    <div class="box-header">
                        <i class="ion ion-plus"></i>
                        <h3 class="box-title">TopUp</h3>
                    </div><!-- /.box-header -->
                    <form action="" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Jumlah</label>
                                <input type="text" name="jumlah" class="form-control">
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <input type="hidden" value="in" name="tipe">
                            <input type="hidden" value="1" name="event">
                            <input type="hidden" value="<?php echo sha1(date('ymdhis')); ?>" name="key">
                            <input type="hidden" value="add_facility" name="submit_type">
                            <button class="btn btn-primary">Simpan</button>
                        </div><!-- /.box-footer -->
                    </form>
                </div><!-- /.kategori -->
                <?php endif; ?>
            </section><!-- right col -->
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
    $('.dataTables_filter input').addClass("form-control"); // modify table search input
</script>