<?php
    ob_start();
    session_start();
    require_once('../lib/connection.php');
    require_once('../lib/unleashed.lib.php');
    require_once('../lib/login.php');

    require_once('inc/header.php');

    $logged_id = $_SESSION['logged_id'];
    $q_user = mysql_query("SELECT * FROM guru WHERE id='$logged_id' LIMIT 1");

    $user = mysql_fetch_object($q_user);

?>


    <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                        <small>Home</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-7">

                            <!-- Event List -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">Absensi</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table datatable">
                                        <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Keterangan / Pelajaran</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody id="list-absensi">
                                        <?php
                                        $date_now = date('y-m-d');
                                        $q_absensi = mysql_query("SELECT absensi.*
                                                                    FROM absensi
                                                                    WHERE tanggal='$date_now'
                                                                    ORDER BY created_at DESC");

                                        while($d_absensi = mysql_fetch_object($q_absensi)):
                                            ?>
                                            <tr id="<?php echo $d_absensi->id; ?>">
                                                <td><?php echo tanggal_format_indonesia($d_absensi->tanggal); ?></td>
                                                <td><?php echo $d_absensi->keterangan; ?></td>
                                                <td>
                                                    <a href="absensi_detail.php?id=<?php echo $d_absensi->id; ?>" class="btn btn-xs btn-success">detail</a>
                                                </td>
                                            </tr>
                                        <?php
                                        endwhile;
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- /.box -->
                        </section><!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-5 connectedSortable">

                            <div class="box box-success">
                                <div class="box-header">
                                    <i class="fa fa-dashboard"></i>
                                    <h3 class="box-title">Profil Anda</h3>
                                </div>
                                <div class="list-group">
                                    <div class="list-group-item">
                                        <label>NIS</label>
                                        <div class="form-control-static">
                                            <?php echo $user->nip; ?>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <label>Nama</label>
                                        <div class="form-control-static">
                                            <?php echo $user->nama; ?>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <label>Walikelas</label>
                                        <div class="form-control-static">
                                            <?php

                                                $q_walikelas = mysql_query("SELECT * FROM kelas WHERE id_guru='$user->id'");
                                                if(mysql_num_rows($q_walikelas) == 0)
                                                {
                                                    echo '-';
                                                }
                                                else
                                                {
                                                    while($d_walikelas = mysql_fetch_object($q_walikelas))
                                                    {
                                                        echo $d_walikelas->tingkat.'-'.$d_walikelas->nama.' ('.$d_walikelas->tahun.')<br>';
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </section><!-- right col -->
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->

<?php include('inc/footer.php'); ?>
