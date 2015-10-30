<?php
/**
 * Created by PhpStorm.
 * User: phi314
 * Date: 11/17/14
 * Time: 1:22 AM
 */
require_once('../lib/connection.php');
require_once('../lib/unleashed.lib.php');

$path = 'http://192.168.1.14/tamankota/assets/img/';




// jika hanya satu lokasi
if(isset($_GET['id']))
{
    $id = $_GET['id'];
    $lokasi = get_row_by_id('lokasi', 'id', $id);
    if($lokasi != FALSE)
    {
        $foto_link = $path.'imageNotFound.jpg';

        if(file_exists('../assets/img/foto_lokasi/'.$lokasi->foto_link))
            $foto_link = $path.'foto_lokasi/'.$lokasi->foto_link;

        $q_f_l = "SELECT fasilitas.* FROM fasilitas_lokasi JOIN fasilitas ON fasilitas.id=fasilitas_lokasi.id_fasilitas WHERE fasilitas_lokasi.id_lokasi='$id'";
        $r_f_l = mysql_query($q_f_l);
        $fasilitas = array();
        while($d_f_l = mysql_fetch_object($r_f_l)):
            array_push($fasilitas,$d_f_l->nama);
        endwhile;

        echo mysql_error();

        $json = array(
            'location' => array(
                'id'        => $lokasi->id,
                'tipe_lokasi'    => $lokasi->tipe_lokasi,
                'nama'      => $lokasi->nama,
                'alias'     => $lokasi->alias,
                'alamat'    => $lokasi->alamat,
                'deskripsi' => html_entity_decode($lokasi->deskripsi),
                'tahun'     => $lokasi->tahun,
                'foto_link' => $foto_link,
                'foto_links'=> $lokasi->foto_link,
                'lg'        => $lokasi->lg,
                'lt'        => $lokasi->lt,
                'fasilitas' => $fasilitas
            ),
            'review'    => ''
        );
    }
    else
        $json = FALSE;
}
// jika banyak lokasi
else
{
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
}

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo json_encode($json);