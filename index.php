<?php
    $title = 'Home' ;
include("inc/header.php");

require_once('lib/connection.php');
require_once('lib/unleashed.lib.php');

?>

    <section id="home-header">
        <div  class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="big-title"><a href="index.php">SMK Negeri 6</a></div>
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


            <div class="row">
                <div class="col-md-7">

                    <h6></h6>
                    <img src="assets/img/logo.png" class="img-responsive center-block">

                </div>
                <div class="col-md-4">
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
                        $qpembayaran = mysql_query("SELECT * FROM pembayaran WHERE nama!='Topup' ORDER BY created_at DESC LIMIT 10");
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
                    <a href="guru/index.php" class="btn btn-xs btn-info">Login Guru</a>
                </div>
            </div>
        </div>
    </section>


<?php include("inc/footer.php"); ?>
