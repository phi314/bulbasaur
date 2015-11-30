<?php

ob_start();
session_start();
require_once('../lib/connection.php');
require_once('../lib/unleashed.lib.php');
require_once('../lib/login.php');

require_once('inc/header.php');

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

        <?php if($logged_user_level == '1'): ?>
            <a class="btn btn-primary" href="siswa_create.php"><i class="fa fa-plus"></i> Tambah Siswa</a>
        <?php endif; ?>

        <div class="h3"></div>

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
                            <th>KELAS</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $q = get_all('siswa');
                            while($siswa = mysql_fetch_object($q)):

                                $kelas = '';
                                if($siswa->id_kelas != 0)
                                {
                                    $q_kelas = mysql_query("SELECT * FROM kelas WHERE id='$siswa->id_kelas' LIMIT 1");
                                    $d_kelas = mysql_fetch_object($q_kelas);
                                    $kelas = $d_kelas->tingkat.'-'.$d_kelas->nama.' ('.$d_kelas->tahun.')';
                                }
                        ?>
                            <tr>
                                <td><a href="siswa_detail.php?id=<?php echo $siswa->id; ?>"><?php echo $siswa->nis; ?></a></td>
                                <td><?php echo $siswa->rfid; ?></td>
                                <td><?php echo $siswa->nama; ?></td>
                                <td><?php echo jk($siswa->jk); ?></td>
                                <td><?php echo $kelas; ?></td>
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

