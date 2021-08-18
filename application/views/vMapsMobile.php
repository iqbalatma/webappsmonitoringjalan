<!-- -------------------------------------------------------------------------------------------------------------------------- -->
<!-- BODY HTML -->

<body id="page-top">
    <div class="container-sm">
        <select class="custom-select custom-select-sm fixed-top" name="selectoption" id="selectoption">
            <option selected>Pilih tampil data</option>
            <option value="1">Jalan Rusak Terverifikasi</option>
            <option value="2">Jalan Rusak Belum Terverifikasi</option>
            <option value="3">Jalan Tidak Rusak Terverifikasi</option>
            <option value="4">Jalan yang Diperbaiki</option>
        </select>
    </div>
    <div id="map"></div>
    <!-- Modal untuk mengubah status jalan -->
    <div class="modal" tabindex="-1" id="myModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kondisi Jalan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Status</label>
                        <input type="text" class="form-control" id="status" name="status" aria-describedby="emailHelp" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Verifikasi</label>
                        <input type="text" class="form-control" id="verifikasi" name="verifikasi" aria-describedby="emailHelp" value="" disabled>
                    </div>
                    <div class="input-group mb-3 mt-3">
                        <img class="mx-auto d-block" src="" width="400px" id="img" alt="">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>

            </div>
        </div>
    </div>
</body>
<!-- -------------------------------------------------------------------------------------------------------------------------- -->




<!-- -------------------------------------------------------------------------------------------------------------------------- -->
<!-- FOOTER UNTUK LOAD JAVASCRIPT -->
<?php require('TemplateMap/footer.php'); ?>
<!-- -------------------------------------------------------------------------------------------------------------------------- -->


<!-- GENERAL FUNCTION -->
<script type="text/javascript">
    //event untuk select option
    $('select').on('change', function() {
        var id_select = this.value;
        window.location.replace(object_leaflet.main_url + "maps/petadigital/" + id_select);
    });
</script>


<!-- MARKER CLUSTER DATA -->
<script type="text/javascript">
    var addressPoints = <?= json_encode($data_jalan_rusak); ?>;
    new MarkerclusterClass(addressPoints);
</script>


<!-- UPHILL ROAD -->
<script>
    var dataJalanMenanjak = <?= json_encode($data_jalan_menanjak); ?>;
    new UphillClass(dataJalanMenanjak);
</script>


</html>