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
    if($submit_type == 'add_topup')
    {
        $id_siswa = escape($_POST['id_siswa']);
        $q_siswa = get_by_id('siswa', 'id', $id_siswa, FALSE, 'ASC', 1);
        $siswa = mysql_fetch_object($q_siswa);
        $jumlah = escape($_POST['jumlah']);

        $saldo_akhir = $siswa->saldo + $jumlah;

        $kode = hash('crc32', now().$id_siswa.$_SESSION['logged_id']);
        $q_t_pembayaran = sprintf("INSERT INTO transaksi(kode, tipe, jumlah, id_siswa, id_pembayaran, saldo_akhir, id_guru, tanggal, created_at)
                                        VALUES('%s', '%s', '%d', '%s','%s', '%s', '%s', '%s', '%s')",
            $kode,
            'in',
            $jumlah,
            $id_siswa,
            1,
            $saldo_akhir,
            $_SESSION['logged_id'],
            now(),
            now()
        );

        $r_t_pembayaran = mysql_query($q_t_pembayaran);

        $q_update_saldo_siswa = mysql_query("UPDATE siswa SET saldo='$saldo_akhir' WHERE id='$id_siswa'");

        redirect('transaksi.php');
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

        <div class="form-group">
            <input type="text" id="topup-rfid" name="topup-rfid" class="form-control input-lg" placeholder="Tap RFID">
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
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Saldo</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td id="topup-nis"></td>
                                <td id="topup-nama"></td>
                                <td id="topup-kelas"></td>
                                <td id="topup-saldo"></td>
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

                    </div><!-- /.distro -->
                </div>
            </section><!-- /.Left col -->

            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-4">
                <div class="box box-warning" id="list-tambah-fasilitas">
                    <div class="box-header">
                        <i class="ion ion-plus"></i>
                        <h3 class="box-title">TopUp</h3>
                    </div><!-- /.box-header -->
                    <form action="" method="post" id="form-topup">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Jumlah</label>
                                <input type="text" name="jumlah" class="form-control" id="topup-jumlah">
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <input type="hidden" name="id_siswa" id="id_siswa">
                            <input type="hidden" value="<?php echo sha1(date('ymdhis')); ?>" name="key">
                            <input type="hidden" value="add_topup" name="submit_type">
                            <button class="btn btn-primary">Simpan</button>
                        </div><!-- /.box-footer -->
                    </form>
                </div><!-- /.kategori -->
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

    $('#topup-rfid').focus();

    $('#topup-rfid').change(function(){
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
                    $('#topup-nis').text(data.nis);
                    $('#topup-nama').text(data.nama);
                    $('#topup-saldo').text(data.saldo_format_rupiah);
                    $('#id_siswa').val(data.id);
                    $('#topup-jumlah').focus();
                }
                else
                {
                    $('#topup-rfid').val('');
                    $('#topup-nis').text('');
                    $('#topup-nama').text('');
                    $('#topup-rfid').focus();
                }

            }
        });
    });

    $('#form-topup').submit(function(){
        var c = confirm('Apakah anda yakin membuat transaksi ini?');

        if(c == false){
            return false;
        }
    });
</script>