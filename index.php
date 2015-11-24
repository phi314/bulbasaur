<?php
    $title = 'Home' ;
include("inc/header.php");

require_once('lib/connection.php');
require_once('lib/unleashed.lib.php');

?>

    <section id="home-header">
        <div  class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="big-title">SMK Negeri 6</div>
                    <div class="big-subtitle">Kota Garut</div>
                </div>
                <div class="col-md-4">
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
                </div>
            </div>


            <div class="row">
                <div class="col-md-8">
                    <h2>Absensi</h2>
                    <table class="table datatable-noeverything">
                        <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                        </tr>
                        </thead>
                        <tbody id="list-absensi">
                        <?php
                            $date_now = date('y-m-d');
                            $q_absensi = mysql_query("SELECT * FROM absensi WHERE tanggal='$date_now' ORDER BY updated_at DESC");

                            while($d_absensi = mysql_fetch_object($q_absensi)):
                                $q_siswa = mysql_query("SELECT * FROM siswa WHERE id='$d_absensi->id_siswa' LIMIT 1");
                                $r_siswa = mysql_fetch_object($q_siswa);

                                $kelas = '';
                                if($r_siswa->id_kelas != 0)
                                {
                                    $q_kelas = mysql_query("SELECT * FROM kelas WHERE id='$r_siswa->id_kelas' LIMIT 1");
                                    $d_kelas = mysql_fetch_object($q_kelas);
                                    $kelas = $d_kelas->tingkat.'-'.$d_kelas->nama.' ('.$d_kelas->tahun.')';
                                }
                        ?>
                                <tr id="<?php echo $d_absensi->id; ?>">
                                    <td><?php echo $r_siswa->nama; ?></td>
                                    <td><?php echo $kelas; ?></td>
                                    <td><?php echo $d_absensi->jam_masuk; ?></td>
                                    <td><?php echo $d_absensi->jam_pulang; ?></td>
                                </tr>
                        <?php
                            endwhile;
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <input type="text" name="rfid" class="form-control input-lg" placeholder="Tap Kartu" readonly id="home-rfid">
                    <h1>Detail Siswa</h1>
                    <div class="list-group">
                        <div class="list-group-item">
                            <strong>NIS</strong>
                            <h3 class="absensi-nis"></h3>
                        </div>
                        <div class="list-group-item">
                            <strong>Nama</strong>
                            <h3 class="absensi-nama"></h3>
                        </div>
                        <div class="list-group-item">
                            <strong>Kelas</strong>
                            <h3 class="absensi-kelas"></h3>
                        </div>
                        <div class="list-group-item">
                            <strong>Keterangan</strong>
                            <h3 class="absensi-keterangan"></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<?php include("inc/footer.php"); ?>

<script type="text/javascript" src="assets/js/jquery.rfid.js"></script>

<script type="text/javascript">

    $(".datatable-noeverything").dataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": true
    });

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

        $.ajax({
            url: 'services/absensi_by_rfid.php',
            type: 'get',
            data: {
                rfid: rfid
            },
            dataType: 'json',
            success: function(data){
                if(data.status == true)
                {
                    $('.absensi-nis').text(data.nis);
                    $('.absensi-nama').text(data.nama);
                    $('.absensi-kelas').text(data.kelas);
                    $('.absensi-keterangan').text(data.keterangan);

                    var tr = "<tr id='" + data.id_absensi + "'>" +
                        "<td>" + data.nama +"</td>" +
                        "<td>" + data.kelas +"</td>" +
                        "<td>" + data.jam_masuk +"</td>" +
                        "<td>" + data.jam_pulang +"</td>";

                    if(data.absensi == true)
                    {
                        $('tr .dataTables_empty').hide();
                        $('tr#' + data.id_absensi).hide();
                        $(tr).prependTo('#list-absensi');
                    }

                    myTimer();
                }
                else
                {
                    $('#home-rfid').val('');
                    $('.absensi-nis').text('');
                    $('.absensi-nama').text('');
                    $('.absensi-kelas').text('');
                    $('.absensi-keterangan').text('');
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