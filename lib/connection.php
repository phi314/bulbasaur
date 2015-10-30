<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$SERVER = 'localhost';
$USERNAME = 'root';
$PASSWORD = '';
$DB = 'bulbasaur_rfid';

$conn = mysql_connect($SERVER, $USERNAME, $PASSWORD) or die('Cannot Connect Database');
$db = mysql_select_db($DB) or die('No Database');


