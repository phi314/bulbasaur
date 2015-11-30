<?php
/**
 * Created by PhpStorm.
 * User: phi314
 * Date: 10/23/14
 * Time: 4:58 PM
 */

    if(array_key_exists('logged_in', $_SESSION)):
        $logged_id = $_SESSION['logged_id'];
        $logged_name = $_SESSION['logged_nama'];
        $logged_username = $_SESSION['logged_username'];
        $logged_user_level = $_SESSION['logged_user_level'];
        $logged_in = $_SESSION['logged_in'];

        // get from guru
        $user = get_row_by_id('guru', 'id', $logged_id);

        /**
         * apakah user adalah admin ?
         * @return bool
         */
        function is_admin()
        {
            if($_SESSION['is_admin'] == TRUE)
                return TRUE;
            else
                return FALSE;
        }

    else:
        header('location: index.php');
    endif;