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
        case 'tambah_tahun_ajaran':

            $tahun_ajaran = escape($_POST['tahun1']).'-'.escape($_POST['tahun2']);

            $q_t_tahun_ajaran = sprintf("INSERT INTO tahun_ajaran(tahun)
                                        VALUES('%s')",
                $tahun_ajaran
            );

            $r_t_tahun_ajaran = mysql_query($q_t_tahun_ajaran);

            if(!$r_t_tahun_ajaran)
                $error = 'Gagal Tambah tahun ajaran';
            else
            {
                redirect('tahun_ajaran.php?sukses_tambah_tahun_ajaran=true');
            }
            break;
    }
}

require_once('inc/header.php');

?>


<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Tahun Ajaran
    </h1>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Tahun Ajaran</li>
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
                    <h3 class="box-title">List Tahun Ajaran</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table class="table datatable-simple">
                        <thead>
                        <tr>
                            <th>Tahun</th>
                            <th>Aktif</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $q = "SELECT * FROM tahun_ajaran ORDER BY tahun ASC";
                        $r = mysql_query($q);
                        while($d = mysql_fetch_object($r)):
                            ?>
                            <tr>
                                <td><?php echo $d->tahun; ?></td>
                                <td><?php echo $d->is_aktif; ?></td>
                                <td>
                                    <div class="btn-group btn-group-xs">
                                        <a href="tahun_ajaran_detail.php?id=<?php echo $d->id; ?>" class="btn btn-warning"><i class="fa fa-edit"></i> </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.box -->
        </section><!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-4 connectedSortable">
            <?php if($logged_user_level == '1'): ?>
            <!-- Kategori List List -->
            <div class="box box-primary">
                <div class="box-header">
                    <i class="ion ion-clipboard"></i>
                    <h3 class="box-title">Tambah Tahun Ajaran</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Tahun</label>
                            <div class="row">
                                <div class="col-md-5"><input type="text" class="form-control" name="tahun1" required="" placeholder="Dari"></div>
                                <div class="col-md-2">-</div>
                                <div class="col-md-5"><input type="text" class="form-control" name="tahun2" required="" placeholder="Sampai"></div>
                            </div>
                        </div>
                        <button class="btn btn-primary">Simpan</button>
                        <input type="hidden" name="key" value="<?php echo crypt('romanov', '$1$sinkyousei$'); ?>">
                        <input type="hidden" name="submit_type" value="tambah_tahun_ajaran">
                    </form>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </section><!-- right col -->
        <?php endif; ?>
    </div><!-- /.row (main row) -->

</section><!-- /.content -->

<?php include('inc/footer.php'); ?>
