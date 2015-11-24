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

if(!isset($_SESSION['id_pembayaran']))
{
    redirect('transaksi_choose.php');
}
else
{
    $id_pembayaran = $_SESSION['id_pembayaran'];
}

$qpembayaran = get_by_id('pembayaran', 'id', $id_pembayaran, FALSE, 'ASC', 1);
$pembayaran = mysql_fetch_object($qpembayaran);

// post tambah
if(array_key_exists('key', $_POST))
{
    $submit_type = $_POST['submit_type'];
    // Ajax Add
    if($submit_type == 'add_session_id_pembayaran')
    {
        $id_pembayaran = escape($_POST['id']);
        $_SESSION['id_pembayaran'] = $id_pembayaran;
    }
    elseif($submit_type == 'add_transaksi')
    {
        $id_siswa = escape($_POST['id_siswa']);
        $q_siswa = get_by_id('siswa', 'id', $id_siswa, FALSE, 'ASC', 1);
        $siswa = mysql_fetch_object($q_siswa);
        $jumlah = $pembayaran->jumlah;


        // check jika siswa sudah membayar
        $q_val_cek = mysql_query("SELECT * FROM transaksi WHERE id_siswa='$siswa->id' AND id_pembayaran='$id_pembayaran'");

        if(mysql_num_rows($q_val_cek) == 0)
        {
            // jika saldo tidak mencukupi
            if($siswa->saldo < $jumlah)
            {
                $error = 'Saldo tidak Mencukupi';
            }
            else
            {

                $saldo_akhir = $siswa->saldo - $jumlah;

                $kode = hash('crc32', now().$id_siswa.$id_pembayaran);
                $q_t_pembayaran = sprintf("INSERT INTO transaksi(kode, tipe, jumlah, id_siswa, id_pembayaran, saldo_akhir, id_guru, tanggal, created_at)
                                        VALUES('%s', '%s', '%d', '%s','%s', '%s', '%s', '%s', '%s')",
                    $kode,
                    'out',
                    $jumlah,
                    $id_siswa,
                    $id_pembayaran,
                    $saldo_akhir,
                    $_SESSION['logged_id'],
                    now(),
                    now()
                );

                $r_t_pembayaran = mysql_query($q_t_pembayaran);

                $q_update_saldo_siswa = mysql_query("UPDATE siswa SET saldo='$saldo_akhir' WHERE id='$id_siswa'");

                $error = 'Berhasil Transaksi';

                unset($_SESSION['id_pembayaran']);

                redirect("transaksi.php?info=$error");

            }
        }
        else
        {
            $error = 'Siswa sudah melakukan Pembayaran ini sebelumnya';
        }

    }
    elseif($submit_type == 'clear_pembayaran')
    {
        unset($_SESSION['id_pembayaran']);

        redirect('transaksi_choose.php');
    }
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
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-8">
                <div class="box box-warning">
                    <div class="box-header">
                        <i class="fa fa-calendar"></i>
                        <h3 class="box-title">Pembayaran</h3>
                    </div>
                    <div class="box-body">

                        <?php if(!empty($error)): ?>
                            <div class="alert alert-danger">
                                <i class="fa fa-warning"></i>
                                <strong><?php echo $error; ?></strong>
                            </div>
                            <script>

                            </script>
                        <?php endif; ?>

                        <h2><?php echo $pembayaran->nama; ?></h2>
                        <h1><?php echo format_rupiah($pembayaran->jumlah); ?></h1>
                        <h3><?php echo tanggal_format_indonesia($pembayaran->tanggal); ?></h3>
                    </div><!-- /.distro -->
                    <div class="box-footer">
                        <form action="transaksi_create.php" method="post" class="hidden" id="form-transaksi">
                            <input type="hidden" name="id_pembayaran" value="<?php echo $id_pembayaran; ?>">
                            <input type="hidden" name="id_siswa" id="id_siswa">
                            <input type="hidden" name="submit_type" value="add_transaksi">
                            <input type="hidden" name="key" value="bulbasaur-transaksi">
                            <button class="btn btn-lg btn-primary btn-block">Bayar <?php echo $pembayaran->nama; ?></button>
                        </form>
                        <form action="transaksi_create.php" method="post" id="form-cancel">
                            <input type="hidden" name="id_pembayaran" value="<?php echo $id_pembayaran; ?>">
                            <input type="hidden" name="submit_type" value="clear_pembayaran">
                            <input type="hidden" name="key" value="bulbasaur-transaksi">
                            <button class="btn btn-lg btn-warning btn-block">Ganti Pembayaran</button>
                        </form>
                    </div>
                </div>
            </section><!-- /.Left col -->
            <!-- Left col -->
            <section class="col-lg-4">
                <div class="box box-warning">
                    <div class="box-header">
                        <i class="fa fa-calendar"></i>
                        <h3 class="box-title">Detail Siswa</h3>
                    </div>
                    <div class="list-group">
                       <div class="list-group-item">
                           <input type="text" name="transaksi-rfid" id="transaksi-rfid" class="form-control">
                       </div>
                        <div class="list-group-item">
                            <strong>NIS</strong>
                            <h3 id="transaksi-nis"></h3>
                        </div>
                        <div class="list-group-item">
                            <strong>Nama</strong>
                            <h3 id="transaksi-nama"></h3>
                        </div>
                        <div class="list-group-item">
                            <strong>Kelas</strong>
                            <h3 id="transaksi-kelas"></h3>
                        </div>
                        <div class="list-group-item">
                            <strong>Saldo</strong>
                            <h3 id="transaksi-saldo"></h3>
                        </div>
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


    $('#transaksi-rfid').focus();

    $('#transaksi-rfid').change(function(){
        var rfid = $(this).val();

        $.ajax({
            url: base_url + 'services/detail_siswa_by_rfid.php',
            type: 'get',
            data: {
                rfid: rfid
            },
            dataType: 'json',
            success: function(data){
                if(data.status == true)
                {
                    $('#transaksi-nis').text(data.nis);
                    $('#transaksi-nama').text(data.nama);
                    $('#transaksi-saldo').text(data.saldo_format_rupiah);
                    $('#form-transaksi').removeClass('hidden');
                    $('#id_siswa').val(data.id);
                    $('#form-transaksi').submit();
                }
                else
                {
                    $('#transaksi-rfid').val('');
                    $('#transaksi-nis').text('');
                    $('#transaksi-nama').text('');
                    $('#transaksi-rfid').focus();
                }

            }
        });
    });

    $('#form-transaksi').submit(function(){
        var c = confirm('Apakah anda yakin membayar transaksi ini?');

        if(c == false){
            return false;
        }
    });

</script>