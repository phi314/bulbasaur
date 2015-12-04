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

if(isset($_POST['rfid']) && $_POST['id_absensi'])
{
    $rfid = escape($_POST['rfid']);
    $id_absensi = escape($_POST['id_absensi']);

    $q = mysql_query("SELECT id, rfid, nis, siswa.nama, jk, id_kelas  FROM siswa WHERE siswa.rfid='$rfid' LIMIT 1");

    if(mysql_num_rows($q) == 1)
    {
        include_once('../lib/settings.php');

        $date_now = date('y-m-d');
        $time_now = date('H:i:s');
        $now = tanggal_format_indonesia(now());

        $r = mysql_fetch_object($q);

        $keterangan = "Sudah Absen";

        $absensi = FALSE;

        $q_absensi = mysql_query("SELECT * FROM absensi_detail WHERE id_absensi='$id_absensi' AND id_siswa='$r->id'");

        /*
         * Cek apakah siswa belum masuk absensi
         */
        if(mysql_num_rows($q_absensi) == 0)
        {
            // insert absensi siswa
            mysql_query("INSERT INTO absensi_detail(id_absensi, id_siswa, tanggal, jam_masuk, absen, created_at) VALUES('$id_absensi', '$r->id', '$date_now', '$time_now', 'HADIR', '$now')");

            $keterangan = "Selamat Datang";
            $absensi = TRUE;

            $json = [
                'status'    => TRUE,
                'id'        => $r->id,
                'rfid'      => $r->rfid,
                'nis'       => $r->nis,
                'nama'      => $r->nama,
                'jk'        => $r->jk,
                'time_now'       => $time_now,
                'date_now'       => $now,
                'absensi'       => $absensi,
                'id_absensi' => $id_absensi,
                'keterangan' => $keterangan
            ];

        }
        else
        {
            $json = [
                'status'    => TRUE,
                'id'        => $r->id,
                'rfid'      => $r->rfid,
                'nis'       => $r->nis,
                'nama'      => $r->nama,
                'jk'        => $r->jk,
                'time_now'       => $time_now,
                'date_now'       => $now,
                'absensi'       => $absensi,
                'id_absensi' => $id_absensi,
                'keterangan' => $keterangan
            ];
        }
    }
    else
    {
        $json = [
            'status'    => FALSE
        ];
    }


}


header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo json_encode($json);