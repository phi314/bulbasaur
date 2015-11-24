<?php
    ob_start();
    session_start();
    require_once('../lib/connection.php');
    require_once('../lib/unleashed.lib.php');
    require_once('../lib/login.php');


    // submitter
    if(array_key_exists('key', $_POST))
    {
        $submit_type = $_POST['submit_type'];
        switch($submit_type)
        {
            case 'tambah_event':

                $q_t_event = sprintf("INSERT INTO event(nama, deskripsi, waktu, lama, id_petugas, create_date)
                                        VALUES('%s', '%s', '%s', '%s', '%s', '%s')",
                                        escape($_POST['nama']),
                                        escape($_POST['deskripsi']),
                                        escape($_POST['waktu']),
                                        escape($_POST['lama']),
                                        $logged_id,
                                        now()
                );

                $r_t_event = mysql_query($q_t_event);
                if(!$r_t_event)
                    $error = 'Gagal Tambah Event';
                else
                {
                    $id = mysql_insert_id();

                    // masukan lokasi mana saja
                    foreach($_POST['lokasi'] as $key => $lokasi):
                        $q_event_lokasi = "INSERT INTO lokasi_event(id_event, id_lokasi) VALUES('$id', '$lokasi')";
                        $r_event_lokasi = mysql_query($q_event_lokasi);
                    endforeach;


                    // buat log file
                    $file_path = '../lib/tamankota-log.txt';
                    $message = "[".now()."]Tambah data event $id oleh $logged_id";
                    add_log($file_path, $message);
                    // refresh page
                    redirect("event_detail.php?id=$id");
                }
                break;
        }
    }

    require_once('inc/header.php');


?>
<link href="../assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />


    <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Absensi
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">Absensi</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-8">

                            <!-- TO DO List -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">Data Siswa Hari Ini</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table datatable">
                                        <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Tanggal</th>
                                            <th>Jam Masuk</th>
                                            <th>Jam Pulang</th>
                                        </tr>
                                        </thead>
                                        <tbody id="list-absensi">
                                        <?php
                                        $date_now = date('y-m-d');
                                        $q_absensi = mysql_query("SELECT absensi.*
                                                                    FROM absensi
                                                                    JOIN siswa ON siswa.id=absensi.id_siswa
                                                                    JOIN kelas ON kelas.id=siswa.id_kelas
                                                                    WHERE kelas.id_guru = '$logged_id'
                                                                    AND tanggal='$date_now'
                                                                    ORDER BY updated_at DESC");

                                        while($d_absensi = mysql_fetch_object($q_absensi)):
                                            $q_siswa = mysql_query("SELECT * FROM siswa WHERE id='$d_absensi->id_siswa' LIMIT 1");
                                            $r_siswa = mysql_fetch_object($q_siswa);

                                            $kelas = '';
                                            if($r_siswa->id_kelas != 0)
                                            {
                                                $q_kelas = mysql_query("SELECT * FROM kelas WHERE id='$r_siswa->id_kelas' LIMIT 1");
                                                $d_kelas = mysql_fetch_object($q_kelas);
                                                $kelas = $d_kelas->tingkat.'-'.$d_kelas->nama.' ('.$d_kelas->tahun.')';
                                            }
                                            ?>
                                            <tr id="<?php echo $d_absensi->id; ?>">
                                                <td><?php echo $r_siswa->nama; ?></td>
                                                <td><?php echo $kelas; ?></td>
                                                <td><?php echo $d_absensi->tanggal; ?></td>
                                                <td><?php echo $d_absensi->jam_masuk; ?></td>
                                                <td><?php echo $d_absensi->jam_pulang; ?></td>
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
                        <section class="col-lg-4 connectedSortable">

                            <!-- Kategori List List -->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">Tambah Absensi</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label>NIS</label>
                                            <input type="text" class="form-control" name="nama" required="">
                                        </div>
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" class="form-control" name="nama" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Absen</label><br>
                                            <select name="absen" class="form-control" required="">
                                                <option value="">--Silahkan Pilih Tipe Absen--</option>
                                                <option value="hadir">Hadir</option>
                                                <option value="telat">Telat</option>
                                                <option value="izin">Izin</option>
                                                <option value="sakit">Sakit</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <input type="text" class="form-control" name="tanggal" required="">
                                        </div>
                                        <div class="form-group">
                                            <label>Keterangan</label>
                                            <textarea class="form-control" name="deskripsi" id="deskripsi" required=""></textarea>
                                        </div>
                                        <br>
                                        <button class="btn btn-primary">Simpan</button>
                                        <input type="hidden" name="key" value="<?php echo crypt('romanov', '$1$sinkyousei$'); ?>">
                                        <input type="hidden" name="submit_type" value="tambah_event">
                                    </form>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </section><!-- right col -->
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->

<?php include('inc/footer.php'); ?>
<script src="../assets/js/bootstrap-datetimepicker.js"></script>

<script type="text/javascript">
    $('.waktu').datetimepicker()
</script>
