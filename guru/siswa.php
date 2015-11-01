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
            // cek unique kode

            $upload_stat = TRUE;

            // jika ada foto
            if(count($_FILES) != 0)
            {
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
                }
            }
            // jika upload_stat tidak FALSE
            if($upload_stat != FALSE)
            {
                // simpan data ke database
                $q = sprintf("INSERT INTO lokasi (
                        kode_lokasi,
                        nama,
                        alias,
                        alamat,
                        kota,
                        lg,
                        lt,
                        tahun,
                        deskripsi,
                        foto_link,
                        tipe_lokasi,
                        id_admin,
                        createdAt
                        )
                        VALUES('%s',UPPER('%s'),UPPER('%s'),UPPER('%s'),UPPER('%s'),'%f','%f','%s','%s','%s',UPPER('%s'),'%d','%s')",
                    $kode_lokasi,
                    escape($_POST['nama']),
                    escape($_POST['alias']),
                    escape($_POST['alamat']),
                    escape($_POST['kota']),
                    escape($_POST['longitude']),
                    escape($_POST['latitude']),
                    escape($_POST['tahun']),
                    escape($_POST['deskripsi']),
                    $filename,
                    escape($_POST['tipe_lokasi']),
                    1,
                    now()
                );

                // jalankan query
                $r = mysql_query($q);

                if(!$q)
                    $error = 'Kesalahan Server';
                else
                {
                    $id = mysql_insert_id(); // id terakhir

                    // masukan fasilitas
                    if(count($_POST['fasilitas']) != 0)
                    {
                        $fasilitas = $_POST['fasilitas'];
                        foreach($fasilitas as $f => $value):
                            $q_i_f = sprintf("INSERT INTO fasilitas_lokasi(
                                            id_fasilitas,
                                            id_lokasi,
                                            created_date
                                            )
                                           VALUES('%s', '%s', '%s')",

                                    $value,
                                    $id,
                                    now());
                            mysql_query($q_i_f);
                        endforeach;
                    }

                    // buat log file
                    $file_path = '../lib/tamankota-log.txt';
                    $message = "[".now()."]Added lokasi $id  by $logged_type $logged_id";
                    add_log($file_path, $message);
                    // refresh page
                    redirect("lokasi_detail.php?id=$id"); // redirect ke detail
                }
            }
        }
    }

?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Siswa
            <small>Listing</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Siswa</li>
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

        <section>
            <div class="box box-success">
                <div class="box-header">
                    <i class="fa fa-building"></i>
                    <h3 class="box-title">Siswa</h3>
                </div>
                <!-- List-Lokasi -->
                <?php
                $lokasi = get_all('siswa', 'nama');
                while($data = mysql_fetch_object($lokasi)):
                    ?>
                    <!-- lokasi -->
                    <a href="lokasi_detail.php?id=<?php echo $data->id; ?>">
                        <div class="list-group-item-lokasi list-group-item">
                            <p class="message">
                                <strong>
                                    <?php echo ucwords(strtolower($data->tipe_lokasi.' '.$data->nama)); ?>
                                    <span class="text-muted">
                                        <?php echo !empty($data->alias) ? ucwords(strtolower(' / '.$data->alias)) : ''; ?>
                                    </span>
                                </strong>
                                <br>
                                <?php echo $data->alamat; ?>
                            </p>
                        </div>
                    </a><!-- /.lokasi -->
                <?php endwhile; ?>
            </div>
        </section><!-- /.Listing lokasi -->
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