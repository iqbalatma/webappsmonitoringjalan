<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Data Jalan</h1>
		<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
	</div>

	<!-- Content Row -->
	<div class="row">

		<!-- Earnings (Monthly) Card Example -->
		<div class="col-xl-12 col-md-6 mb-4">
			<div class="card border-left-primary shadow h-100 py-2">
				<div class="card-body">
					<table id="tabel-data" class="table table-striped table-bordered" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>No</th>
								<th>Latitude</th>
								<th>Longitude</th>
								<th>Sumbu X</th>
								<th>Sumbu Y</th>
								<th>Surveyor</th>
								<th>Status</th>
								<th>Tanggal</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>No</th>
								<th>Latitude</th>
								<th>Longitude</th>
								<th>Sumbu X</th>
								<th>Sumbu Y</th>
								<th>Surveyor</th>
								<th>Status</th>
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
									<td><?= $row->lat; ?></td>
									<td><?= $row->lon; ?></td>
									<td><?= $row->x_axis; ?></td>
									<td><?= $row->z_axis; ?></td>
									<td><?= $row->user_id; ?></td>
									<td><?= $row->status; ?></td>
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