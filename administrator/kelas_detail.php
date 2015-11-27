<?php

/**
 * # hanya admin yg bisa ganti logo
 * # hanya pegawai dengan status pemilik yang bisa tambah pegawai
 * # pemilik hanya dapat mengubah alamat, kota, telepon, email, link pada distro
 * # hanya pemilik yang dapat mengubah data pegawai
 * # kelas bisa isi item
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
        $kelas = get_row_by_id('kelas', 'id', $id);
        $nama_kelas = $kelas->tingkat.'-'.$kelas->nama.' ('.$kelas->tahun.')';

        // init
        if($kelas == FALSE)
        {
            redirect('kelas.php');
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
            $q = sprintf("UPDATE kelas SET
                            tingkat='%d',
                            nama='%s',
                            tahun='%d'
                            WHERE id='$id'",
                escape($_POST['tingkat']),
                escape($_POST['nama']),
                escape($_POST['tahun'])
            );

            // jalankan query
            $r = mysql_query($q);

            if(!$q)
                $error = 'Kesalahan Server';
            else
            {
                redirect("kelas_detail.php?id=$id&info=behasil-update-kelas"); // redirect ke detail
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
                    $upload = move_uploaded_file($_FILES['foto']['tmp_name'], '../assets/img/foto_kelas/'.$filename);
                    if(!$upload)
                    {
                        $upload_stat = FALSE;
                        $error = "Gagal Upload Foto";
                    }
                    else
                        redirect('kelas_detail.php?id='.$id);
                }
            }
        }
        // update foto
        elseif($submit_type == 'delete_kelas')
        {
            $delete = mysql_query("DELETE FROM kelas WHERE id='$id'");

            if($delete == FALSE)
            {
                $error = 'Gagal hapus kelas';
            }
            else
            {
                redirect('kelas.php?info=berhasil-hapus-kelas');
            }

        }
    }

?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Kelas
            <small><?php echo $nama_kelas; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="kelas.php"><i class="fa fa-user"></i> kelas</a></li>
            <li class="active"><?php echo $nama_kelas; ?></li>
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
                        <i class="fa fa-user"></i>
                        <h3 class="box-title"><?php echo $nama_kelas; ?> </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table class="table datatable-simple">
                            <thead>
                            <tr>
                                <th>NIS</th>
                                <th>NAMA</th>
                                <th>JK</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $q_siswa = mysql_query("SELECT * FROM siswa WHERE id_kelas='$id'");

                                while($siswa = mysql_fetch_object($q_siswa)):
                            ?>
                                <tr>
                                    <td><?php echo $siswa->nis; ?></td>
                                    <td><?php echo $siswa->nama; ?></td>
                                    <td><?php echo jk($siswa->jk); ?></td>
                                </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div><!-- /.distro -->
                </div>
            </section><!-- /.Left col -->
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
                                    <label for="nama">Tingkat</label>
                                    <input class="form-control" name="tingkat" id="tingkat" value="<?php echo $kelas->tingkat; ?>" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input class="form-control" name="nama" id="nama" value="<?php echo $kelas->nama; ?>" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Tahun</label>
                                    <input class="form-control" name="tahun" id="tahun" value="<?php echo $kelas->tahun; ?>" type="text" required>
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

            <form action="" method="post" id="form_delete_kelas">
                <input type="hidden" name="submit_type" value="delete_kelas">
                <input type="hidden" name="key" value="<?php echo sha1(date('ymdhis')); ?>">
                <button class="btn btn-xs btn-danger"><i class="fa fa-times"></i> hapus kelas</button>
            </form>

        </section>


<?php include('inc/footer.php'); ?>


<script>

    $('#u-kelas').click(function(){
        $("html, body").animate({ scrollTop: $('#section-3').offset().top }, 1000);
    });

    $("#form_delete_kelas").submit(function(){
        var c = confirm("Apakah anda yakin menghapus kelas ini?")

        if(c == false)
        {
            return false;
        }
    });
</script>