<?php

ob_start();
session_start();
require_once('lib/connection.php');
require_once('inc/header.php');

$status = FALSE;
$success = '';
$error = '';

if(isset($_SESSION['id_pembayaran']))
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
                <h3>Pilih Pembayaran</h3>
                <table class="table datatable-simple">
                    <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
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
                                <button class="btn btn-warning btn-xs" name="id" value="<?php echo $pembayaran->id; ?>">Pilih</button>
                                <input type="hidden" name="submit_type" value="add_session_id_pembayaran">
                                <input type="hidden" name="key" value="bulbasaur">
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div><!-- /.Left col -->
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