</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Sambas 2021</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->


</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- INISIASI DATA -->

<script>
    const main_url = "<?= base_url(); ?>";
</script>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url(); ?>/assets/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url(); ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url(); ?>/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url(); ?>/assets/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?= base_url(); ?>/assets/vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= base_url(); ?>/assets/js/demo/chart-area-demo.js"></script>
<script src="<?= base_url(); ?>/assets/js/demo/chart-pie-demo.js"></script>

<!-- data tables -->
<script src="<?= base_url(); ?>/assets/vendor/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url(); ?>/assets/vendor/datatables/dataTables.bootstrap4.js"></script>

<!-- MarkerCluster -->

<!-- Make sure you put this AFTER Leaflet's CSS -->
<!-- LOADER -->
<script type="module" src="<?= base_url(); ?>/assets/heightgraph/src/L.Control.Heightgraph.js"></script>
<script src="<?= base_url(); ?>/assets/Leaflet.markercluster-1.4.1/dist/leaflet.markercluster-src.js"></script>


</body>





<!-- CATATAN SEKARANG
    Inisiasi map sudah dipisahkan, marker cluster juga sudah dipisahkan, heightgraph juga terpisah. tinggal menggabungkan ketiganya menjadi gabungan yang terintegrasi
    Jangan lupa revisi class diagram dan sequence diagram, jangan ngurusin coding mulu -->

<!-- INISIASI CODE UNTUK MEMANGGIL MAP -->
<script type="text/javascript" src="<?= base_url(); ?>/assets/js/inisiasimap.js"></script>






<!-- DATA MARKER CLUSTER -->
<script type="text/javascript">
    var data_jalan_rusak = <?php echo json_encode($data_jalan_rusak); ?>;
    var addressPoints = data_jalan_rusak
    console.log("haha")
    console.log(data_jalan_rusak)
</script>
<script type="text/javascript" src="<?= base_url(); ?>/assets/js/markercluster.js"></script>




<!-- HEIGHTGRAPH CODE-->
<script type="text/javascript">
    var data_altitude = <?php echo json_encode($data_altitude); ?>;
    var final_altitude = [];
    for (let i = 0; i < data_altitude.length; i++) {
        final_altitude.push([data_altitude[i][1], data_altitude[i][0], data_altitude[i][2]]);
    }
    console.log(final_altitude);
</script>

<script type="text/javascript">
    const geojson1 = [{
        "type": "FeatureCollection",
        "features": [{
            "type": "Feature",
            "geometry": {
                "type": "LineString",
                "coordinates": final_altitude
            },
            "properties": {
                "attributeType": 0
            }
        }, ],
        "properties": {
            "Creator": "OpenRouteService.org",
            "records": 10,
            "summary": "surface",
            "label": "Surface"
        }
    }];
</script>

<script type="text/javascript" src="<?= base_url(); ?>/assets/js/heightgraph.js"></script>
<script>
    $(document).ready(function() {
        $('#tabel-data').DataTable();
    });
</script>

</html>