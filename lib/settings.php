<?php
/**
 * Created by PhpStorm.
 * User: phi314
 * Date: 11/24/15
 * Time: 7:22 AM
 */

$settings['max_jam_masuk'] = '07:00:00';
$settings['min_jam_pulang'] = '12:00:00';

$q_setting = mysql_query("SELECT * FROM settings LIMIT 1");

if(mysql_num_rows($q_setting) != 0)
{
    $q_setting_result = mysql_fetch_object($q_setting);
    $settings['max_jam_masuk'] = $q_setting_result->max_jam_masuk;
    $settings['min_jam_pulang'] = $q_setting_result->min_jam_pulang;
}
