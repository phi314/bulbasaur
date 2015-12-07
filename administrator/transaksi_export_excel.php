<?php
/**
 * Created by PhpStorm.
 * User: phi314
 * Date: 12/7/15
 * Time: 11:40 AM
 */

ob_start();
session_start();
require_once('../lib/connection.php');
require_once('../lib/unleashed.lib.php');
require_once('../lib/login.php');

if(!empty($_GET['bulan']))
{
    $bulan = escape($_GET['bulan']);

    $q = mysql_query("SELECT transaksi.*, siswa.nama as nama_siswa, pembayaran.nama as nama_pembayaran FROM transaksi
                        JOIN siswa ON siswa.id = transaksi.id_siswa
                        JOIN pembayaran ON pembayaran.id = transaksi.id_pembayaran
                        WHERE MONTH(transaksi.tanggal)='$bulan' ORDER BY transaksi.tanggal ASC");


    if(mysql_num_rows($q) != 0)
    {
        $nama_bulan = getBulan($bulan);
        $file = 'laporan_transaksi_bulan_'.$nama_bulan.'_'.date('YmdHis').'.xls';
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file");

        ?>

        <table>
            <thead>
            <tr>
                <th colspan="6">Transaksi Bulan <?php echo $nama_bulan; ?></th>
            </tr>
            </thead>
        </table>

        <table>
            <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Nama Siswa</th>
                <th>Tipe</th>
                <th>Pembayaran</th>
                <th>Jumlah</th>
            </tr>
            </thead>
            <tbody>
            <?php
                $no = 1;
                while($data = mysql_fetch_object($q))
                {
                    ?>
                        <tr>
                            <td><?php echo $no++; ?>.</td>
                            <td><?php echo tanggal_format_indonesia($data->tanggal); ?></td>
                            <td><?php echo $data->nama_siswa; ?></td>
                            <td><?php echo $data->tipe; ?></td>
                            <td><?php echo $data->nama_pembayaran; ?></td>
                            <td><?php echo $data->jumlah; ?></td>
                        </tr>
                    <?php
                }
            ?>
            </tbody>
        </table>


        <?php
    }
    else
    {
//        redirect("transaksi.php?info=transaksi-kosong");
        var_dump($_GET['bulan']);
    }
}
else
{
    redirect("transaksi.php?info=silahkan-pilih-bulan");
}