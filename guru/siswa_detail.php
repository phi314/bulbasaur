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
        $lokasi = get_row_by_id('lokasi', 'id', $id);

        // init
        $nama_lokasi = $lokasi->tipe_lokasi.' '.$lokasi->nama;
        $lg = $lokasi->lg;
        $lt = $lokasi->lt;
        if($lokasi->lt == 0 OR $lokasi->lg == 0)
        {
            $lg = 107.608242;
            $lt = -6.914864;
        }

        if($lokasi == FALSE)
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
            $q = sprintf("UPDATE lokasi SET
                            nama=UPPER('%s'),
                            alamat=UPPER('%s'),
                            kota=UPPER('%s'),
                            deskripsi='%s',
                            tahun='%s',
                            lg='%f',
                            lt='%f',
                            id_admin='$id_user'
                            WHERE id='$id'",
                escape($_POST['nama']),
                escape($_POST['alamat']),
                escape($_POST['kota']),
                escape($_POST['deskripsi']),
                escape($_POST['tahun']),
                escape($_POST['longitude']),
                escape($_POST['latitude'])
            );

            // jalankan query
            $r = mysql_query($q);

            if(!$q)
                $error = 'Kesalahan Server';
            else
            {
                // buat log file
                $file_path = '../lib/tamankota-log.txt';
                $message = "[".now()."]Update data lokasi $id by $logged_type $logged_id";
                add_log($file_path, $message);
                // refresh page
                redirect("lokasi_detail.php?id=$id"); // redirect ke detail
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
                $kode_lokasi = escape($_POST['kode_lokasi']);
                $allowed_ext = array('jpg','JPG','png','PNG','bmp','BMP');
                $extension = end(explode('.', $_FILES['foto']['name']));
                $filename = sha1($kode_lokasi).'.jpg';

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
                    $upload = move_uploaded_file($_FILES['foto']['tmp_name'], '../assets/img/foto_lokasi/'.$filename);
                    if(!$upload)
                    {
                        $upload_stat = FALSE;
                        $error = "Gagal Upload Foto Lokasi";
                    }
                    else
                        redirect('lokasi_detail.php?id='.$id);
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
    <!-- Google Map Plugin -->
    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDY0kkJiTPVd2U7aTOAwhc9ySH6oHxOIYM&sensor=false"></script>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Lokasi
            <small><?php echo $nama_lokasi; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="lokasi.php"><i class="fa fa-location-arrow"></i> Lokasi</a></li>
            <li class="active"><?php echo $nama_lokasi; ?></li>
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
                        <h3 class="box-title"><?php echo $nama_lokasi; ?> / <span class="text-muted"><?php echo $lokasi->alias; ?></span> </h3>
                        <div class="box-tools pull-right">
                            <?php
                                // hanya admin yg dapat mengedit detail lokasi
                                if(is_admin()):
                            ?>
                                <a href="#" class="btn bg-orange btn-sm" id="u-lokasi"><i class="fa fa-pencil"></i> </a>
                            <?php endif; ?>
                        </div>
                    </div><!-- /.box-header -->
                    <div id="chat-box" class="box-body distro-profile">
                        <?php
                            $foto_folder_path = '../assets/img/foto_lokasi/';
                            if(file_exists($foto_folder_path.$lokasi->foto_link))
                                $foto_link = $foto_folder_path.$lokasi->foto_link;
                            else
                                $foto_link = '../assets/img/imageNotFound.jpg';

                        ?>
                        <img class="logo img-responsive" src="<?php echo $foto_link; ?>">
                        <div class="desc">
                            <dl class="dl-horizontal">
                                <dt>Alamat</dt>
                                <dd>
                                    <?php echo $lokasi->alamat; ?>
                                </dd>
                                <dt>Sejak Tahun</dt>
                                <dd><?php echo $lokasi->tahun; ?></dd>
                                <dt>Deskripsi</dt>
                                <dd><?php echo html_entity_decode($lokasi->deskripsi); ?></dd>
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
                    <div class="box-body">
                        <script>
                            var lokasi = new google.maps.LatLng(<?php echo $lt; ?>, <?php echo $lg; ?>);
                            function initialize()
                            {

                                var mapProp = {
                                    center: lokasi,
                                    zoom: 16,
                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                };

                                var map=new google.maps.Map(document.getElementById("map") ,mapProp);

                                marker=new google.maps.Marker({
                                    position: lokasi
                                });

                                marker.setMap(map);

                            }
                            google.maps.event.addDomListener(window, 'load', initialize);
                        </script>
                        <div id="map" style="width:inherit; height:200px; margin-left: auto; margin-right: auto">

                        </div>
                        <p class="text-muted">LT: <?php echo $lt; ?>, LG: <?php echo $lg; ?></p>
                    </div>
                </div><!-- /.map -->
            </section><!-- right col -->
        </div><!-- /.row (main row) -->

        <!-- Second Row -->
        <section class="row">
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-calendar"></i> Events</h3>
                    </div>
                    <?php
                    $q_e = "SELECT event.* FROM lokasi_event JOIN event ON event.id=lokasi_event.id_event WHERE lokasi_event.id_lokasi='$id' ORDER BY waktu ASC";
                    $r_e = mysql_query($q_e);
                    while($d_e = mysql_fetch_object($r_e)):
                        ?>
                        <a href="event_detail.php?id=<?php echo $d_e->id; ?>" class="list-group-item">
                            <?php echo $d_e->nama; ?>
                            <div class="pull-right"><i class="fa fa-chevron-circle-right"></i> </div>
                        </a>

                    <?php endwhile; ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-comments"></i> Review</h3>
                    </div>
                    <div class="box-body">

                    </div>
                </div>
            </div>
        </section>

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
                                    <div class="input-group">
                                        <span class="input-group-addon"><?php echo $lokasi->tipe_lokasi; ?></span>
                                        <input class="form-control" name="nama" id="nama" value="<?php echo $lokasi->nama; ?>" placeholder="Nama Lokasi" type="text" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" name="alamat" id="alamat" placeholder="Alamat" required><?php echo $lokasi->alamat; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="kota">Kota</label>
                                    <input class="form-control" name="kota" id="kota" value="<?php echo $lokasi->kota; ?>" placeholder="Kota" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea class="form-control" name="deskripsi" id="deskripsi" ><?php echo $lokasi->deskripsi; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="tahun">Tahun</label>
                                    <input class="form-control" name="tahun" id="tahun" value="<?php echo $lokasi->tahun; ?>" placeholder="tahun" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label>Lokasi</label>
                                    <div class="row">
                                        <div class="col-xs-6"><input type="text" value="<?php echo $lokasi->lg; ?>" class="form-control" name="longitude" placeholder="Longitude"></div>
                                        <div class="col-xs-6"><input type="text" value="<?php echo $lokasi->lt; ?>" class="form-control" name="latitude" placeholder="Latitude"></div>
                                    </div>
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

            <!-- Update Fasilitas Lokasi -->
            <div class="col-md-6">
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-edit"></i> Update Fasilitas Lokasi</h3>
                    </div>
                    <div class="box-body">
                        <form action="" id="form-u-f-lokasi" method="post">
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Fasilitas</label>
                                    <br>
                                    <?php
                                        // query fasilitas lokasi
                                        $q_f = "SELECT * FROM fasilitas ORDER BY nama ASC";
                                        $r_f = mysql_query($q_f);
                                        while($d_f_l = mysql_fetch_object($r_f)):
                                            $checked = '';
                                            // jika fasilitas lokasi ada maka ceklis
                                            $q_f_l = "SELECT * FROM fasilitas_lokasi WHERE id_lokasi='$id' AND id_fasilitas='$d_f_l->id' LIMIT 1";
                                            $r_f_l = mysql_query($q_f_l);
                                            if(mysql_num_rows($r_f_l) == 1)
                                                $checked = 'CHECKED';
                                    ?>
                                        <input type="checkbox" name="fasilitas[]" value="<?php echo $d_f_l->id; ?>" <?php echo $checked; ?>> <?php echo $d_f_l->nama; ?><br>
                                    <?php
                                        endwhile;
                                    ?>
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer clearfix no-border">
                                <input type="hidden" name="key" value="<?php echo sha1(date('ymdhis')); ?>">
                                <input type="hidden" name="submit_type" value="update-facility">
                                <button class="btn btn-warning pull-right" type="submit"><i class="fa fa-pencil"></i> Update</button>
                            </div>
                        </form>
                    </div>
                </div><!-- ./Box -->

                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-edit"></i> Update Foto Utama</h3>
                    </div>
                    <div class="box-body">
                        <form action="" id="form-u-f-lokasi" method="post" enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="form-group">
                                    <input id="foto" name="foto" type="file" required="">
                                    <p class="help-block">Max. 1MB</p>
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer clearfix no-border">
                                <input type="hidden" name="key" value="<?php echo sha1(date('ymdhis')); ?>">
                                <input type="hidden" name="kode_lokasi" value="<?php echo $lokasi->kode_lokasi; ?>">
                                <input type="hidden" name="submit_type" value="update-foto">
                                <button class="btn btn-warning pull-right" type="submit"><i class="fa fa-pencil"></i> Update</button>
                            </div>
                        </form>
                    </div><!-- ./Box-body -->
            </div>
        </section>

        <section>
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-edit"></i> Gallery</h3>
                    <div class="box-tools pull-right">
                        <a href="#" class="btn bg-blue btn-sm" id="t-gallery"><i class="fa fa-plus"></i> </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <?php
                        $q_gallery = "SELECT * FROM gallery_lokasi WHERE id_lokasi='$id'";
                        $r_gallery = mysql_query($q_gallery);
                        while($d_gallery = mysql_fetch_object($r_gallery)):
                            ?>
                            <div class="col-md-4">
                                <img src="../assets/img/foto_lokasi/gallery/<?php echo $d_gallery->filename; ?>" class="img-responsive">
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div><!-- ./Box update foto -->
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
        <input type="hidden" name="kode_lokasi" value="<?php echo $lokasi->kode_lokasi; ?>">
        <input type="hidden" name="submit_type" value="tambah-foto-gallery">
    </form>
</div>

<?php include('inc/footer.php'); ?>


<script>

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