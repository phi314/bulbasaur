<?php
/**
 * Created by PhpStorm.
 * User: phi314
 * Date: 12/9/15
 * Time: 11:58 AM
 */

ob_start();
session_start();
require_once('../lib/connection.php');
require_once('../lib/unleashed.lib.php');
require_once('../lib/login.php');

if(!empty($_GET['id']) && !empty($_GET['id_siswa']))
{
    $id = escape($_GET['id']);
    $id_siswa = escape($_GET['id_siswa']);

    $q = mysql_query("SELECT transaksi.*, siswa.*, siswa.nama as nama_siswa, pembayaran.nama as nama_pembayaran FROM transaksi
            JOIN siswa ON siswa.id=transaksi.id_siswa
            JOIN pembayaran ON pembayaran.id=transaksi.id_pembayaran
            WHERE transaksi.id='$id'
            LIMIT 1");

    if(mysql_num_rows($q) == 1)
    {
        $r = mysql_fetch_object($q);
    }
    else
    {
        redirect("siswa_detail.php?id=$id_siswa");
    }
}
else
{
    redirect("siswa.php");
}

?>

<style>
    .heading {
        font-size: 18px;
        background-color: lightgray;
        padding: 20px;
    }

    .h2 {height: 20px; }
    .h5 {height: 50px; }

    .tandatangan {
        width: 100%;
        margin: 50px 800px;
    }
</style>

<page>
    <table style="width: 100%">
        <tr>
            <td style="width: 10%"><img src="../assets/img/logo.png"></td>
            <td style="width: 50%">
                <div style="font-size: 12pt">Laporan Transaksi</div>
                <div style="font-size: 24pt">SMK NEGERI 6 GARUT</div>
            </td>
            <td style="width: 40%">
                Dicetak pada tanggal: <?php echo tanggal_format_indonesia(now(), TRUE); ?>
            </td>
        </tr>
    </table>

    <div class="h5"></div>

    <div>
        <div class="heading">
            <b>Data Siswa</b>
        </div>
        <div class="h2"></div>
        <table style="width: 99%">
            <tr>
                <th style="width: 25%">NIS</th>
                <th style="width: 25%">Nama</th>
                <th style="width: 25%">kelas</th>
                <th style="width: 25%">Saldo</th>
            </tr>
            <tr>
                <td><?php echo $r->nis; ?></td>
                <td><?php echo $r->nama_siswa; ?></td>
                <td><?php echo kelas($r->id_kelas); ?></td>
                <td><?php echo format_rupiah($r->saldo); ?></td>
            </tr>
        </table>
    </div>

    <div class="h5"></div>

    <div>
        <div class="heading">
            <b>Data Pembayaran</b>
        </div>
        <div class="h2"></div>
        <table style="width: 99%">
            <tr>
                <th style="width: 25%">Kode Transaksi</th>
                <th style="width: 25%">Nama Pembayaran</th>
                <th style="width: 25%">Tanggal</th>
                <th style="width: 25%">Jumlah</th>
            </tr>
            <tr>
                <td><?php echo $r->kode; ?></td>
                <td><?php echo $r->nama_pembayaran; ?></td>
                <td><?php echo tanggal_format_indonesia($r->tanggal, TRUE); ?></td>
                <td><?php echo format_rupiah($r->jumlah); ?></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <div class="tandatangan">
            Petugas Tata Usaha,
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)

        </div>
    </div>

</page>

<?php
    $content = ob_get_clean();
    // convert in PDF
    require_once('../lib/html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('L', 'A4', 'fr');
    //      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('exemple00.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }