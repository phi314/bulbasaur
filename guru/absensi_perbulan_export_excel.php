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

if(!empty($_POST['id_kelas']) && !empty($_POST['id_pelajaran']))
{
    $id_kelas = escape($_POST['id_kelas']);
    $id_pelajaran = escape($_POST['id_pelajaran']);
    $id_guru = $_SESSION['logged_id'];

    $q = mysql_query("SELECT absensi.*, pelajaran.nama as nama_pelajaran, kelas.tingkat, kelas.nama as nama_kelas, kelas.tahun FROM absensi
                        JOIN pelajaran ON pelajaran.id=absensi.id_pelajaran
                        JOIN kelas ON kelas.id=absensi.id_kelas
                        WHERE absensi.id_kelas='$id_kelas' AND absensi.id_pelajaran='$id_pelajaran' AND absensi.id_guru='$id_guru' LIMIT 1");


    if(mysql_num_rows($q) != 0)
    {
        $d_detail = mysql_fetch_object($q);
        $file = 'laporan_absensi_'.$d_detail->tingkat.'_'.$d_detail->nama_kelas.'_'.$d_detail->tahun.'_pelajaran_'.$d_detail->nama_pelajaran.'_'.date('YmdHis').'.xls';
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file");

        $absensi_siswa = [];

        ?>

        <table>
            <thead>
            <tr>
                <th colspan="6">Absensi <?php echo $d_detail->nama_pelajaran; ?> Kelas <?php echo $d_detail->tingkat.'-'.$d_detail->nama_kelas.' ('.$d_detail->tahun.')'; ?></th>
            </tr>
            </thead>
        </table>

        <table>
            <thead>
            <tr>
                <th>No.</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <?php
                    $q_absensi = mysql_query("SELECT tanggal FROM absensi
                                                WHERE absensi.id_kelas='$id_kelas' AND absensi.id_pelajaran='$id_pelajaran' AND absensi.id_guru='$id_guru'");

                    while($d_absensi = mysql_fetch_object($q_absensi)):
                ?>
                    <th><?php echo tanggal_format_indonesia($d_absensi->tanggal); ?></th>
                <?php endwhile; ?>
            </tr>
            </thead>
            <tbody>
            <?php
                $no = 1;
                $q_siswa = mysql_query("SELECT * FROM siswa WHERE id_kelas='$id_kelas'");


                while($d_siswa = mysql_fetch_object($q_siswa))
                {
                    ?>
                        <tr>
                            <td><?php echo $no++; ?>.</td>
                            <td><?php echo $d_siswa->nis; ?></td>
                            <td><?php echo $d_siswa->nama; ?></td>
                            <?php
                            $q_absensi_2 = mysql_query("SELECT id FROM absensi
                                                WHERE absensi.id_kelas='$id_kelas' AND absensi.id_pelajaran='$id_pelajaran' AND absensi.id_guru='$id_guru'");

                            while($d_absensi_2 = mysql_fetch_object($q_absensi_2)):
                                    $q_hadir = mysql_query("SELECT * FROM absensi_detail WHERE id_absensi='$d_absensi_2->id' AND id_siswa='$d_siswa->id' LIMIT 1");
                            ?>
                                <td><?php echo mysql_num_rows($q_hadir) == 1 ? "YA" : "X"; ?></td>
                            <?php endwhile; ?>
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