<?php
/**
 * Created by PhpStorm.
 * User: phi314
 * Date: 10/23/14
 * Time: 6:04 PM
 */

require_once('../lib/unleashed.lib.php');
session_start();
// buat log file
session_destroy();
header('location: ../index.php');