<?php
    ob_start();
    session_start();
    require_once('../lib/connection.php');
    require_once('../lib/unleashed.lib.php');
    require_once('../lib/login.php');

    if(isset($_GET['id']))
    {
        $id = escape($_GET['id']);
        $q = mysql_query("SELECT *, pelajaran.nama as nama_pelajaran, kelas.nama as nama_kelas, kelas.tingkat as tingkat_kelas, kelas.tahun as tahun_kelas FROM absensi
                            JOIN pelajaran ON pelajaran.id=absensi.id_pelajaran
                            JOIN kelas ON kelas.id=absensi.id_kelas
                            WHERE absensi.id='$id' LIMIT 1");
        $absensi = mysql_fetch_object($q);

        $q_absensi_detail = mysql_query("SELECT * FROM absensi_detail
                                            JOIN siswa ON siswa.id=absensi_detail.id_siswa
                                            WHERE absensi_detail.id_absensi='$id'
                                            ORDER BY absensi_detail.created_at DESC");
    }


    // submitter
    if(array_key_exists('key', $_POST))
    {
        $submit_type = $_POST['submit_type'];
        switch($submit_type)
        {
            case 'tambah_absensi':

                $q_t_event = sprintf("INSERT INTO absensi(id_guru, tanggal, keterangan, created_at)
                                        VALUES('%s', '%s', '%s', '%s')",
                                        $_SESSION['logged_id'],
                                        now(),
                                        escape($_POST['keterangan']),
                                        now()
                );

                $r_t_event = mysql_query($q_t_event);
                if(!$r_t_event)
                    $error = 'Gagal Tambah Absensi';
                else
                {
                    $id = mysql_insert_id();
                    redirect("abasensi_detail.php?id=$id");
                }
                break;
        }
    }

    require_once('inc/header.php');


?>

    <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Absensi <?php echo $absensi->nama_pelajaran; ?> <?php echo $absensi->tingkat_kelas.'-'.$absensi->nama_kelas; ?>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">Absensi</li>
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
                                    <h3 class="box-title">List Siswa</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table datatable">
                                        <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Jam Masuk</th>
                                            <th>Tanggal</th>
                                        </tr>
                                        </thead>
                                        <tbody id="list-siswa">
                                        <?php
                                        $date_now = date('y-m-d');
                                        while($d_absensi_detail = mysql_fetch_object($q_absensi_detail)):
                                            ?>
                                            <tr id="<?php echo $d_absensi_detail->id; ?>">
                                                <td><?php echo $d_absensi_detail->nama; ?></td>
                                                <td><?php echo $d_absensi_detail->jam_masuk; ?></td>
                                                <td><?php echo tanggal_format_indonesia($d_absensi_detail->tanggal); ?></td>
                                            </tr>
                                        <?php
                                        endwhile;
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- /.box -->
                        </section><!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-4 connectedSortable">

                            <!-- Kategori List List -->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">Tambah Absensi</h3>
                                </div><!-- /.box-header -->
                                <div class="list-group">
                                    <div class="clock">
                                        <div id="Date"></div>
                                        <ul>
                                            <li id="hours"></li>
                                            <li id="point">:</li>
                                            <li id="min"></li>
                                            <li id="point">:</li>
                                            <li id="sec"></li>
                                        </ul>
                                    </div>
                                    <input type="text" name="rfid" class="form-control input-lg" placeholder="Tap Kartu" readonly id="home-rfid">
                                    <input type="hidden" name="id_absensi" id="id_absensi" value="<?php echo $absensi->id; ?>">
                                    <div class="list-group-item">
                                        <h3>Detail Siswa</h3>
                                    </div>
                                    <div class="list-group-item">
                                        <strong>NIS</strong>
                                        <h3 class="absensi-nis"></h3>
                                    </div>
                                    <div class="list-group-item">
                                        <strong>Nama</strong>
                                        <h3 class="absensi-nama"></h3>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </section><!-- right col -->
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->

<?php include('inc/footer.php'); ?>
<script type="text/javascript" src="../assets/js/jquery.rfid.js"></script>

<script type="text/javascript">
    var timer;
    function myTimer() {
        var sec = 0.5;

        clearInterval(timer);
        timer = setInterval(function() {
            $('#timer').text(sec--);
            if (sec == -0.5) {
                clearInterval(timer);
                $('#home-rfid').val('');
                $('.absensi-nis').text('');
                $('.absensi-nama').text('');
                $('.absensi-kelas').text('');
                $('.absensi-keterangan').text('');
                $('#home-rfid').focus();
            }
        }   , 1000);

    }

    myTimer();

    // Parses raw scan into name and ID number
    var rfidParser = function (rawData) {
//        console.log(rawData);
        if (rawData.length != 11) return null;
        else return rawData;

    };

    // Called on a good scan (company card recognized)
    var goodScan = function (cardData) {
        $("#home-rfid").val(cardData.substr(0,10));

        var rfid = $("#home-rfid").val();
        var id_absensi = $("#id_absensi").val();

        $.ajax({
            url: base_url + 'services/absensi_kelas_by_rfid.php',
            type: 'post',
            data: {
                rfid: rfid,
                id_absensi: id_absensi
            },
            dataType: 'json',
            success: function(data){
                if(data.status == true)
                {
                    $('.absensi-nis').text(data.nis);
                    $('.absensi-nama').text(data.nama);
                    $('.absensi-keterangan').text(data.keterangan);

                    var tr = "<tr id='" + data.id_absensi + "'>" +
                        "<td>" + data.nama +"</td>" +
                        "<td>" + data.time_now +"</td>" +
                        "<td>" + data.date_now +"</td>";

                    if(data.absensi == true)
                    {
                        $(tr).prependTo('#list-siswa');
                    }

                    myTimer();
                }
                else
                {
                    $('#home-rfid').val('');
                    $('.absensi-nis').text('');
                    $('.absensi-nama').text('');
                    $('#home-rfid').focus();
                }

            }

        });

    };

    // Called on a bad scan (company card not recognized)
    var badScan = function() {
        console.log("Bad Scan.");
    };

    // Initialize the plugin.
    $.rfidscan({
        parser: rfidParser,
        success: goodScan,
        error: badScan
    });
</script>
