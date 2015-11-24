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
        $siswa = get_row_by_id('siswa', 'id', $id);

        if($siswa == FALSE)
        {
            redirect('siswa.php');
            exit;
        }
    }

    // jika ada submit post
    if(array_key_exists('key', $_POST))
    {
        $submit_type = $_POST['submit_type'];

        // post update siswa
        if($submit_type == 'update')
        {

            // simpan data ke database
            $q = sprintf("UPDATE siswa SET
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
                redirect("siswa_detail.php?id=$id"); // redirect ke detail
            }
        } // ./update-siswa
        // update fasilitas
        elseif($submit_type == 'update-kelas')
        {
            if(isset($_POST['kelas']))
            {
                $id_kelas = $_POST['kelas'];
                $q = "UPDATE siswa SET siswa.id_kelas='$id_kelas' WHERE id='$siswa->id'";
                $r = mysql_query($q);
            }

            // refresh page
            redirect("siswa_detail.php?id=$id"); // redirect ke detail
        }
        // update foto
        elseif($submit_type == 'update-foto')
        {
            $upload_stat = TRUE;

            // jika ada foto
            if(count($_FILES) != 0)
            {
                $kode_siswa = escape($_POST['kode_siswa']);
                $allowed_ext = array('jpg','JPG','png','PNG','bmp','BMP');
                $extension = end(explode('.', $_FILES['foto']['name']));
                $filename = sha1($kode_siswa).'.jpg';

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
                    $upload = move_uploaded_file($_FILES['foto']['tmp_name'], '../assets/img/foto_siswa/'.$filename);
                    if(!$upload)
                    {
                        $upload_stat = FALSE;
                        $error = "Gagal Upload Foto siswa";
                    }
                    else
                        redirect('siswa_detail.php?id='.$id);
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
                $kode_siswa = escape($_POST['kode_siswa']);
                $allowed_ext = array('jpg','JPG','png','PNG','bmp','BMP');
                $extension = end(explode('.', $_FILES['foto']['name']));
                $filename = sha1($kode_siswa).'_'.$_FILES['foto']['name'].'.jpg';

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
                    $upload = move_uploaded_file($_FILES['foto']['tmp_name'], '../assets/img/foto_siswa/gallery/'.$filename);
                    if(!$upload)
                    {
                        redirect('siswa_detail.php?id='.$id.'&gagal-upload-foto=1');
                    }
                    else
                    {
                        mysql_query("INSERT INTO gallery_siswa(id_siswa,filename,created_date) VALUES('$id','$filename','$now')");
                        redirect('siswa_detail.php?id='.$id);
                    }
                }
            }
        }
    }

?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Siswa
            <small><?php echo $siswa->nama; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="siswa.php"><i class="fa fa-users"></i> Siswa</a></li>
            <li class="active"><?php echo $siswa->nama; ?></li>
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
            <section class="col-lg-12">
                <div class="box box-success">
                    <div class="box-header">
                        <i class="fa fa-flash"></i>
                        <h3 class="box-title"><?php echo $siswa->nama; ?></h3>
                        <div class="box-tools pull-right">
                            <a href="#" class="btn bg-orange btn-sm" id="u-siswa"><i class="fa fa-pencil"></i> </a>
                        </div>
                    </div><!-- /.box-header -->
                    <div id="chat-box" class="box-body distro-profile">
                        <?php
                            $foto_folder_path = '../assets/img/foto_siswa/';
                            $foto_link = '../assets/img/imageNotFound.jpg';
