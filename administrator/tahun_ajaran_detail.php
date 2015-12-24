<?php

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
        $tahun_ajaran = get_row_by_id('tahun_ajaran', 'id', $id);

        // init
        if($tahun_ajaran == FALSE)
        {
            redirect('tahun_ajaran.php');
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
            $tahun_ajaran = escape($_POST['tahun1']).'-'.escape($_POST['tahun2']);

            // simpan data ke database
            $q = sprintf("UPDATE tahun_ajaran SET
                            tahun='%s'
                            WHERE id='$id'",
                $tahun_ajaran

            );


            // jalankan query
            $r = mysql_query($q);

            if(!$q)
                $error = 'Kesalahan Server';
            else
            {
                redirect("tahun_ajaran_detail.php?id=$id&info=behasil-update-tahun_ajaran"); // redirect ke detail
            }
        } // ./update-lokasi
        // update foto
        elseif($submit_type == 'aktivasi-tahun-ajaran')
        {

            mysql_query("UPDATE tahun_ajaran SET is_aktif=0");

            // simpan data ke database
            $q = sprintf("UPDATE tahun_ajaran SET
                            is_aktif='1'
                            WHERE id='$id'",
                $tahun_ajaran

            );


            // jalankan query
            $r = mysql_query($q);

            if(!$q)
                $error = 'Kesalahan Server';
            else
            {
                redirect("tahun_ajaran_detail.php?id=$id&info=behasil-aktivasi-tahun_ajaran"); // redirect ke detail
            }
        }
        // update foto
        elseif($submit_type == 'delete_tahun_ajaran')
        {
            $delete = mysql_query("DELETE FROM tahun_ajaran WHERE id='$id'");

            if($delete == FALSE)
            {
                $error = 'Gagal hapus tahun_ajaran';
            }
            else
            {
                redirect('tahun_ajaran.php?info=berhasil-hapus-tahun_ajaran');
            }

        }
    }

?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Tahun Ajaran
            <small><?php echo $tahun_ajaran->tahun; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="tahun_ajaran.php"><i class="fa fa-user"></i> Tahun Ajaran</a></li>
            <li class="active"><?php echo $tahun_ajaran->tahun; ?></li>
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

        <!-- Second Row -->
        <section class="row" id="section-3">
            <div class="col-md-7">
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-edit"></i> Update</h3>
                    </div>
                    <div class="box-body">
                        <form action="" id="form-u-tahun-ajaran"  method="post">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="nama">Tingkat</label>
                                    <div class="row">
                                        <div class="col-md-5"><input class="form-control" name="tahun1" id="tahun1" value="<?php echo substr($tahun_ajaran->tahun, 0, 4); ?>" type="text" required></div>
                                        <div class="col-md-2">-</div>
                                        <div class="col-md-5"><input class="form-control" name="tahun2" id="tahun2" value="<?php echo substr($tahun_ajaran->tahun, 5, 4); ?>" type="text" required></div>
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
            <div class="col-md-5">
                <form action="" id="form-aktivasi-tahun-ajaran"  method="post">
                    <div class="box-footer clearfix no-border">
                        <?php
                            $q_tahun_ajaran_aktif = mysql_query("SELECT tahun FROM tahun_ajaran WHERE is_aktif='1' LIMIT 1");

                            if(mysql_num_rows($q_tahun_ajaran_aktif) == 1)
                            {
                                $r_tahun_ajaran_aktif = mysql_fetch_object($q_tahun_ajaran_aktif);
                                echo "Tahun Ajaran aktif: " . $r_tahun_ajaran_aktif->tahun;
                            }
                        ?>


                        <input type="hidden" name="key" value="<?php echo sha1(date('ymdhis')); ?>">
                        <input type="hidden" name="submit_type" value="aktivasi-tahun-ajaran">
                        <?php if($tahun_ajaran->is_aktif == 0): ?>
                            <button class="btn btn-success btn-block" type="submit"><i class="fa fa-check"></i> Aktifkan Tahun Ajaran <?php echo $tahun_ajaran->tahun; ?></button>
                        <?php else: ?>
                            <button class="btn btn-success btn-block" type="button" disabled><i class="fa fa-check"></i> Aktifkan Tahun Ajaran <?php echo $tahun_ajaran->tahun; ?></button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </section>

        <form action="" class="pull-right" method="post" id="form_delete_tahun_ajaran">
            <input type="hidden" name="submit_type" value="delete_tahun_ajaran">
            <input type="hidden" name="key" value="<?php echo sha1(date('ymdhis')); ?>">
            <button class="btn btn-xs btn-danger"><i class="fa fa-times"></i> hapus tahun_ajaran</button>
        </form>


<?php include('inc/footer.php'); ?>


<script>

    $('#u-tahun_ajaran').click(function(){
        $("html, body").animate({ scrollTop: $('#section-3').offset().top }, 1000);
    });

    $("#form_delete_tahun_ajaran").submit(function(){
        var c = confirm("Apakah anda yakin menghapus tahun_ajaran ini?")

        if(c == false)
        {
            return false;
        }
    });
</script>