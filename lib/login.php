<?php
/**
 * Created by PhpStorm.
 * User: phi314
 * Date: 10/23/14
 * Time: 4:58 PM
 */

    if(array_key_exists('logged_in', $_SESSION)):
        $logged_id = $_SESSION['id'];
        $logged_name = $_SESSION['nama'];
        $logged_username = $_SESSION['username'];
        $logged_is_admin = $_SESSION['is_admin'];
        $logged_in = $_SESSION['logged_in'];

        // jika guru
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