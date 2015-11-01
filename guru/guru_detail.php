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
        $petugas = get_row_by_id('petugas', 'id', $id);

        // init
        if($petugas == FALSE)
        {
            redirect('petugas.php');
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

            $tgl_lahir = date('Y-m-d', strtotime($_POST['tgl_lahir']));
            // simpan data ke database
            $q = sprintf("UPDATE petugas SET
                            nama=UPPER('%s'),
                            jk='%s',
                            tempat_lahir=UPPER('%s'),
                            tanggal_lahir=UPPER('%s'),
                            alamat='%s',
                            kota='%s',
                            telepon='%s',
                            email='%s'
                            WHERE id='$id'",
                escape($_POST['nama']),
                escape($_POST['jk']),
                escape($_POST['t_lahir']),
                escape($tgl_lahir),
                escape($_POST['alamat']),
                escape($_POST['kota']),
                escape($_POST['telepon']),
                escape($_POST['email'])
            );

            // jalankan query
            $r = mysql_query($q);

            if(!$q)
                $error = 'Kesalahan Server';
            else
            {
                // buat log file
                $file_path = '../lib/tamankota-log.txt';
                $message = "[".now()."]Update data petugas $id by $logged_id";
                add_log($file_path, $message);
                // refresh page
                redirect("petugas_detail.php?id=$id"); // redirect ke detail
            }
        } // ./update-lokasi
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
                    $upload = move_uploaded_file($_FILES['foto']['tmp_name'], '../assets/img/foto_petugas/'.$filename);
                    if(!$upload)
                    {
                        $upload_stat = FALSE;
                        $error = "Gagal Upload Foto";
                    }
                    else
                        redirect('petugas_detail.php?id='.$id);
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
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Petugas
            <small><?php echo $petugas->nama; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="petugas.php"><i class="fa fa-user"></i> Petugas</a></li>
            <li class="active"><?php echo $petugas->nama; ?></li>
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
                        <i class="fa fa-user"></i>
                        <h3 class="box-title"><?php echo $petugas->nama; ?> </h3>
                        <div class="box-tools pull-right">
                            <?php
                                // hanya admin yg dapat mengedit detail lokasi
                                if(is_admin()):
                            ?>
                                <a href="#" class="btn bg-orange btn-sm" id="u-petugas"><i class="fa fa-pencil"></i> </a>
                            <?php endif; ?>
                        </div>
                    </div><!-- /.box-header -->
                    <div id="chat-box" class="box-body distro-profile">
                        <div class="desc">
                            <dl class="dl-horizontal">
                                <dt>Tempat Lahir</dt>
                                <dd><?php echo $petugas->tempat_lahir; ?></dd>
                                <dt>Tanggal Lahir</dt>
                                <dd><?php echo tanggal_format_indonesia($petugas->tanggal_lahir); ?></dd>
                                <dt>Alamat</dt>
                                <dd>
                                    <?php echo $petugas->alamat; ?> <?php echo 'Kota '.$petugas->kota; ?>
                                </dd>
                                <dt>Telepon</dt>
                                <dd><?php echo $petugas->telepon ?></dd>
                                <dt>Email</dt>
                                <dd><?php echo $petugas->email; ?></dd>
                                <dt>Username</dt>
                                <dd><?php echo $petugas->username; ?></dd>
                            </dl>
                        </div>
                    </div><!-- /.distro -->
                </div>
            </section><!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-5 connectedSortable">
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-edit"></i> Foto Profil</h3>
                    </div>
                    <div class="box-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="box-body">
                                <?php
                                    $folder_path = '../assets/img/foto_petugas/';
                                    $file = $petugas->id.'.jpg';
                                    $filename = $folder_path.$file;
                                    if(file_exists($filename)):
                                ?>
                                    <img src="<?php echo $filename; ?>" class="img-responsive">
                                <?php endif; ?>
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
            </section><!-- right col -->
        </div><!-- /.row (main row) -->

        <!-- Second Row -->
        <section class="row" id="section-3">
            <div class="col-md-7">
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-edit"></i> Update</h3>
                    </div>
                    <div class="box-body">
                        <form action="" id="form-u-lokasi"  method="post">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input class="form-control" name="nama" id="nama" value="<?php echo $petugas->nama; ?>" placeholder="Nama Lokasi" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kelamin</label><br>
                                    <input type="radio" name="jk" value="laki-laki" required="" <?php echo $petugas->jk == 'laki-laki' ? 'CHECKED' : ''; ?>> Laki-laki
                                    <input type="radio" name="jk" value="perempuan" required="" <?php echo $petugas->jk == 'perempuan' ? 'CHECKED' : ''; ?>> Perempuan
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Tempat Lahir</label>
                                            <input type="text" class="form-control" name="t_lahir" required="" value="<?php echo $petugas->tempat_lahir; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Tanggal Lahir</label>
                                            <input type="text" class="form-control tanggal" name="tgl_lahir" required="" value="<?php echo date('m/d/Y', strtotime($petugas->tanggal_lahir)); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" name="alamat" id="alamat" placeholder="Alamat" required><?php echo $petugas->alamat; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="kota">Kota</label>
                                    <input class="form-control" name="kota" id="kota" value="<?php echo $petugas->kota; ?>" placeholder="Kota" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label for="tahun">Telepon</label>
                                    <input class="form-control" name="telepon" id="telepon" value="<?php echo $petugas->telepon; ?>" placeholder="tahun" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label for="tahun">Email</label>
                                    <input class="form-control" name="email" id="email" value="<?php echo $petugas->email; ?>" placeholder="tahun" type="email" required>
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

        </section>


<?php include('inc/footer.php'); ?>


<script>

    $('#u-petugas').click(function(){
        $("html, body").animate({ scrollTop: $('#section-3').offset().top }, 1000);
    });
</script>