<?php
    $title = 'Home' ;
?>
<?php include("inc/header.php"); ?>

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
                            <th>Keterangan</th>
                        </tr>
                        </thead>
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