<?php

/**
 * # hanya admin yg bisa ganti logo
 * # hanya pegawai dengan status pemilik yang bisa tambah pegawai
 * # pemilik hanya dapat mengubah alamat, kota, telepon, email, link pada distro
 * # hanya pemilik yang dapat mengubah data pegawai
 * # guru bisa isi item
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
        $guru = get_row_by_id('guru', 'id', $id);

        // init
        if($guru == FALSE)
        {
            redirect('guru.php');
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
            $q = sprintf("UPDATE guru SET
                            nip='%s',
                            nama='%s',
                            jk='%s',
                            user_level='%s',
                            username='%s'
                            WHERE id='$id'",
                escape($_POST['nip']),
                escape($_POST['nama']),
                escape($_POST['jk']),
                escape($_POST['user_level']),
                escape($_POST['username'])
            );

            // jalankan query
            $r = mysql_query($q);

            if(!$q)
                $error = 'Kesalahan Server';
            else
            {
                redirect("guru_detail.php?id=$id&info=behasil-update-guru"); // redirect ke detail
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
                    $upload = move_uploaded_file($_FILES['foto']['tmp_name'], '../assets/img/foto_guru/'.$filename);
                    if(!$upload)
                    {
                        $upload_stat = FALSE;
                        $error = "Gagal Upload Foto";
                    }
                    else
                        redirect('guru_detail.php?id='.$id);
                }
            }
        }
        // update foto
        elseif($submit_type == 'delete_guru')
        {
            $delete = mysql_query("DELETE FROM guru WHERE id='$id'");

            if($delete == FALSE)
            {
                $error = 'Gagal hapus Guru';
            }
            else
            {
                redirect('guru.php?info=berhasil-hapus-guru');
            }

        }
    }

?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <small><?php echo $guru->nama; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="guru.php"><i class="fa fa-user"></i> Guru</a></li>
            <li class="active"><?php echo $guru->nama; ?></li>
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
                        <h3 class="box-title"><?php echo $guru->nama; ?> </h3>
                    </div><!-- /.box-header -->
                    <div id="chat-box" class="box-body distro-profile">
                        <div class="desc">
                            <dl class="dl-horizontal">
                                <dt>NIP</dt>
                                <dd><?php echo $guru->nip; ?></dd>
                                <dt>Jenis Kelamin</dt>
                                <dd><?php echo jk($guru->jk); ?></dd>
                                <dt>Username</dt>
                                <dd><?php echo $guru->username; ?></dd>
                                <dt>User Level</dt>
                                <dd><?php echo user_level($guru->user_level); ?></dd>
                            </dl>
                        </div>
                    </div><!-- /.distro -->
                </div>
            </section><!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-5 connectedSortable">

                <form action="" method="post" id="form_delete_guru">
                    <input type="hidden" name="submit_type" value="delete_guru">
                    <input type="hidden" name="key" value="<?php echo sha1(date('ymdhis')); ?>">
                    <button class="btn btn-xs btn-danger"><i class="fa fa-times"></i> hapus guru</button>
                </form>

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
                                    <label for="nama">NIP</label>
                                    <input class="form-control" name="nip" id="nip" value="<?php echo $guru->nip; ?>" placeholder="Nama Lokasi" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input class="form-control" name="nama" id="nama" value="<?php echo $guru->nama; ?>" placeholder="Nama Lokasi" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Jenis Kelamin</label>
                                    <select name="jk" class="form-control">
                                        <option value="">--Pilih Jenis Kelamin--</option>
                                        <option value="l" <?php echo set_select_value('l', $guru->jk); ?>>Laki-laki</option>
                                        <option value="p" <?php echo set_select_value('p', $guru->jk); ?>>Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tahun">Username</label>
                                    <input class="form-control" name="username" id="username" value="<?php echo $guru->username; ?>" placeholder="tahun" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama">User Level</label>
                                    <select name="user_level" required class="form-control">
                                        <option value="0" <?php echo set_select_value('0', $guru->user_level); ?>>Guru</option>
                                        <option value="1" <?php echo set_select_value('1', $guru->user_level); ?>>Admin</option>
                                        <option value="2" <?php echo set_select_value('2', $guru->user_level); ?>>Tata Usaha</option>
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

        </section>


<?php include('inc/footer.php'); ?>


<script>

    $('#u-guru').click(function(){
        $("html, body").animate({ scrollTop: $('#section-3').offset().top }, 1000);
    });

    $("#form_delete_guru").submit(function(){
        var c = confirm("Apakah anda yakin menghapus guru ini?")

        if(c == false)
        {
            return false;
        }
    });
</script>