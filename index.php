<?php
    $title = 'Home' ;
?>
<?php include("inc/header.php"); ?>

    <section id="home-header">
        <div  class="container">
            <div class="big-title">SMK Negeri 6</div>
            <div class="big-subtitle">Kota Garut</div>

            <div class="row">
                <div class="col-md-8">
                    <h2>Absensi</h2>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="col-md-4">
                    <input type="text" name="rfid" class="form-control input-lg" placeholder="Tap Kartu">
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