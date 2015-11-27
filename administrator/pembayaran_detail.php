<?php

/**
 * # hanya admin yg bisa ganti logo
 * # hanya pegawai dengan status pemilik yang bisa tambah pegawai
 * # pemilik hanya dapat mengubah alamat, kota, telepon, email, link pada distro
 * # hanya pemilik yang dapat mengubah data pegawai
 * # petugas bisa isi item
 */

    ob_start();
    session_start();
    require_once('../lib/connection.php');
    require_once('../lib/unleashed.lib.php');
    require_once('../lib/login.php');

    require_once('inc/header.php');

    $success = '';
    $error = '';
    $filename = '';
    $now = now();

    // jika ada id
    if(array_key_exists('id', $_GET))
    {
        $id = escape($_GET['id']);
        $pembayaran = get_row_by_id('pembayaran', 'id', $id);

        // init
        if($pembayaran == FALSE)
        {
            redirect('lokasi.php');
            exit;
        }
    }

    // jika ada submit post
    if(array_key_exists('key', $_POST))
    {
        $submit_type = $_POST['submit_type'];

        // post update lokasi
        if($submit_type == 'update')
        {

            // simpan data ke database
            $q = sprintf("UPDATE pembayaran SET
                            nama=UPPER('%s'),
                            waktu=UPPER('%s'),
                            lama=UPPER('%s'),
                            deskripsi='%s',
                            id_petugas='%s'
                            WHERE id='$id'",
                escape($_POST['nama']),
                escape($_POST['waktu']),
                escape($_POST['lama']),
                escape($_POST['deskripsi']),
                $logged_id
            );

            // jalankan query
            $r = mysql_query($q);

            if(!$q)
                $error = 'Kesalahan Server';
            else
            {
                redirect("pembayaran_detail.php?id=$id"); // redirect ke detail
            }
        } // ./update-lokasi
        // update fasilitas
        elseif($submit_type == 'delete-pembayaran')
        {
           $q = mysql_query("DELETE FROM pembayaran WHERE id='$id'");

            if($q)
            {
                redirect('pembayaran.php?info=success-delete-pembayaran');
            }
            else
            {
                $error = 'Gagal Hapus Pembayaran';
            }
        }
    }

?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pembayaran
            <small><?php echo $pembayaran->nama; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="lokasi.php"><i class="fa fa-calendar"></i> Pembayaran</a></li>
            <li class="active"><?php echo $pembayaran->nama; ?></li>
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
            <section class="col-lg-12">
                <div class="box box-success">
                    <div class="box-header">
                        <i class="fa fa-flash"></i>
                        <h3 class="box-title"><?php echo $pembayaran->nama; ?></h3>
                        <div class="box-tools pull-right">
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body distro-profile">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Tanggal Pembayaran</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?php echo tanggal_format_indonesia($pembayaran->tanggal); ?></td>
                                <td><?php echo format_rupiah($pembayaran->jumlah); ?></td>
                                <td><?php echo html_entity_decode($pembayaran->keterangan); ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div><!-- /.distro -->
                </div>
            </section><!-- /.Left col -->
        </div><!-- /.row (main row) -->



        <!-- Third Row -->
        <section class="row" id="section-3">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <div class="box-title">Transaksi <?php echo $pembayaran->nama; ?></div>
                    </div>
                    <div class="box-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Tanggal Pembayaran</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $q_transaksi = mysql_query("SELECT siswa.nama as nama_siswa, siswa.nis, transaksi.tanggal
                                                        FROM transaksi
                                                        JOIN siswa ON siswa.id=transaksi.id_siswa
                                                        WHERE transaksi.id_pembayaran='$pembayaran->id'
                                                        ORDER BY tanggal DESC");
                                while($transaksi = mysql_fetch_object($q_transaksi)):
                            ?>
                            <tr>
                                <td><?php echo $transaksi->nis; ?></td>
                                <td><?php echo $transaksi->nama_siswa; ?></td>
                                <td><?php echo tanggal_format_indonesia($transaksi->tanggal, TRUE); ?></td>
                            </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <div class="pull-right">
            <form action="pembayaran_detail.php?id=<?php echo $id; ?>#delete" method="post" id="delete-pembayaran">
                <button class="btn btn-xs btn-danger" name="id" value="<?php echo $id; ?>">Hapus</button>
                <input type="hidden" name="submit_type" value="delete-pembayaran">
                <input type="hidden" name="key" value="<?php echo crypt('bulbasaur', '$l$bulbasaur-rfid$'); ?>">
            </form>
        </div>
    </section><!-- /.content -->

<?php include('inc/footer.php'); ?>

<script src="../assets/js/plugins/datepicker/bootstrap-datepicker.js"></script>

<script type="text/javascript">


    $('.tanggal').datepicker()

    $('#u-pembayaran').click(function(){
        $("html, body").animate({ scrollTop: $('#section-3').offset().top }, 1000);
    });

    $('#delete-pembayaran').submit(function(){
        var c = confirm('Apakah anda yakin menghapus pembayaran ini?');

        if(c == false){
            return false;
        }
    });


</script>