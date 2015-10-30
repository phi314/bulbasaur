<?php
/**
 * Created by PhpStorm.
 * User: phi314
 * Date: 11/17/14
 * Time: 1:22 AM
 * Sign user
 */
require_once('../lib/connection.php');
require_once('../lib/unleashed.lib.php');



$json = array();

if(array_key_exists('key', $_POST))
{
    $nama = escape($_POST['nama']);
    $email = escape($_POST['email']);
    $password = escape($_POST['password']);
    $password_enc = sha1($password);

    $useragent = escape($_POST['devices']);
    $signature = crypt(date('Ymdhis'),'$1$userfulofsomething$');

    $q = sprintf("INSERT INTO users(nama, email, password, devices, signature, created_date) VALUES('%s', '%s', '%s', '%s', '%s', '%s')",
                    $nama,
                    $email,
                    $password_enc,
                    $useragent,
                    $signature,
                    now()
    );

    $r = mysql_query($q);
    if($r != FALSE)
    {
        $json = array(
            'signature'     => $signature,
            'id_user'       => mysql_insert_id(),
            'nama'          => $nama,
            'status'        => TRUE
        );
    }
    else
    {
        $json = array(
            'status'        => FALSE,
            'error'         => 'Email Sudah Terdaftar.'
        );
    }

}



header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo json_encode($json);