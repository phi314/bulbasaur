<?php

ob_start();
session_start();
require_once('../lib/connection.php');
require_once('../lib/unleashed.lib.php');
require_once('../lib/login.php');

require_once('inc/header.php');

$logged_id = $_SESSION['logged_id'];

?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Siswa
            <small>Listing</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Siswa</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <?php if(!empty($error)): ?>
            <div class="alert alert-danger">
                <i class="fa fa-warning"></i>
                <strong><?php echo $error; ?></strong>
            </div>
            <script>

            </script>
        <?php endif; ?>

        <section>
            <div class="box box-success">
                <div class="box-header">
                    <i class="fa fa-building"></i>
                    <h3 class="box-title">Siswa</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped datatable-simple">
                        <thead>
                        <tr>
                            <th>NIS</th>
                            <th>RFID</th>
                            <th>NAMA</th>
                            <th>JK</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $q = mysql_query("SELECT siswa.*
                                                FROM siswa
                                                JOIN kelas ON kelas.id=siswa.id_kelas
                                                WHERE kelas.id_guru='$logged_id'");
                            while($siswa = mysql_fetch_object($q)):
                        ?>
                            <tr>
                                <td><a href="siswa_detail.php?id=<?php echo $siswa->id; ?>"><?php echo $siswa->nis; ?></a></td>
                                <td><?php echo $siswa->rfid; ?></td>
                                <td><?php echo $siswa->nama; ?></td>
                                <td><?php echo jk($siswa->jk); ?></td>
                            </tr>
                        <?php
                            endwhile;
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section><!-- /.Listing lokasi -->
    </section><!-- /.content -->

<?php include('inc/footer.php'); ?>

