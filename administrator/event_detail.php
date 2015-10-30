<?php

/**
 * # hanya admin yg bisa ganti logo
 * # hanya pegawai dengan status pemilik yang bisa tambah pegawai
 * # pemilik hanya dapat mengubah alamat, kota, telepon, email, link pada distro
 * # hanya pemilik yang dapat mengubah data pegawai
 * # petugas bisa isi item
 */

    ob_start();
    session_start();
    require_once('../lib/connection.php');
    require_once('../lib/unleashed.lib.php');
    require_once('../lib/login.php');

    require_once('inc/header.php');

    $success = '';
    $error = '';
    $filename = '';
    $now = now();

    // jika ada id
    if(array_key_exists('id', $_GET))
    {
        $id = escape($_GET['id']);
        $event = get_row_by_id('event', 'id', $id);

        // init
        if($event == FALSE)
        {
            redirect('lokasi.php');
            exit;
        }
    }

    // jika ada submit post
    if(array_key_exists('key', $_POST))
    {
        $submit_type = $_POST['submit_type'];

        // post update lokasi
        if($submit_type == 'update')
        {

            // simpan data ke database
            $q = sprintf("UPDATE event SET
                            nama=UPPER('%s'),
                            waktu=UPPER('%s'),
                            lama=UPPER('%s'),
                            deskripsi='%s',
                            id_petugas='%s'
                            WHERE id='$id'",
                escape($_POST['nama']),
                escape($_POST['waktu']),
                escape($_POST['lama']),
                escape($_POST['deskripsi']),
                $logged_id
            );

            // jalankan query
            $r = mysql_query($q);

            if(!$q)
                $error = 'Kesalahan Server';
            else
            {
                // buat log file
                $file_path = '../lib/tamankota-log.txt';
                $message = "[".now()."]Update data event $id by $logged_id";
                add_log($file_path, $message);
                // refresh page
                redirect("event_detail.php?id=$id"); // redirect ke detail
            }
        } // ./update-lokasi
        // update fasilitas
        elseif($submit_type == 'update-facility')
        {
            if(count($_POST['fasilitas']) != 0)
            {
                // hapus semua fasilitas lokasi
                mysql_query("DELETE FROM fasilitas_lokasi WHERE id_lokasi='$id'");
                $fasilitas = $_POST['fasilitas'];
                foreach($fasilitas as $key => $value):
                    $q_i_f_l = sprintf("INSERT INTO fasilitas_lokasi(id_lokasi, id_fasilitas, created_date) VALUES('%s', '%s', '%s')",
                                $id, $value, now());
                    mysql_query($q_i_f_l);
                endforeach;
            }

            // buat log file
            $file_path = '../lib/tamankota-log.txt';
            $message = "[".now()."]Update data fasilitas lokasi $id by $logged_type $logged_id";
            add_log($file_path, $message);
            // refresh page
            redirect("lokasi_detail.php?id=$id"); // redirect ke detail
        }
        // update foto
        elseif($submit_type == 'update-foto')
        {
            $upload_stat = TRUE;

            // jika ada foto
            if(count($_FILES) != 0)
            {
                $allowed_ext = array('jpg','JPG','png','PNG','bmp','BMP');
                $extension = end(explode('.', $_FILES['foto']['name']));
                $filename = $id.'.jpg';

                // ukuran file max 1 Mb
                if($_FILES['foto']['size'] > 50000000)
                {
                    $error = "Ukuran file maximal 5MB";
                }
                // jika file bukan png / bmp / jpg
                elseif(!in_array($extension, $allowed_ext))
                {
                    $error = "file hanya boleh png / bmp / jpg";
                }
                else
                {
                    // upload foto
                    $upload = move_uploaded_file($_FILES['foto']['tmp_name'], '../assets/img/foto_event/'.$filename);
                    if(!$upload)
                    {
                        $upload_stat = FALSE;
                        $error = "Gagal Upload Foto Event";
                    }
                    else
                        redirect('event_detail.php?id='.$id);
                }
            }
        }
        // update foto
        elseif($submit_type == 'tambah-foto-gallery')
        {

            $upload_stat = TRUE;

            // jika ada foto
            if(count($_FILES) != 0)
            {
                $kode_lokasi = escape($_POST['kode_lokasi']);
                $allowed_ext = array('jpg','JPG','png','PNG','bmp','BMP');
                $extension = end(explode('.', $_FILES['foto']['name']));
                $filename = sha1($kode_lokasi).'_'.$_FILES['foto']['name'].'.jpg';

                // ukuran file max 1 Mb
                if($_FILES['foto']['size'] > 10000000)
                {
                    $error = "Ukuran file maximal 1MB";
                }
                // jika file bukan png / bmp / jpg
                elseif(!in_array($extension, $allowed_ext))
                {
                    $error = "file hanya boleh png / bmp / jpg";
                }
                else
                {
                    // upload foto
                    $upload = move_uploaded_file($_FILES['foto']['tmp_name'], '../assets/img/foto_lokasi/gallery/'.$filename);
                    if(!$upload)
                    {
                        redirect('lokasi_detail.php?id='.$id.'&gagal-upload-foto=1');
                    }
                    else
                    {
                        mysql_query("INSERT INTO gallery_lokasi(id_lokasi,filename,created_date) VALUES('$id','$filename','$now')");
                        redirect('lokasi_detail.php?id='.$id);
                    }
                }
            }
        }
    }

