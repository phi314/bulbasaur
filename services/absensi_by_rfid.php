<?php
/**
 * Created by PhpStorm.
 * User: phi314
 * Date: 11/17/14
 * Time: 1:22 AM
 */
require_once('../lib/connection.php');
require_once('../lib/unleashed.lib.php');

$json = [
    'status'    => FALSE
];

if(isset($_GET['rfid']))
{
    $rfid = escape($_GET['rfid']);

    $kelas = '';

    $q = mysql_query("SELECT id, rfid, nis, siswa.nama, jk, id_kelas  FROM siswa WHERE siswa.rfid='$rfid' LIMIT 1");

    $r = mysql_fetch_object($q);

    if($r->id_kelas != 0)
    {
        $q_kelas = mysql_query("SELECT * FROM kelas WHERE id='$r->id_kelas' LIMIT 1");

        $d_kelas = mysql_fetch_object($q_kelas);

        $kelas = $d_kelas->tingkat.'-'.$d_kelas->nama.' ('.$d_kelas->tahun.')';
    }

    $id_absensi = FALSE;

    if(mysql_num_rows($q) == 0)
    {
        $json = [
            'status'    => FALSE
        ];
    }
    else
    {
        include_once('../lib/settings.php');

        $jam_masuk = $settings['max_jam_masuk'];
        $jam_pulang = $settings['min_jam_pulang'];

        $date_now = date('y-m-d');
        $time_now = date('H:i:s');
        $now = now();

        $keterangan = "Sudah Absen";

        $absensi = FALSE;

        $q_absensi = mysql_query("SELECT * FROM absensi WHERE tanggal='$date_now' AND id_siswa='$r->id'");

        /*
         * Cek apakah siswa belum masuk absensi
         */
        if(mysql_num_rows($q_absensi) == 0)
        {
            // insert absensi siswa
            mysql_query("INSERT INTO absensi(id_siswa, tanggal, jam_masuk, absen, created_at) VALUES('$r->id', '$date_now', '$time_now', 'HADIR', '$now')");

            $keterangan = "Selamat Datang";

            $absensi = TRUE;
        }

        /*
         * Cek pulang
         */
        if($time_now > $jam_pulang)
        {
            $q_val_pulang = mysql_query("SELECT jam_pulang FROM absensi WHERE id_siswa='$r->id' AND tanggal='$date_now' AND jam_pulang='00:00:00'");
            if(mysql_num_rows($q_val_pulang) == 1)
            {
                mysql_query("UPDATE absensi SET jam_pulang='$time_now' WHERE id_siswa='$r->id' AND tanggal='$date_now'");

                $keterangan = 'Sudah Pulang';

                $absensi = TRUE;
            }
        }

        $q_absensi1 = mysql_query("SELECT * FROM absensi WHERE tanggal='$date_now' AND id_siswa='$r->id'");
        $r_absensi = mysql_fetch_object($q_absensi1);

        $json = [
            'status'    => TRUE,
            'id'        => $r->id,
            'rfid'      => $r->rfid,
            'nis'       => $r->nis,
            'nama'      => $r->nama,
            'kelas'     => $kelas,
            'jk'        => $r->jk,
            'jam_masuk' => $r_absensi->jam_masuk,
            'jam_pulang' => $r_absensi->jam_pulang,
            'now'       => $time_now,
            'absensi'   => $absensi,
            'id_absensi' => $r_absensi->id,
            'keterangan' => $keterangan
        ];
    }
}


header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo json_encode($json);