//                            if(file_exists($foto_folder_path.$siswa->foto_link))
//                                $foto_link = $foto_folder_path.$siswa->foto_link;

                        ?>
                        <img class="logo img-responsive" src="<?php echo $foto_link; ?>">
                        <div class="desc">
                            <dl class="dl-horizontal">
                                <dt>NIS</dt>
                                <dd>
                                    <?php echo $siswa->nis; ?>
                                </dd>
                                <dt>Kelas</dt>
                                <dd><?php echo kelas($siswa->id_kelas); ?></dd>
                                <dt>Jenis Kelamin</dt>
                                <dd><?php echo jk($siswa->jk); ?></dd>
                                <dt>Saldo</dt>
                                <dd><?php echo format_rupiah($siswa->saldo); ?></dd>
                            </dl>
                        </div>
                    </div><!-- /.distro -->
                </div>
            </section><!-- /.Left col -->
        </div><!-- /.row (main row) -->

        <!-- Second Row -->
        <section class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-calendar"></i> Transaksi</h3>
                    </div>
                    <div class="box-body">
                        <table class="table datatable-orderonly">
                            <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Pembayaran</th>
                                <th>Tipe</th>
                                <th>Jumlah</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $q = "SELECT transaksi.*, pembayaran.nama FROM transaksi JOIN pembayaran ON pembayaran.id=transaksi.id_pembayaran WHERE id_siswa='$siswa->id' ORDER BY tanggal DESC";
                            $r = mysql_query($q);
                            while($d = mysql_fetch_object($r)):
                                ?>
                                <tr>
                                    <td><?php echo tanggal_format_indonesia($d->tanggal); ?></td>
                                    <td><?php echo $d->nama; ?></td>
                                    <td><?php echo $d->tipe; ?></td>
                                    <td><?php echo format_rupiah($d->jumlah); ?></td>
                                </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>
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
                        <form action="" id="form-u-siswa"  method="post">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="nama">NIS</label>
                                    <input class="form-control" name="nis" id="nis" value="<?php echo $siswa->nis; ?>" placeholder="Nama siswa" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input class="form-control" name="nama" id="nama" value="<?php echo $siswa->nama; ?>" placeholder="Nama siswa" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Jenis Kelamin</label>
                                    <select name="jk" class="form-control">
                                        <option value="">--Pilih Jenis Kelamin--</option>
                                        <option value="l" <?php echo set_select_value('l', $siswa->jk); ?>>Laki-laki</option>
                                        <option value="p" <?php echo set_select_value('p', $siswa->jk); ?>>Perempuan</option>
                                    </select>
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

            <!-- Update Fasilitas siswa -->
            <div class="col-md-6">
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-edit"></i> Update Kelas Siswa</h3>
                    </div>
                    <div class="box-body">
                        <form action="" id="form-u-f-siswa" method="post">
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Kelas</label>
                                    <select name="kelas" class="form-control">
                                        <option value="">--Pilih Kelas--</option>
                                        <?php
                                        // query fasilitas siswa
                                        $q_kelas = "SELECT * FROM kelas ORDER BY tingkat, tahun ASC";
                                        $r_kelas = mysql_query($q_kelas);
                                        while($d_kelas = mysql_fetch_object($r_kelas)):
                                        ?>
                                            <option value="<?php echo $d_kelas->id; ?>" <?php set_select_value($d_kelas->id, $siswa->id_kelas); ?>><?php echo $d_kelas->tingkat.$d_kelas->nama.' ('.$d_kelas->tahun.')'; ?></option>
                                        <?php
                                        endwhile;
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer clearfix no-border">
                                <input type="hidden" name="key" value="<?php echo sha1(date('ymdhis')); ?>">
                                <input type="hidden" name="submit_type" value="update-kelas">
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
                        <form action="" id="form-u-f-siswa" method="post" enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="form-group">
                                    <input id="foto" name="foto" type="file" required="">
                                    <p class="help-block">Max. 1MB</p>
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer clearfix no-border">
                                <input type="hidden" name="key" value="<?php echo sha1(date('ymdhis')); ?>">
                                <input type="hidden" name="kode_siswa" value="<?php echo $siswa->kode_siswa; ?>">
                                <input type="hidden" name="submit_type" value="update-foto">
                                <button class="btn btn-warning pull-right" type="submit"><i class="fa fa-pencil"></i> Update</button>
                            </div>
                        </form>
                    </div><!-- ./Box-body -->
            </div>
        </section>

<?php include('inc/footer.php'); ?>


<script>

    $('#u-siswa').click(function(){
        $("html, body").animate({ scrollTop: $('#section-3').offset().top }, 1000);
    });
</script>