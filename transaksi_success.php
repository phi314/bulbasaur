<?php

ob_start();
session_start();
require_once('lib/connection.php');
require_once('inc/header.php');

$status = FALSE;
$success = '';
$error = '';

if(isset($_GET['kode_transaksi']))
{
    $kode = $_GET['kode_transaksi'];

    $q = mysql_query("SELECT transaksi.*, siswa.nis, siswa.nama as nama_siswa, siswa.saldo, siswa.telepon, pembayaran.nama as nama_pembayaran
                      FROM transaksi
                      JOIN siswa ON siswa.id=transaksi.id_siswa
                      JOIN pembayaran ON pembayaran.id=transaksi.id_pembayaran
                      WHERE kode = '$kode'
                      LIMIT 1");

    if(mysql_num_rows($q) == 0)
    {
        redirect('transaksi_create.php');
        exit;
    }

    $transaksi = mysql_fetch_object($q);

    if(!empty($transaksi->telepon))
    {
        if($transaksi->sms_notification == 0)
        {
            include "lib/smsGateway.php";
            $smsGateway = new SmsGateway('kucingtelor212@gmail.com', 'telortaring');

            $deviceID = 15507;
            $number = $transaksi->telepon;

            $message = "[SMKN6GARUT] Terima kasih telah melakukan transaksi pembayaran $transaksi->nama_pembayaran sebesar $transaksi->jumlah pada $transaksi->tanggal.";

            $options = [

                'send_at' => strtotime('+1 minutes'), // Send the message in 5 minutes
                'expires_at' => strtotime('+1 hour') // Cancel the message in 1 hour if the message is not yet sent

            ];

            $send = $smsGateway->sendMessageToNumber($number, $message, $deviceID, $options);
            mysql_query("UPDATE transaksi SET sms_notification='1' WHERE id='$transaksi->id'");
        }
    }
}
else
{
    redirect('transaksi_create.php');
}

?>

    <!-- Main content -->
    <section id="home-header" class="container">

        <div class="row">
            <div class="col-md-8">
                <div class="big-title">SMK Negeri 6</div>
                <div class="big-subtitle">Kota Garut</div>
            </div>
            <div class="col-md-4">
                <div class="clock">
                    <div id="Date"></div>
                    <ul>
                        <li id="hours"></li>
                        <li id="point">:</li>
                        <li id="min"></li>
                        <li id="point">:</li>
                        <li id="sec"></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-lg-12">
                <div class="alert alert-success">
                    <i class="fa fa-info"></i>
                    <strong>Berhasil Melakukan Transaksi</strong>
                </div>
                <table class="table datatable-simple">
                    <thead>
                    <tr>
                        <th>Nis</th>
                        <th>Nama</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Pembayaran</th>
                        <th>Saldo Akhir</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php echo $transaksi->nis; ?></td>
                        <td><?php echo $transaksi->nama_siswa; ?></td>
                        <td><?php echo format_rupiah($transaksi->jumlah); ?></td>
                        <td><?php echo tanggal_format_indonesia($transaksi->tanggal); ?></td>
                        <td><?php echo $transaksi->nama_pembayaran; ?></td>
                        <td><?php echo format_rupiah($transaksi->saldo); ?></td>
                    </tr>
                    </tbody>
                </table>
            </div><!-- /.Left col -->
        </div><!-- /.row (main row) -->
    </section><!-- /.content -->

<?php include('inc/footer.php'); ?>

<script type="text/javascript">
    // Your application has indicated there's an error
    window.setTimeout(function(){

        // Move to a new location or you can do something else
        window.location.href = base_url + 'transaksi_choose.php';

    }, 5000);

</script>