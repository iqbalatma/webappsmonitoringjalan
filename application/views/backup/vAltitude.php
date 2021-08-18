<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Ketinggian Jalan</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Content Row -->
    <div class="row">


        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-12 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">

                <div class="card-body">
                    <a href="<?= base_url(); ?>Dashboard/"><button type="button" class="mb-3 btn btn-primary">Data Jalan Rusak</button></a>

                    <table id="tabel-data" class="table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Nama Kecamatan</th>
                                <th>Altitude</th>
                                <th>ID Surveyor</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Nama Kecamatan</th>
                                <th>Altitude</th>
                                <th>ID Surveyor</th>
                                <th>Tanggal</th>
                            </tr>
                        </tfoot>
                        <tbody>

                            <?php
                            $i = 1;
                            foreach ($dataAccelerometer as $row) :
                            ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $row->latitude; ?></td>
                                    <td><?= $row->longitude; ?></td>
                                    <td><?= $row->kecamatan; ?></td>
                                    <td><?= $row->altitude; ?> Mdpl</td>
                                    <td><?= $row->device_id; ?></td>
                                    <td><?= $row->date; ?></td>
                                </tr>
                            <?php
                                $i++;
                            endforeach;
                            ?>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>


    </div>


</div>
<!-- /.container-fluid -->