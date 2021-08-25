<div class="row">
	<div class="col-xl-12 col-md-6 mb-4">
		<div class="card border-left-primary shadow h-100 py-2">
			<div class="card-body">
				<a href="<?= base_url(); ?>Dashboard/"><button type="button" class="mb-3 btn btn-primary">Data Jalan</button></a>
				<a href="<?= base_url(); ?>Dashboard/index/1"><button type="button" class="mb-3 btn btn-primary">Data Jalan Rusak</button></a>
				<a href="<?= base_url(); ?>Dashboard/index/2"><button type="button" class="mb-3 btn btn-primary">Data Jalan Rusak Terverifikasi</button></a>
				<a href="<?= base_url(); ?>Dashboard/index/3"><button type="button" class="mb-3 btn btn-primary">Data Jalan Diperbaiki</button></a>
				<table id="myTable" class="table table-striped table-bordered" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>No</th>
							<th>Latitude</th>
							<th>Longitude</th>
							<th>Nama Kecamatan</th>
							<th>Status</th>
							<th>Verifikasi</th>
							<th>Update Oleh</th>
							<th>Tanggal</th>
							<th>Gambar</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>No</th>
							<th>Latitude</th>
							<th>Longitude</th>
							<th>Nama Kecamatan</th>
							<th>Status</th>
							<th>Verifikasi</th>
							<th>Update Oleh</th>
							<th>Tanggal</th>
							<th>Gambar</th>
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
								<td><?= $row->status; ?></td>
								<td><?php
									if ($row->verifikasi == 0) {
										$verifikasi = "Belum Terverifikasi";
									} else {
										$verifikasi = "Terverifikasi";
									};
									echo $verifikasi;
									?></td>
								<td>
									<?php
									if (isset($row->update_by)) {
										$update_by = $row->update_by;
										$query = $this->db->query("SELECT * FROM users WHERE id = $update_by")->result_array();
										$update_by = ucwords($query[0]["fullname"]);
									} else {
										$update_by = "-";
									};
									echo $update_by;
									?></td>
								<td><?= $row->date; ?></td>
								<td><img src="<?= base_url() . $row->img_path ?>" width="200" alt=""></td>
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
<button onclick="playSound('http://monitoringjalansambas.my.id/assets/tes.mp3')">Play</button>