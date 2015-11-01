<?php

ob_start();
session_start();
require_once('../lib/connection.php');
require_once('../lib/unleashed.lib.php');
require_once('../lib/login.php');

require_once('inc/header.php');

    $success = '';
    $error = '';

    // post tambah
    if(array_key_exists('key', $_POST))
    {
        $submit_type = $_POST['submit_type'];
        if($submit_type == 'tambah')
        {
            $kode_lokasi = $_POST['kode'];
            $filename = null;

            // simpan data ke database
            $q = sprintf("INSERT INTO siswa (
                    rfid,
                    nis,
                    nama,
                    jk,
                    id_guru,
                    created_at
                    )
                    VALUES('%s', '%s', '%s', '%s', '%s', '%d')",
                escape($_POST['rfid']),
                escape($_POST['nis']),
                escape($_POST['nama']),
                escape($_POST['jk']),
                $_SESSION['logged_id'],
                now()
            );

            // jalankan query
            $r = mysql_query($q);

            if(!$q)
                $error = 'Kesalahan Server';
            else
            {
                redirect('siswa.php');
            }
        }
    }

?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Siswa
            <small>Tambah Siswa</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="index.php"><i class="fa fa-users"></i> Siswa</a></li>
            <li class="active">Tambah Siswa</li>
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

        <!-- Tambah Lokasi-->
        <section>
                <!-- TO DO List -->
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="ion ion-clipboard"></i>
                        <h3 class="box-title">Tambah Siswa</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body" id="form-t-distro">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="rfid">RFID</label>
                                    <input type="text" class="form-control" name="rfid" id="rfid" placeholder="Tap RFID" readonly required="">
                                </div>
                                <div class="form-group">
                                    <label for="nis">NIS</label>
                                    <input type="text" class="form-control" name="nis" id="nis" placeholder="Nomor Induk Siswa" required="">
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input class="form-control" name="nama" id="nama" placeholder="Nama" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Jenis Kelamin</label>
                                    <select name="jk" required class="form-control">
                                        <option value="">--Pilih Jenis Kelamin--</option>
                                        <option value="l">Laki-Laki</option>
                                        <option value="p">Perempuan</option>
                                    </select>
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer clearfix no-border">
                                <input type="hidden" name="key" value="<?php echo sha1(date('ymdhis')); ?>">
                                <input type="hidden" name="submit_type" value="tambah">
                                <button class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Tambah</button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box -->
        </section><!-- ./Tambah-lokasi -->

    </section><!-- /.content -->

<?php include('inc/footer.php'); ?>

<script type="text/javascript">
    $("textarea[name=deskripsi]").wysihtml5({
        "font-styles": false, //Font styling, e.g. h1, h2, etc. Default true
        "emphasis": true, //Italics, bold, etc. Default true
        "lists": false, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
        "html": false, //Button which allows you to edit the generated HTML. Default false
        "link": false, //Button to insert a link. Default true
        "image": false, //Button to insert an image. Default true,
        "color": false //Button to change color of font
    });
</script>