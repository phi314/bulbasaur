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

    $q = mysql_query("SELECT id, rfid, nis, nama, jk, saldo FROM siswa WHERE rfid='$rfid' LIMIT 1");
    $r = mysql_fetch_object($q);

    if(mysql_num_rows($q) == 0)
    {
        $json = [
            'status'    => FALSE
        ];
    }
    else
    {
        $q_transaksi = mysql_query("SELECT * FROM transaksi WHERE id_siswa='$r->id' ORDER BY tanggal DESC");
        $transaksi = mysql_fetch_object($q_transaksi);

        $json = [
            'status'    => TRUE,
            'id'        => $r->id,
            'rfid'      => $r->rfid,
            'nis'       => $r->nis,
            'nama'      => $r->nama,
            'jk'        => $r->jk,
            'saldo'     => $r->saldo,
            'saldo_format_rupiah'     => format_rupiah($r->saldo),
            'transaksi' => $transaksi
        ];
    }
}


header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo json_encode($json);