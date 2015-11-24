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

    $q = mysql_query("SELECT id, rfid, nis, nama, jk FROM siswa WHERE rfid='$rfid' LIMIT 1");
    $r = mysql_fetch_object($q);

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

        $absensi = FALSE;

        $q_absensi = mysql_query("SELECT * FROM absensi WHERE tanggal='$date_now' AND id_siswa='$r->id'");

        /*
         * Cek apakah siswa belum masuk absensi
         */
        if(mysql_num_rows($q_absensi) == 0)
        {
            // insert absensi siswa
            mysql_query("INSERT INTO absensi(id_siswa, tanggal, jam_masuk, absen, created_at) VALUES('$r->id', '$date_now', '$time_now', 'HADIR', '$now')");

            $id_absensi = mysql_insert_id();
            $absensi = TRUE;
        }

        /*
         * Cek pulang
         */
        if($time_now > $jam_pulang)
        {
            mysql_query("UPDATE absensi SET jam_pulang='$time_now' WHERE id_siswa='$r->id' AND tanggal='$date_now'");
            $absensi = TRUE;
        }

        $q_absensi1 = mysql_query("SELECT * FROM absensi WHERE tanggal='$date_now' AND id_siswa='$r->id'");
        $r_absensi = mysql_fetch_object($q_absensi1);

        $json = [
            'status'    => TRUE,
            'id'        => $r->id,
            'rfid'      => $r->rfid,
            'nis'       => $r->nis,
            'nama'      => $r->nama,
            'jk'        => $r->jk,
            'jam_masuk' => $r_absensi->jam_masuk,
            'jam_pulang' => $r_absensi->jam_pulang,
            'now'       => $time_now,
            'absensi'   => $absensi,
            'id_absensi' => $id_absensi,
            'keterangan' => ''
        ];
    }
}


header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo json_encode($json);