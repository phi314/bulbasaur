<?php
/**
 * Created by PhpStorm.
 * User: phi314
 * Date: 11/17/14
 * Time: 1:22 AM
 *
 * Signature akan berbeda untuk setiap device
 */
require_once('../lib/connection.php');
require_once('../lib/unleashed.lib.php');

$lokasi = get_all('lokasi', 'nama');
$json = FALSE;
if(array_key_exists('submit_type', $_GET))
{
    switch($_GET['submit_type'])
    {
        // cek user login
        case 'cek_login':
            $id = $_GET['user_id'];
            $signature = $_GET['signature'];
            $q = "SELECT id FROM users WHERE id='$id' AND signature='$signature' LIMIT 1";
            $r = mysql_query($q);
            $d = mysql_fetch_object($r);
            // jika user ditemukan berarti user login pada device yang sama dengan sebelumnya
            if($d != FALSE)
            {
                $json = array(
                    'status_login'      => TRUE
                );
            }
            else
                $json = array(
                    'status_login'      => FALSE
                );
            break;
        // login user
        case 'login':
            $email = $_GET['email'];
            $devices = $_GET['devices'];
            $password = $_GET['password'];
            $password_enc = sha1($password);
            $q = "SELECT id, nama FROM users WHERE email='$email' AND password='$password_enc' LIMIT 1";
            $r = mysql_query($q);
            $d = mysql_fetch_object($r);
            if($d != FALSE)
            {
                $id = $d->id;
                $nama = $d->nama;
                // signature
                $signature = crypt(date('Ymdhis'),'$1$userfulofsomething$');
                mysql_query("UPDATE users SET signature='$signature', devices='$devices' WHERE id='$id'");

                $json = array(
                    'signature'     => $signature,
                    'id_user'       => $id,
                    'nama'          => $nama,
                    'status'        => TRUE
                );
            }
            else
            {
                $json = array(
                    'status'        => FALSE
                );
            }
            break;
    }

}

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo json_encode($json);