?>
    <link href="../assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <!-- Google Map Plugin -->
    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDY0kkJiTPVd2U7aTOAwhc9ySH6oHxOIYM&sensor=false"></script>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Event
            <small><?php echo $event->nama; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="lokasi.php"><i class="fa fa-calendar"></i> Event</a></li>
            <li class="active"><?php echo $event->nama; ?></li>
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

        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-7">
                <div class="box box-success">
                    <div class="box-header">
                        <i class="fa fa-flash"></i>
                        <h3 class="box-title"><?php echo $event->nama; ?></h3>
                        <div class="box-tools pull-right">
                        </div>
                    </div><!-- /.box-header -->
                    <div id="chat-box" class="box-body distro-profile">
                        <?php if(file_exists('../assets/img/foto_event/'.$event->id.'.jpg')): ?>

                            <img src="../assets/img/foto_event/<?php echo $event->id.'.jpg'; ?>" class="img-responsive">
                        <?php endif; ?>
                        <div class="desc">
                            <dl class="dl-horizontal">
                                <dt>Tanggal Event</dt>
                                <dd>
                                    <?php echo tanggal_format_indonesia($event->waktu, true); ?>
                                </dd>
                                <dt>Lama Event</dt>
                                <dd><?php echo $event->lama; ?> Hari</dd>
                                <dt>Deskripsi</dt>
                                <dd><?php echo html_entity_decode($event->deskripsi); ?></dd>
                            </dl>
                        </div>
                    </div><!-- /.distro -->
                </div>
            </section><!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-5 connectedSortable">
                <!-- Map -->
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="fa fa-map-marker"></i>
                        <h3 class="box-title">Lokasi</h3>
                    </div><!-- /.box-header -->
                    <?php
                    $q_lokasi = "SELECT lokasi.* FROM lokasi_event JOIN lokasi ON lokasi_event.id_lokasi=lokasi.id ORDER BY lokasi.nama ASC";
                    $r_lokasi = mysql_query($q_lokasi);
                    while($d_lokasi = mysql_fetch_object($r_lokasi)):
                        ?>
                        <div class="list-group-item">
                            <a href="lokasi_detail.php?id=<?php echo $d_lokasi->id; ?>"><?php echo $d_lokasi->tipe_lokasi.' '.$d_lokasi->nama; ?></a>
                        </div>
                    <?php endwhile; ?>
                </div>
            </section><!-- right col -->
        </div><!-- /.row (main row) -->



        <!-- Third Row -->
        <section class="row" id="section-3">
            <div class="col-md-6">
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-edit"></i> Update</h3>
                    </div>
                    <div class="box-body">
                        <form action="" id="form-u-lokasi"  method="post">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input class="form-control" name="nama" id="nama" value="<?php echo $event->nama; ?>" placeholder="Nama Lokasi" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label for="waktu">Waktu</label>
                                    <input class="form-control waktu" name="waktu" id="waktu" value="<?php echo $event->waktu; ?>" placeholder="Waktu" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label for="lama">Lama</label>
                                    <div class="input-group">
                                        <input class="form-control" name="lama" id="lama" value="<?php echo $event->lama; ?>" placeholder="lama" type="text" required>
                                        <span class="input-group-addon">Hari</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea class="form-control" name="deskripsi" id="deskripsi" ><?php echo $event->deskripsi; ?></textarea>
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer clearfix no-border">
                                <input type="hidden" name="key" value="<?php echo sha1(date('ymdhis')); ?>">
                                <input type="hidden" name="submit_type" value="update">
                                <button class="btn btn-warning pull-right" type="submit"><i class="fa fa-pencil"></i> Update</button>
                            </div>
                        </form>
                    </div>
                </div><!-- ./Box -->
            </div>

            <div class="col-md-6">
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-edit"></i> Update gambar Event</h3>
                    </div>
                    <div class="box-body">
                        <form action="" id="form-u-f-lokasi" method="post" enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="form-group">
                                    <input id="foto" name="foto" type="file" required="">
                                    <p class="help-block">Max. 5MB</p>
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer clearfix no-border">
                                <input type="hidden" name="key" value="<?php echo sha1(date('ymdhis')); ?>">
                                <input type="hidden" name="kode_lokasi" value="<?php echo $event->kode_lokasi; ?>">
                                <input type="hidden" name="submit_type" value="update-foto">
                                <button class="btn btn-warning pull-right" type="submit"><i class="fa fa-pencil"></i> Update</button>
                            </div>
                        </form>
                    </div><!-- ./Box-body -->
            </div>
        </section>
    </section><!-- /.content -->

<div id="form-t-foto" class="hide">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <input type="file" name="foto" required="">
        </div>
        <button type="button" data-dismiss="modal" class="btn btn-danger">Tutup</button>
        <button class="btn btn-primary">Simpan</button>
        <input type="hidden" name="key" value="<?php echo sha1(date('ymdhis')); ?>">
        <input type="hidden" name="kode_lokasi" value="<?php echo $event->kode_lokasi; ?>">
        <input type="hidden" name="submit_type" value="tambah-foto-gallery">
    </form>
</div>

<?php include('inc/footer.php'); ?>

<script src="../assets/js/bootstrap-datetimepicker.js"></script>

<script type="text/javascript">


    $('.waktu').datetimepicker()

    $('#u-lokasi').click(function(){
        $("html, body").animate({ scrollTop: $('#section-3').offset().top }, 1000);
    });
    /**
     * Init Editor
     */
    $("textarea[name=deskripsi]").wysihtml5({
        "font-styles": false, //Font styling, e.g. h1, h2, etc. Default true
        "emphasis": true, //Italics, bold, etc. Default true
        "lists": false, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
        "html": false, //Button which allows you to edit the generated HTML. Default false
        "link": false, //Button to insert a link. Default true
        "image": false, //Button to insert an image. Default true,
        "color": false //Button to change color of font
    });

    $('#t-gallery').click(function(){
        var form = $('#form-t-foto').html();
        bootbox.dialog({
            title: "Tambah Foto Taman",
            message: form
        });
    });
</script>