<?php
/**
 * Created by PhpStorm.
 * User: phi314
 * Date: 11/17/14
 * Time: 1:22 AM
 */
require_once('../lib/connection.php');
require_once('../lib/unleashed.lib.php');

$lokasi = get_all('lokasi', 'nama');
$json = array();
while($data = mysql_fetch_object($lokasi)):
    $array = array(
        'id'    => $data->id,
        'tipe_lokasi'    => $data->tipe_lokasi,
        'nama'  => $data->nama,
        'alias'  => $data->alias,
        'alamat'=> $data->alamat,
        'lg'    => $data->lg,
        'lt'    => $data->lt
    );
    array_push($json, $array);

endwhile;

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo json_encode($json);